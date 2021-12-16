<?php

declare(strict_types=1);

namespace App\Controller;

use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\View\RenderInterface;

#use Hyperf\Utils\ApplicationContext;
use Hyperf\DbConnection\Db;

use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

use Hyperf\HttpServer\Annotation\AutoController;

/**
 * @AutoController()
 */
class ToolsController extends BaseController
{
    public function index(RenderInterface $render,ResponseInterface $response,RequestInterface $request)
    {
        $tdk = [];
        $tdk['title'] = '在线工具-技术博客集';
        $tdk['keywords'] = '在线工具';
        $tdk['description'] = '在线工具,技术博客集(blog.zongscan.com)是一个提供各类主流程序开发语言程序教程,合适自学编程/建站seo/框架/前端/后端技术的同学收藏,交流,分享,项目架构分享';

        //最新文章
        $new_art = Db::table('art')->where('is_state',0)->where('is_del',1)->orderBy('pubtime','desc')->take(10)->get();
        //最热文章
        $hot_art = Db::table('art')->where('is_state',0)->where('is_del',1)->orderBy('view','desc')->take(10)->get();

        return $render->render('home/tools/index',
            [
                'tdk' => $tdk,
                'cats' => $this->cats,
                'new_art' => $new_art,
                'hot_art'=> $hot_art,
                'session' => $this->session->get('user')
            ]
        );
    }
    //生成二维码
    public function qrcode(RenderInterface $render)
    {
        $tdk = [];
        $tdk['title'] = '在线生成网址url二维码,QR code-技术博客集';
        $tdk['keywords'] = '在线生成网址url二维码,QR code';
        $tdk['description'] = '在线生成网址url二维码,QR code,在线工具,技术博客集(blog.zongscan.com)是一个提供各类主流程序开发语言程序教程,合适自学编程/建站seo/框架/前端/后端技术的同学收藏,交流,分享,项目架构分享';

        $q = $this->request->input('url')??'https://www.zongscan.com/';

        $writer = new PngWriter();
        // Create QR code
        $qrCode = QrCode::create($q)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));
        $result = $writer->write($qrCode);
        // Directly output the QR code
        header('Content-Type: '.$result->getMimeType());
        // Save it to a file
        //$result->saveToFile(__DIR__.'/qrcode.png');

        // Generate a data URI to include image data inline (i.e. inside an <img> tag)
        $dataUri = $result->getDataUri();

        return $render->render('home/tools/qrcode', ['tdk' => $tdk ,'img' => $dataUri,'cats' => $this->cats,]);
    }
    //自动发外链
    public function externallink(RenderInterface $render)
    {
        $tdk = [];
        $tdk['title'] = '自动生成外链,外链批量生成-技术博客集';
        $tdk['keywords'] = '自动生成外链,外链批量生成';
        $tdk['description'] = '自动生成外链,外链批量生成,在线工具,技术博客集(blog.zongscan.com)是一个提供各类主流程序开发语言程序教程,合适自学编程/建站seo/框架/前端/后端技术的同学收藏,交流,分享,项目架构分享';

        return $render->render('home/tools/externallink', ['tdk' => $tdk ,'cats' => $this->cats]);
    }
    //在线php代码运行
    public function phpcode(RenderInterface $render)
    {
        $tdk = [];
        $tdk['title'] = '在线运行php代码,在线工具-技术博客集';
        $tdk['keywords'] = '在线运行php代码,在线工具';
        $tdk['description'] = '在线运行php代码,在线工具,技术博客集(blog.zongscan.com)是一个提供各类主流程序开发语言程序教程,合适自学编程/建站seo/框架/前端/后端技术的同学收藏,交流,分享,项目架构分享';

        return $render->render('home/tools/phpcode', ['tdk' => $tdk ,'cats' => $this->cats,]);
    }
    public function runcode()
    {
        $code = $this->request->input('code');
        $code = trim($code, "<?php");

        ob_start();
        eval($code);
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    //在线生成短链接
    public function shortlinks(RenderInterface $render)
    {
        $tdk = [];
        $tdk['title'] = '在线生成短链接,短网址服务,短网址,在线工具-技术博客集';
        $tdk['keywords'] = '在线生成短链接,短网址服务,短网址';
        $tdk['description'] = '在线生成短链接,短网址服务,短网址,在线工具,技术博客集(blog.zongscan.com)是一个提供各类主流程序开发语言程序教程,合适自学编程/建站seo/框架/前端/后端技术的同学收藏,交流,分享,项目架构分享';

        $url = $this->request->input('url')??'1';
        $shorturl = '请看使用方式';

        if($url != 1){
            $shortcode = random_code(5);
            //查重 新赋
            $isshortcode = Db::table('longshorturl')->where('shortcode', $shortcode)->first();
            if($isshortcode){
                $shortcode = random_code(5);
            }
            $data['longurl'] = $url;
            $data['shortcode'] = $shortcode;
            $data['pubtime'] = time();

            $islongurl = Db::table('longshorturl')->where('longurl', $url)->first();
            if($islongurl) {
                $shorturl = $islongurl->shortcode;
            }else{
                Db::table('longshorturl')->insert($data);
                $shorturl = $shortcode;
            }
        }
        return $render->render('home/tools/shortlinks', ['tdk' => $tdk ,'cats' => $this->cats,'shorturl' => $shorturl]);
    }
    //长链接转短链接 跳转
    public function jumpurl(ResponseInterface $response,string $shortcode)
    {
        $res = Db::table('longshorturl')->where('shortcode', $shortcode)->first();
        if($res){
            return $response->redirect("{$res->longurl}");
        }
        return true;
    }
    
}
