<?php

/**
 * 打字特效，<a href="https://blog.imalan.cn" target="_blank">熊猫小A修改</a>
 * @package ActivatePowerMode
 * @author Hoe
 * @version 1.0.0
 * @link http://www.hoehub.com
 */
class ActivatePowerMode_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     *
     * @access public
     * @return void
     */
    public static function activate()
    {
        Typecho_Plugin::factory('Widget_Archive')->footer = array(__CLASS__, 'footer');
        Typecho_Plugin::factory('admin/write-post.php')->bottom = array(__CLASS__, 'pfooter');
        Typecho_Plugin::factory('admin/write-page.php')->bottom = array(__CLASS__, 'pfooter');
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     *
     * @static
     * @access public
     * @return void
     */
    public static function deactivate()
    {
    }

    /**
     * 获取插件配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        $jquery = new Typecho_Widget_Helper_Form_Element_Radio('jquery',
            ['0' => _t('不加载'), '1' => _t('加载')],
            '1', _t('是否加载外部jQuery库'), _t('插件需要jQuery库文件的支持，如果已加载就不需要加载了 jquery源是新浪Public Resources on SAE：https://lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js'));
        $form->addInput($jquery);
        $activeineditor=new Typecho_Widget_Helper_Form_Element_Radio('activeineditor',
        ['0' => _t('不启用'), '1' => _t('启用')],
        '1', _t('是否在后台启用'), _t('选择是否在文章与页面编辑界面启用本插件。'));
        $form->addInput($activeineditor);
        $colorful = new Typecho_Widget_Helper_Form_Element_Checkbox(
            'colorful',
            ['true' => _t('颜色效果')],
            ['true'],
            _t('开启颜色效果')
        );
        $form->addInput($colorful);
        $shake = new Typecho_Widget_Helper_Form_Element_Checkbox(
            'shake',
            ['true' => _t('振动效果')],
            ['true'],
            _t('开启振动效果')
        );
        $form->addInput($shake);
    }

    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form)
    {
    }

    /**
     * 插件实现方法
     *
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function render()
    {

    }

    /**
     *为footer添加js文件
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function footer()
    {
        $jquery = Helper::options()->plugin('ActivatePowerMode')->jquery;
        if($jquery) {
            echo '<script type="text/javascript" src="//lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js"></script>';
        }
        $colorful = Helper::options()->plugin('ActivatePowerMode')->colorful;
        $shake = Helper::options()->plugin('ActivatePowerMode')->shake;
        if ($colorful || $shake) {
            $jsUrl = Helper::options()->pluginUrl . '/ActivatePowerMode/static/activate-power-mode.js';
            printf("<script type='text/javascript' src='%s'></script>\n", $jsUrl); // 加载JS库
            $colorful = $colorful ? $colorful[0] : 'false';
            $shake = $shake ? $shake[0] : 'false';
            echo "<script type='text/javascript'>
                $(function() {
                    try {
                        console.log(` %c ActivatePowerMode %c https://blog.imalan.cn/archives/208/ `, `color: #fadfa3; background: #23b7e5; padding:5px;`, `background: #1c2b36; padding:5px;`);
                        (function(){
                            // input
                            POWERMODE.colorful = {$colorful}; // make power mode colorful 颜色
                            POWERMODE.shake = {$shake}; // turn off shake 振动
                            document.body.addEventListener('input', POWERMODE);
                        })();
                    } catch (e) {
                        console.log('打字特效插件出现错误:请联系www.hoehub.com');
                    }
                });
                </script>\n";
        }
    }

    public static function pfooter(){
        $activeineditor = Helper::options()->plugin('ActivatePowerMode')->activeineditor;
        if($activeineditor) {
            $colorful = Helper::options()->plugin('ActivatePowerMode')->colorful;
            $shake = Helper::options()->plugin('ActivatePowerMode')->shake;
            if ($colorful || $shake) {
                $jsUrl = Helper::options()->pluginUrl . '/ActivatePowerMode/static/activate-power-mode.js';
                printf("<script type='text/javascript' src='%s'></script>\n", $jsUrl); // 加载JS库
                $colorful = $colorful ? $colorful[0] : 'false';
                $shake = $shake ? $shake[0] : 'false';
                echo "<script type='text/javascript'>
                    $(function() {
                        try {
                            console.log(` %c ActivatePowerMode %c https://blog.imalan.cn/archives/208/ `, `color: #fadfa3; background: #23b7e5; padding:5px;`, `background: #1c2b36; padding:5px;`);
                            (function(){
                                // input
                                POWERMODE.colorful = {$colorful}; // make power mode colorful 颜色
                                POWERMODE.shake = {$shake}; // turn off shake 振动
                                document.body.addEventListener('input', POWERMODE);
                            })();
                        } catch (e) {
                            console.log('打字特效插件出现错误:请联系www.hoehub.com');
                        }
                    });
                    </script>\n";
            }    
        }
    }
}
