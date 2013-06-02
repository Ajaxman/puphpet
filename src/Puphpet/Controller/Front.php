<?php

namespace Puphpet\Controller;

use Puphpet\Controller;

use Puphpet\Domain;
use Silex\Application;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;

class Front extends Controller
{
    public function connect(Application $app)
    {
        /** @var $controllers ControllerCollection */
        $controllers = $app['controllers_factory'];

        $controllers->get('/', [$this, 'indexAction'])
            ->bind('homepage');

        $controllers->post('/create', [$this, 'createAction'])
            ->bind('create');

        $controllers->get('/about', [$this, 'aboutAction'])
            ->bind('about');

        $controllers->get('/help', [$this, 'helpAction'])
            ->bind('help');

        $controllers->get('/github-btn', [$this, 'githubbtnAction'])
            ->bind('github-btn');

        return $controllers;
    }

    public function indexAction(Request $request, Application $app)
    {
        $editionName = $request->query->get('edition', 'default');

        $availableEditions = $app['editions'];

        // validate edition name
        // use fallback if invalid edition name is requested (better than throwing any error)
        if (!array_key_exists($editionName, $availableEditions)) {
            $editionName = $app['edition_default'];
        }

        // fill the edition entity with requested configuration
        /**@var $edition Domain\Configuration\Edition */
        $edition = $app['edition'];
        $edition->setConfiguration($availableEditions[$editionName]);

        return $this->twig()->render(
            'Front/index.html.twig',
            [
                'currentPage' => 'home',
                'timezones'   => \DateTimeZone::listIdentifiers(),
                'edition'     => $edition,
            ]
        );
    }

    public function aboutAction()
    {
        return $this->twig()->render(
            'Front/about.html.twig',
            ['currentPage' => 'about']
        );
    }

    public function helpAction()
    {
        return $this->twig()->render(
            'Front/help.html.twig',
            ['currentPage' => 'help']
        );
    }

    public function githubbtnAction()
    {
        return $this->twig()->render('Front/github-btn.html.twig');
    }

    public function createAction(Request $request, Application $app)
    {
        /** @var Domain\Compiler\Manifest\RequestFormatter $formatter build puppet manifest */
        $formatter = $app['manifest_request_formatter'];
        $formatter->bindRequest($request);
        $manifestConfiguration = $formatter->format();

        /** @var Domain\Compiler\Compiler $manifestCompiler */
        $manifestCompiler = $app['manifest_compiler'];

        $webserver = $manifestConfiguration['webserver'];
        $database = $manifestConfiguration['database'];

        // build Vagrantfile
        $box = $request->request->get('box');
        $boxConfiguration = ['box' => $box];

        $templates = [
            'manifest'    => $manifestCompiler->compile($manifestConfiguration),
            'vagrantFile' => $this->twig()->render('Vagrant/Vagrantfile.twig', $boxConfiguration),
            'readme'      => $app['readme_compiler']->compile(array_merge($manifestConfiguration, $boxConfiguration)),
            'bashaliases' => $manifestConfiguration['server']['bashaliases'],
        ];

        return $this->generateFile($app, $templates, $box['name'], $webserver, $database);
    }

    /**
     * @param Application $app
     * @param array $templates
     * @param string $boxname
     * @param string $webserver
     * @param string $database
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    protected function generateFile(Application $app, array $templates, $boxname, $webserver, $database)
    {
        /**@var $domainFile Domain\File build the archive */
        $domainFile = $app['domain_file'];

        if ('nginx' == $webserver) {
            $domainFile->addModuleSource('nginx', VENDOR_PATH . '/jfryman/puppet-nginx');
        }

        if ('postgresql' == $database) {
            $domainFile->addModuleSource('postgresql', VENDOR_PATH . '/puppetlabs/postgresql');
        }

        // creating and building the archive
        $domainFile->createArchive(
            [
                'README'                                  => $templates['readme'],
                'Vagrantfile'                             => $templates['vagrantFile'],
                'manifests/default.pp'                    => $templates['manifest'],
                'modules/puphpet/files/dot/.bash_aliases' => $templates['bashaliases'],
            ]
        );
        $file = $domainFile->getArchivePath();

        $stream = function () use ($file) {
            readfile($file);
        };

        return $this->app->stream(
            $stream,
            200,
            [
                'Pragma'                    => 'public',
                'Expires'                   => 0,
                'Cache-Control'             => 'must-revalidate, post-check=0, pre-check=0',
                'Last-Modified'             => gmdate('D, d M Y H:i:s', filemtime($file)) . ' GMT',
                'Content-Type'              => 'application/zip',
                'Content-Length'            => filesize($file),
                'Content-Disposition'       => 'attachment; filename="' . $boxname . '.zip"',
                'Content-Transfer-Encoding' => 'binary',
                'Connection'                => 'close',
            ]
        );
    }
}
