
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"/>
    <title>高德地图API</title>
    <meta name="keywords" content="高德地图api,高德api,高德地图API,高德云图,map api,高德LBS开放平台,高德开放平台,地图开发,代码,O2O,LBS+,P2P,APP,POI,坐标转换,解决方案,成功案例,云图 "/>
    <meta name="description" content="高德开放平台，为开发者提供免费的地图解决方案，覆盖JavaScript、Android、iOS、Windows、Webservice等平台，包含全球定位、数据检索、路线规划、实时导航、室内地图、街景等LBS功能。推广零成本开发工具：高德云图，将自有数据一键生成自定义地图，并自动适配PC端与移动端；地图组件，一句话搞定web地图；全球定位，体积最小、耗电量最低的定位SDK。"/>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <link rel="shortcut icon" href="https://lbs.amap.com//dev/web/public/images/favicon.ico?t=20160513"/>
    <link href="https://lbs.amap.com//web/public/dist/lib/iconfont/iconfont.b4d438.css" rel="stylesheet">
    <link href="https://lbs.amap.com//web/public/dist/lib/bootstrap.min.fa1e86.css" rel="stylesheet">
    <link href="https://lbs.amap.com//web/public/dist/common/common.2a61e8.css" rel="stylesheet">
    <link href="https://lbs.amap.com//web/public/dist/main.068f0d.css" rel="stylesheet"></head>
<body>

<script type="text/javascript" src="https://lbs.amap.com//console/public/jquery-1.11.1.min.js"></script>
<div class="page_wrapper">
    <div class="main_content">
        <style>
            #wrapper{margin:0 auto;font-size:12px}#wrapper *{box-sizing:content-box}#bSideLeft,#bSideRight{float:left;width:324px;height:645px;border:1px solid #e0edf4;background-color:#FFF}#bSideRight{float:right;width:602px;height:602px;overflow:auto;position:relative;padding:20px 15px}.clear{clear:both;float:none;font-size:0;height:0}.hide{display:none!important}.clearfix{*zoom:1}.clearfix:before,.clearfix:after{display:table;line-height:0;content:""}.clearfix:after{clear:both}.pull-left{float:left}.pull-right{float:right}#navTabs{margin:0;padding:0;list-style:none;height:53px;overflow:hidden;background-color:#f7f7f7}#navTabs li{list-style:none;width:33.334%;float:left}#navTabs li a{display:block;height:51px;line-height:51px;border:1px solid #e6e6e6;border-left-width:0;padding-left:13px;text-align:center;text-decoration:none;color:#000;background:url(/console/public/show/bg.32.png) -403px 19px no-repeat}#navTabs li a.step2{background-position:-403px -31px}#navTabs li a.step3{background-position:-403px -82px}#navTabs li a.selected{border-bottom-color:#FFF;background-color:#FFF}#navTabs li a:hover,#navTabs li a:focus{background-color:#FFF}#leftContent{padding:20px 15px 15px;height:557px}#leftContent label{margin:0}table.map-style{width:100%;border-collapse:collapse}table.map-style th,table.map-style td{border-bottom:1px solid #EEE;padding:7px 0 8px}table.map-style tr.first-child th,table.map-style tr.first-child td{padding-top:0}table.map-style input{margin:0 5px 0 0}table.map-style input[type=radio],table.map-style input[type=checkbox]{vertical-align:-3px}table.map-style th{width:80px;vertical-align:middle}table.map-style th div{height:20px;width:60px;padding-top:50px;text-align:center;color:#0075c2;font-weight:normal;background:url(/console/public/show/bg.32.png) -172px 0 no-repeat}table.map-style td div{padding:2px 0;color:#333;position:relative;*padding:1px 0}table.map-style td h6{color:#000;font-weight:bold;font-size:12px;display:inline-block;width:30px;margin:1px 2px;*display:inline}table.map-style .fixed-label-width label{width:80px;display:inline-block}table.map-style .map-layer-bg{font-size:0;padding-bottom:8px}table.map-style .map-layer-bg label{padding:0 30px;display:inline-block;height:26px;line-height:26px;border:1px solid #ccc;overflow:hidden;font-size:12px}table.map-style .map-layer-bg label.selected{border-bottom-color:#FFF}table.map-style .map-layer-bg label.first-child{border-right-width:0}table.map-style .map-layer-bg input{position:absolute;top:-1000px;left:-1000px}table.map-style tr.map-size input[type=text]{width:40px}table.map-style tr.map-status th div{background-position:-112px 0}table.map-style tr.map-view th div{background-position:8px -96px}table.map-style tr.map-scale th div{background-position:-54px -96px}table.map-style tr.map-layer th div{background-position:8px 8px}table.map-style tr.map-toolbar th div{background-position:-46px 2px}#msg3dInfo{position:absolute;font-size:12px;color:red;top:14px;left:18px}#addOverlayTypes{padding:15px 0;overflow:hidden;white-space:nowrap;border-bottom:1px solid #e0e0e0}#addOverlayTypes a{width:56px;height:56px;display:inline-block;border:1px #e0e0e0 solid;margin:0 18px;background:url(/console/public/show/bg.32.png) -226px 6px no-repeat #f7f7f7}#addOverlayTypes a.overlay-polyline{background-position:-294px 5px}#addOverlayTypes a.overlay-polygon{background-position:-352px 8px}#addOverlayTypes a.select{background-color:#f5f5f5;border:2px solid #7ca7e6}#addOverlayTypes a:hover{background-color:#e0e0e0}#mapContainer{width:600px;height:600px;border:1px #DDD solid;margin:0 auto;position:relative}#mapContainer .marker{background:url(/console/public/show/marker.png) no-repeat;cursor:pointer}#mapContainer .marker-cir{height:31px;width:28px}#mapContainer .marker-cir-red{background-position:-11px -5px}#mapContainer .marker-cir-blue{background-position:-11px -55px}#mapContainer .marker-cir-yellow{background-position:-11px -105px}#mapContainer .marker-cir-green{background-position:-11px -155px}#mapContainer .marker-cir-gray{background-position:-11px -205px}#mapContainer .marker-flg{height:32px;width:29px}#mapContainer .marker-flg-red{background-position:-65px -5px}#mapContainer .marker-flg-blue{background-position:-65px -55px}#mapContainer .marker-flg-yellow{background-position:-65px -105px}#mapContainer .marker-flg-green{background-position:-65px -155px}#mapContainer .marker-flg-gray{background-position:-65px -205px}#mapContainer .marker-anc{height:28px;width:26px}#mapContainer .marker-anc-red{background-position:-132px -7px}#mapContainer .marker-anc-blue{background-position:-132px -57px}#mapContainer .marker-anc-yellow{background-position:-132px -107px}#mapContainer .marker-anc-green{background-position:-132px -157px}#mapContainer .marker-anc-gray{background-position:-132px -207px}#mapContainer .marker-twig{width:27px;height:30px}#mapContainer .marker-twig-red{background-position:-187px -7px}#mapContainer .marker-twig-blue{background-position:-187px -57px}#mapContainer .marker-twig-yellow{background-position:-187px -107px}#mapContainer .marker-twig-green{background-position:-187px -157px}#mapContainer .marker-twig-gray{background-position:-187px -207px}#mapContainer .marker-pot{width:23px;height:31px}#mapContainer .marker-pot-red{background-position:-234px -5px}#mapContainer .marker-pot-blue{background-position:-234px -55px}#mapContainer .marker-pot-yellow{background-position:-234px -105px}#mapContainer .marker-pot-green{background-position:-234px -155px}#mapContainer .marker-pot-gray{background-position:-234px -205px}#iwWrap{width:280px;min-height:40px}#iwWrap .iw-title{height:20px;line-height:20px;overflow:hidden;font-weight:bold;text-overflow:ellipsis;word-break:break-all;word-wrap:break-word;white-space:nowrap}#iwWrap .iw-content{min-height:20px;line-height:20px}.modal-backdrop{position:fixed;_position:absolute;top:0;left:0;width:100%;height:100%;z-index:1000;background-color:#000;opacity:.25;filter:alpha(opacity=25)}.modal-dialog{position:fixed;z-index:2000;border:1px solid gray;padding:5px 8px;background-color:white;font-size:12px;left:50%;width:1024px;margin-left:-512px;top:32px;height:515px;_position:absolute;_top:50%;_margin-top:-260px;text-align:left}.modal-dialog .head{height:30px;padding:5px 0 10px}.modal-dialog .title{float:left;width:200px;font-weight:bold;font-size:16px;color:#0075c2;text-align:center;height:30px;line-height:30px}.modal-dialog a.m-btn{float:right;margin:0 8px 0 30px;background-color:#0075c2;color:#FFF;height:30px;line-height:30px;padding:0 20px;text-decoration:none;font-size:14px;font-weight:bold}.modal-dialog a.m-btn-inverse{background-color:#e0e0e0}.modal-dialog a.m-btn:hover,.modal-dialog a.m-btn:focus{background-color:#3391ce}.modal-dialog a.m-btn-inverse:hover,.modal-dialog a.m-btn-inverse:focus{background-color:#999}.modal-dialog .content{float:none;height:460px;width:100%;overflow:auto;padding:0;border:1px solid #DDD}.modal-dialog .syntaxhighlighter{margin:6px 0 0 0!important}.modal-dialog .syntaxhighlighter{height:100%!important}.modal-dialog .syntaxhighlighter table td.code .alt1{background-color:#f9f9f9!important}.modal-dialog .syntaxhighlighter table td.code .line:hover{background-color:#f3f3f3!important}.modal-dialog .syntaxhighlighter table td.code .line{padding:0 .6em!important}#codeResult{height:90px;line-height:90px;background-color:#FFF;margin-top:20px;text-align:center}#codeResult a{display:inline-block;height:40px;line-height:40px;padding:0 36px;color:#FFF;font-weight:bold;background-color:#0075c2;margin:0 20px;text-decoration:none}#codeResult a.btn-inverse{background-color:#e0e0e0}#codeResult a:hover,#codeResult a:focus{background-color:#3391ce}#codeResult a.btn-inverse:hover,#codeResult a.btn-inverse:focus{background-color:#999}#overLaysListScroll{height:390px;overflow:hidden}.overlays-list-title{font-weight:bold;padding:12px 0}.overlays-list-item{margin-bottom:10px}.overlays-list-item .overlays-item{border:1px #e0e0e0 solid;height:34px;line-height:34px}.open-overlay .overlays-item{border-color:#7ca7e6}.overlays-item .overlays-icon{display:inline-block;width:20px;height:20px;padding:7px 6px;background:url(/console/public/show/bg.32.png) -410px -143px no-repeat}.overlays-item .overlays-btn{float:right;_display:inline-block;margin-right:10px;text-decoration:underline;color:#196eab;cursor:pointer}.overlays-item .polyline-icon{background-position:-413px -194px}.overlays-item .polygon-icon{background-position:-413px -242px}.overlays-item .overlays-title{width:170px;overflow:hidden;text-overflow:ellipsis;word-break:break-all;word-wrap:break-word;white-space:nowrap}.overlays-set{padding:14px 18px;border:1px #7ca7e6 solid;border-top:0}.overlays-set .hr{height:0;font-size:0;border:1px solid #CCC;margin:12px 0}.overlays-set-content .overlays-name{width:232px;height:16px;border:1px #d2d2d2 solid;margin-bottom:10px;padding:5px}.overlays-set-content .overlays-info{width:232px;height:65px;border:1px #d2d2d2 solid;padding:5px;resize:none}.overlays-set-content .polyline-style-set{border-bottom:0;margin-bottom:0;padding-bottom:0}.marker-icon-set{margin-top:5px}.marker-icon-set a{width:26px;height:26px;float:left;margin:0 10px;border:1px #FFF solid;background:url(/console/public/show/marker-select.png) no-repeat}.marker-icon-set a:hover,.marker-icon-set a.select{background-color:#f7f7f7;border-color:#e0e0e0}.marker-icon-set a.marker-cir-gray{background-position:2px -166px}.marker-icon-set a.marker-flg-gray{background-position:-36px -166px}.marker-icon-set a.marker-anc-gray{background-position:-76px -166px}.marker-icon-set a.marker-twig-gray{background-position:-112px -166px}.marker-icon-set a.marker-pot-gray{background-position:-150px -166px}.overlays-color-set{margin-top:8px;overflow:hidden;zoom:1}.overlays-color-set a{width:26px;height:26px;float:left;margin:0 10px;border:1px #FFF solid}.overlays-color-set a:hover,.overlays-color-set a.select{border-color:#000}.overlays-color-set a.overlays-red{background:#f0202f}.overlays-color-set a.overlays-blue{background:#19a4eb}.overlays-color-set a.overlays-yellow{background:#ffcc02}.overlays-color-set a.overlays-green{background:#089a72}.overlays-color-set a.overlays-gray{background:#BBB}.marker-lnglat-set{margin-top:10px}.marker-lnglat-set input{display:inline-block;height:16px;width:100px;border:1px #d2d2d2 solid;margin:0 10px 10px 0;padding:5px;color:#b5b5b5}.polyline-shape-list{margin-top:5px}.polyline-shape-list a{width:26px;height:26px;float:left;margin:0 10px;border:1px #FFF solid;background:url(/console/public/show/bg.32.png) 0 -179px no-repeat}.polyline-shape-list a:hover,.polyline-shape-list a.select{background-color:#f7f7f7;border-color:#e0e0e0}.polyline-shape-list .shape1{background-position:-38px -179px}.polyline-shape-list .shape2{background-position:-75px -179px}.polyline-shape-list .shape3{background-position:-113px -179px}.polyline-shape-list .shape4{background-position:-151px -179px}.overlays-opacity-set{margin-top:16px;width:234px}.overlays-opacity-set .bar{height:40px;margin-top:10px;position:relative;-moz-user-select:none;-webkit-user-select:none;-ms-user-select:none;user-select:none}.overlays-opacity-set .track{height:9px;position:relative;border-top:1px #e0e0e0 solid;background:#f0f0f0}.overlays-opacity-set .drag{position:absolute;height:7px;width:12px;top:6px;left:0;cursor:pointer;background:url(/console/public/show/bg.32.png) 0 -250px no-repeat}.overlays-opacity-set .values{margin-top:10px}.overlays-opacity-set .values .min{float:left}.overlays-opacity-set .values .max{float:right}.overlays-opacity-set .values .value{text-align:center}#locationContent{position:relative}#locationContent .select-city{height:30px;line-height:28px;position:relative;z-index:2}#btnCurrentCity{text-decoration:none;color:#333;display:inline-block;height:28px;padding:0 28px 0 15px;background:#fff url(/console/public/show/bg.32.png) right -288px no-repeat;border:1px solid #999}#btnCurrentCity.open{border-bottom-color:#FFF;position:absolute;z-index:4;*top:0}#allCityList{position:absolute;top:29px;left:0;height:300px;background:#FFF;border:1px solid #999;line-height:150%;padding:5px 12px;z-index:3}#closeCityHolder{height:29px;line-height:30px;border-bottom:1px solid #999}#closeCityHolder a{float:right;width:16px;height:29px;_display:inline-block;background:url(/console/public/show/bg.32.png) -45px -240px no-repeat}#allCityListSelect{height:260px;padding:8px 0 2px;overflow:auto}#allCityList th{width:40px;font-weight:normal;vertical-align:top;padding:2px 0 0}#tbodyAllCities td{padding:2px 0}#allCityListSelect{border-spacing:0}#allCityListSelect a{display:inline-block;margin-right:10px;padding:1px;color:#0075c2;text-decoration:none}#searchArea{margin:10px 0 0;position:relative}#searchArea input{height:26px;padding:0 5px;width:210px;*line-height:26px;line-height:26px\0}#btnGoSearch{display:inline-block;height:30px;color:#FFF!important;line-height:30px;padding:0 18px;font-weight:bold;background-color:#0075c2;float:right;text-decoration:none}#btnGoSearch:hover,#btnGoSearch:focus{background-color:#3391ce}#searchSugList{position:absolute;top:30px;width:220px;border:1px solid #999;border-top:0}#searchSugList a{display:block;padding:0 8px;word-wrap:break-word;word-break:break-all;white-space:nowrap;text-overflow:ellipsis;overflow:hidden;height:28px;line-height:28px;text-decoration:none;color:#666}#searchSugList .selected,#searchSugList a:hover,#searchSugList a:focus{background-color:#e3eaf2}#searchSugList span{color:#557495}</style>
        <style>

            body{ min-width: 1000px; overflow: hidden;}
            header{ margin-bottom: 6px;z-index: 160; }
            a[name="top"]{display: block;height: 0;}
            .page_wrapper{width: 100%;position: absolute;top: 0px;bottom: 0;padding-top: 0;padding-bottom: 0;}
            // footer{width: 100%;position: absolute;bottom: 0;}
            .main_content{ width:auto;height:calc(100% - 61px);margin-top: 0; }
            #hr{ height: 2px; background: #0075C2;}
            #myPage{ height:calc(100% - 123px);position: relative;background-color: #FFF;text-align: left;border: 2px solid #0075C2;border-left: none;border-right: none; }
            #map{width: 100%; height: 575px;height: 100%; overflow: hidden;}

            #citySug{ position: absolute; z-index: 2; top:4px; right: 8px; height: 30px; line-height: 30px; }
            #btnCurrentCity{ background: #fff; padding:0 15px; box-sizing: content-box; }
            #btnCurrentCity.open{ position: relative; z-index: 4; }
            #allCityList{ left:auto;right: 0;  width:300px; }

            #myPageTop{ background: #FFF; margin:10px auto;padding: 0 0 10px 10px; }
            .barn{ /*height: 80px; width:980px; position:absolute; margin-left:-490px; left:50%; top: 50px;*/}

            .message{ font-size:12px; color:blue; margin-right: 20px; float:right; }
            #myPageTop table{ border-spacing: 0; width:100%; }
            #myPageTop td{ text-align: left; width:50%; height: 30px; line-height: 30px; padding:0; }
            #myPageTop .tr-radio input{ margin: 0 3px; vertical-align: -3px; }
            #myPageTop .tr-radio label{ margin: 0 20px 0 0; }
            #myPageTop .tr-text input{ margin:0 10px 0 0; height: 24px; padding:0 4px; width: 280px;  line-height:1.5; *line-height: 24px;line-height: 24px\0; }
            #myPageTop .btn-search{ background: #0075C2; display: inline-block; height: 28px; line-height: 28px; padding: 0 20px; text-decoration: none; color: #fff; }
            #myPageTop a.picker-copy{ font-size:15px; }
            #myPageTop .btn-search:hover, #myPageTop .btn-search:focus{ background:#3391CE;  }
            #divCoordinate{ position: absolute; height: 26px; line-height: 26px; padding:0 10px; border:1px solid #999; background: #FFF;z-index: 99; }
            .quick_entrance{display: none;}
            .footer_map,
            #ali_footer{display: none;}
            footer{width: 100%;bottom: 0;position: absolute;padding: 0;margin-top: 0;background: none;color: #000;border: none;}</style>


        <script src="//webapi.amap.com/maps?v=1.3&amp;key=8325164e247e15eea68b59e89200988b"></script>
        <div id="divCoordinate" class="hide"></div>

        <div id="hd" class="barn clearfix">
            <div id="myPageTop">
                <table>
                    <tr class="tr-radio">
                        <td>
                            <label><input type="radio" name="searchType" value="keyword" checked>按关键字搜索</label>
                            <label><input type="radio" name="searchType" value="coordinate">按坐标搜索</label>
                            <span id="txtSearchMessage" class="message hide"></span>
                        </td>
                        <td>
                            坐标获取结果：
                            <span id="copySuccessMessage" class="message hide">复制成功！</span>
                        </td>
                    </tr>
                    <tr class="tr-text">
                        <td>
                            <input type="text" name="search" id="txtSearch" placeholder="请输入关键字进行搜索" >
                            <a href="javascript:;" title="搜索" class="btn-search">搜索</a>
                        </td>
                        <td>
                            <input type="text" id="pointInput" name="coordinate" readonly>
                            <a href="javascript:;" title="复制" class="picker-copy">复制</a>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div id="myPage">
            <div id="map"></div>
            <div id="citySug">
                <div id="btnCurrentCity">
                    <span>北京市</span> [<a href="javascript:;" id="btnChangeCity">更换城市</a>]
                </div>
                <div id="allCityList" class="hide">
                    <div id="closeCityHolder"><a href="javascript:;" title="关闭"></a>选择城市</div>
                    <div id="allCityListSelect">
                        <div id="tdHotCities"></div>
                        <table>
                            <tbody>
                            <tr><td colspan="2">城市列表</td>	</tr>
                            </tbody>
                            <tbody id="tbodyAllCities"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <script>
          (function(f){if(typeof exports==="object"&&typeof module!=="undefined"){module.exports=f()}else if(typeof define==="function"&&define.amd){define([],f)}else{var g;if(typeof window!=="undefined"){g=window}else if(typeof global!=="undefined"){g=global}else if(typeof self!=="undefined"){g=self}else{g=this}g.copyToClipboard = f()}})(function(){var define,module,exports;return (function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
              'use strict';

              var deselectCurrent = require('toggle-selection');

              var defaultMessage = 'Copy to clipboard: #{key}, Enter';

              function format(message) {
                var copyKey = (/mac os x/i.test(navigator.userAgent) ? '⌘' : 'Ctrl') + '+C';
                return message.replace(/#{\s*key\s*}/g, copyKey);
              }

              function copy(text, options) {
                var debug, message, reselectPrevious, range, selection, mark, success = false;
                if (!options) { options = {}; }
                debug = options.debug || false;
                try {
                  reselectPrevious = deselectCurrent();

                  range = document.createRange();
                  selection = document.getSelection();

                  mark = document.createElement('mark');
                  mark.textContent = text;
                  mark.setAttribute('style', [
                    // prevents scrolling to the end of the page
                    'position: fixed',
                    'top: 0',
                    'clip: rect(0, 0, 0, 0)',
                    // used to preserve spaces and line breaks
                    'white-space: pre',
                    // do not inherit user-select (it may be `none`)
                    '-webkit-user-select: text',
                    '-moz-user-select: text',
                    '-ms-user-select: text',
                    'user-select: text',
                  ].join(';'));

                  document.body.appendChild(mark);

                  range.selectNode(mark);
                  selection.addRange(range);

                  var successful = document.execCommand('copy');
                  if (!successful) {
                    throw new Error('copy command was unsuccessful');
                  }
                  success = true;
                } catch (err) {
                  debug && console.error('unable to copy using execCommand: ', err);
                  debug && console.warn('trying IE specific stuff');
                  try {
                    window.clipboardData.setData('text', text);
                    success = true;
                  } catch (err) {
                    debug && console.error('unable to copy using clipboardData: ', err);
                    debug && console.error('falling back to prompt');
                    message = format('message' in options ? options.message : defaultMessage);
                    window.prompt(message, text);
                  }
                } finally {
                  if (selection) {
                    if (typeof selection.removeRange == 'function') {
                      selection.removeRange(range);
                    } else {
                      selection.removeAllRanges();
                    }
                  }

                  if (mark) {
                    document.body.removeChild(mark);
                  }
                  reselectPrevious();
                }

                return success;
              }

              module.exports = copy;

            },{"toggle-selection":2}],2:[function(require,module,exports){
              var module = module || {};

              module.exports = function () {
                var selection = document.getSelection();
                if (!selection.rangeCount) {
                  return function () {};
                }
                var active = document.activeElement;

                var ranges = [];
                for (var i = 0; i < selection.rangeCount; i++) {
                  ranges.push(selection.getRangeAt(i));
                }

                switch (active.tagName.toUpperCase()) { // .toUpperCase handles XHTML
                  case 'INPUT':
                  case 'TEXTAREA':
                    active.blur();
                    break;

                  default:
                    active = null;
                    break;
                }

                selection.removeAllRanges();
                return function () {
                  selection.type === 'Caret' &&
                  selection.removeAllRanges();

                  if (!selection.rangeCount) {
                    ranges.forEach(function(range) {
                      selection.addRange(range);
                    });
                  }

                  active &&
                  active.focus();
                };
              };

            },{}]},{},[1])(1)
          });</script>
        <script>

          !function(){

            var cities = {
              "100000": "",
              "110000": "",
              "120000": "",
              "130000": "130100,石家庄市,Shijiazhuang,114.502461,38.045474,0311;130200,唐山市,Tangshan,118.175393,39.635113,0315;130300,秦皇岛市,Qinhuangdao,119.586579,39.942531,0335;130400,邯郸市,Handan,114.490686,36.612273,0310;130500,邢台市,Xingtai,114.508851,37.0682,0319;130600,保定市,Baoding,115.482331,38.867657,0312;130700,张家口市,Zhangjiakou,114.884091,40.811901,0313;130800,承德市,Chengde,117.939152,40.976204,0314;130900,沧州市,Cangzhou,116.857461,38.310582,0317;131000,廊坊市,Langfang,116.713873,39.529244,0316;131100,衡水市,Hengshui,115.665993,37.735097,0318",
              "140000": "140100,太原市,Taiyuan,112.549248,37.857014,0351;140200,大同市,Datong,113.295259,40.09031,0352;140300,阳泉市,Yangquan,113.583285,37.861188,0353;140400,长治市,Changzhi,113.113556,36.191112,0355;140500,晋城市,Jincheng,112.851274,35.497553,0356;140600,朔州市,Shuozhou,112.433387,39.331261,0349;140700,晋中市,Jinzhong,112.736465,37.696495,0354;140800,运城市,Yuncheng,111.003957,35.022778,0359;140900,忻州市,Xinzhou,112.733538,38.41769,0350;141000,临汾市,Linfen,111.517973,36.08415,0357;141100,吕梁市,Lvliang,111.134335,37.524366,0358",
              "150000": "150100,呼和浩特市,Hohhot,111.670801,40.818311,0471;150200,包头市,Baotou,109.840405,40.658168,0472;150300,乌海市,Wuhai,106.825563,39.673734,0473;150400,赤峰市,Chifeng,118.956806,42.275317,0476;150500,通辽市,Tongliao,122.263119,43.617429,0475;150600,鄂尔多斯市,Ordos,109.99029,39.817179,0477;150700,呼伦贝尔市,Hulunber,119.758168,49.215333,0470;150800,巴彦淖尔市,Bayan Nur,107.416959,40.757402,0478;150900,乌兰察布市,Ulanqab,113.114543,41.034126,0474;152200,兴安盟,Hinggan,122.070317,46.076268,0482;152500,锡林郭勒盟,Xilin Gol,116.090996,43.944018,0479;152900,阿拉善盟,Alxa,105.706422,38.844814,0483",
              "210000": "210100,沈阳市,Shenyang,123.429096,41.796767,024;210200,大连市,Dalian,121.618622,38.91459,0411;210300,鞍山市,Anshan,122.995632,41.110626,0412;210400,抚顺市,Fushun,123.921109,41.875956,0413;210500,本溪市,Benxi,123.770519,41.297909,0414;210600,丹东市,Dandong,124.383044,40.124296,0415;210700,锦州市,Jinzhou,121.135742,41.119269,0416;210800,营口市,Yingkou,122.235151,40.667432,0417;210900,阜新市,Fuxin,121.648962,42.011796,0418;211000,辽阳市,Liaoyang,123.18152,41.269402,0419;211100,盘锦市,Panjin,122.06957,41.124484,0427;211200,铁岭市,Tieling,123.844279,42.290585,0410;211300,朝阳市,Chaoyang,120.451176,41.576758,0421;211400,葫芦岛市,Huludao,120.856394,40.755572,0429",
              "220000": "220100,长春市,Changchun,125.3245,43.886841,0431;220200,吉林市,Jilin,126.55302,43.843577,0432;220300,四平市,Siping,124.370785,43.170344,0434;220400,辽源市,Liaoyuan,125.145349,42.902692,0437;220500,通化市,Tonghua,125.936501,41.721177,0435;220600,白山市,Baishan,126.427839,41.942505,0439;220700,松原市,Songyuan,124.823608,45.118243,0438;220800,白城市,Baicheng,122.841114,45.619026,0436;222400,延边朝鲜族自治州,Yanbian,129.513228,42.904823,1433",
              "230000": "230100,哈尔滨市,Harbin,126.642464,45.756967,0451;230200,齐齐哈尔市,Qiqihar,123.953486,47.348079,0452;230300,鸡西市,Jixi,130.975966,45.300046,0467;230400,鹤岗市,Hegang,130.277487,47.332085,0468;230500,双鸭山市,Shuangyashan,131.157304,46.643442,0469;230600,大庆市,Daqing,125.11272,46.590734,0459;230700,伊春市,Yichun,128.899396,47.724775,0458;230800,佳木斯市,Jiamusi,130.361634,46.809606,0454;230900,七台河市,Qitaihe,131.015584,45.771266,0464;231000,牡丹江市,Mudanjiang,129.618602,44.582962,0453;231100,黑河市,Heihe,127.499023,50.249585,0456;231200,绥化市,Suihua,126.99293,46.637393,0455;232700,大兴安岭地区,Da Hinggan Ling,124.711526,52.335262,0457",
              "310000": "",
              "320000": "320100,南京市,Nanjing,118.767413,32.041544,025;320200,无锡市,Wuxi,120.301663,31.574729,0510;320300,徐州市,Xuzhou,117.184811,34.261792,0516;320400,常州市,Changzhou,119.946973,31.772752,0519;320500,苏州市,Suzhou,120.619585,31.299379,0512;320600,南通市,Nantong,120.864608,32.016212,0513;320700,连云港市,Lianyungang,119.178821,34.600018,0518;320800,淮安市,Huai'an,119.021265,33.597506,0517;320900,盐城市,Yancheng,120.139998,33.377631,0515;321000,扬州市,Yangzhou,119.421003,32.393159,0514;321100,镇江市,Zhenjiang,119.452753,32.204402,0511;321200,泰州市,Taizhou,119.915176,32.484882,0523;321300,宿迁市,Suqian,118.293328,33.945154,0527",
              "330000": "330100,杭州市,Hangzhou,120.153576,30.287459,0571;330200,宁波市,Ningbo,121.549792,29.868388,0574;330300,温州市,Wenzhou,120.672111,28.000575,0577;330400,嘉兴市,Jiaxing,120.750865,30.762653,0573;330500,湖州市,Huzhou,120.102398,30.867198,0572;330600,绍兴市,Shaoxing,120.582112,29.997117,0575;330700,金华市,Jinhua,119.649506,29.089524,0579;330800,衢州市,Quzhou,118.87263,28.941708,0570;330900,舟山市,Zhoushan,122.106863,30.016028,0580;331000,台州市,Taizhou,121.428599,28.661378,0576;331100,丽水市,Lishui,119.921786,28.451993,0578",
              "340000": "340100,合肥市,Hefei,117.283042,31.86119,0551;340181,巢湖市,Chaohu,117.874155,31.600518,0551;340200,芜湖市,Wuhu,118.376451,31.326319,0553;340300,蚌埠市,Bengbu,117.36237,32.934037,0552;340400,淮南市,Huainan,117.025449,32.645947,0554;340500,马鞍山市,Ma'anshan,118.507906,31.689362,0555;340600,淮北市,Huaibei,116.794664,33.971707,0561;340700,铜陵市,Tongling,117.816576,30.929935,0562;340800,安庆市,Anqing,117.053571,30.524816,0556;341000,黄山市,Huangshan,118.317325,29.709239,0559;341100,滁州市,Chuzhou,118.316264,32.303627,0550;341200,阜阳市,Fuyang,115.819729,32.896969,1558;341300,宿州市,Suzhou,116.984084,33.633891,0557;341500,六安市,Lu'an,116.507676,31.752889,0564;341600,亳州市,Bozhou,115.782939,33.869338,0558;341700,池州市,Chizhou,117.489157,30.656037,0566;341800,宣城市,Xuancheng,118.757995,30.945667,0563",
              "350000": "350100,福州市,Fuzhou,119.306239,26.075302,0591;350200,厦门市,Xiamen,118.11022,24.490474,0592;350300,莆田市,Putian,119.007558,25.431011,0594;350400,三明市,Sanming,117.635001,26.265444,0598;350500,泉州市,Quanzhou,118.589421,24.908853,0595;350600,漳州市,Zhangzhou,117.661801,24.510897,0596;350700,南平市,Nanping,118.178459,26.635627,0599;350800,龙岩市,Longyan,117.02978,25.091603,0597;350900,宁德市,Ningde,119.527082,26.65924,0593",
              "360000": "360100,南昌市,Nanchang,115.892151,28.676493,0791;360200,景德镇市,Jingdezhen,117.214664,29.29256,0798;360300,萍乡市,Pingxiang,113.852186,27.622946,0799;360400,九江市,Jiujiang,115.992811,29.712034,0792;360500,新余市,Xinyu,114.930835,27.810834,0790;360600,鹰潭市,Yingtan,117.033838,28.238638,0701;360700,赣州市,Ganzhou,114.940278,25.85097,0797;360800,吉安市,Ji'an,114.986373,27.111699,0796;360900,宜春市,Yichun,114.391136,27.8043,0795;361000,抚州市,Fuzhou,116.358351,27.98385,0794;361100,上饶市,Shangrao,117.971185,28.44442,0793",
              "370000": "370100,济南市,Jinan,117.000923,36.675807,0531;370200,青岛市,Qingdao,120.369557,36.094406,0532;370300,淄博市,Zibo,118.047648,36.814939,0533;370400,枣庄市,Zaozhuang,117.557964,34.856424,0632;370500,东营市,Dongying,118.4963,37.461266,0546;370600,烟台市,Yantai,121.391382,37.539297,0535;370700,潍坊市,Weifang,119.107078,36.70925,0536;370800,济宁市,Jining,116.587245,35.415393,0537;370900,泰安市,Tai'an,117.129063,36.194968,0538;371000,威海市,Weihai,122.116394,37.509691,0631;371100,日照市,Rizhao,119.461208,35.428588,0633;371200,莱芜市,Laiwu,117.677736,36.214397,0634;371300,临沂市,Linyi,118.326443,35.065282,0539;371400,德州市,Dezhou,116.307428,37.453968,0534;371500,聊城市,Liaocheng,115.980367,36.456013,0635;371600,滨州市,Binzhou,118.016974,37.383542,0543;371700,菏泽市,Heze,115.469381,35.246531,0530",
              "410000": "410100,郑州市,Zhengzhou,113.665412,34.757975,0371;410200,开封市,Kaifeng,114.341447,34.797049,0378;410300,洛阳市,Luoyang,112.434468,34.663041,0379;410400,平顶山市,Pingdingshan,113.307718,33.735241,0375;410500,安阳市,Anyang,114.352482,36.103442,0372;410600,鹤壁市,Hebi,114.295444,35.748236,0392;410700,新乡市,Xinxiang,113.883991,35.302616,0373;410800,焦作市,Jiaozuo,113.238266,35.23904,0391;410900,濮阳市,Puyang,115.041299,35.768234,0393;411000,许昌市,Xuchang,113.826063,34.022956,0374;411100,漯河市,Luohe,114.026405,33.575855,0395;411200,三门峡市,Sanmenxia,111.194099,34.777338,0398;411300,南阳市,Nanyang,112.540918,32.999082,0377;411400,商丘市,Shangqiu,115.650497,34.437054,0370;411500,信阳市,Xinyang,114.075031,32.123274,0376;411600,周口市,Zhoukou,114.649653,33.620357,0394;411700,驻马店市,Zhumadian,114.024736,32.980169,0396;419001,济源市,Jiyuan,112.590047,35.090378,1391",
              "420000": "420100,武汉市,Wuhan,114.298572,30.584355,027;420200,黄石市,Huangshi,115.077048,30.220074,0714;420300,十堰市,Shiyan,110.785239,32.647017,0719;420500,宜昌市,Yichang,111.290843,30.702636,0717;420600,襄阳市,Xiangyang,112.144146,32.042426,0710;420700,鄂州市,Ezhou,114.890593,30.396536,0711;420800,荆门市,Jingmen,112.204251,31.03542,0724;420900,孝感市,Xiaogan,113.926655,30.926423,0712;421000,荆州市,Jingzhou,112.23813,30.326857,0716;421100,黄冈市,Huanggang,114.879365,30.447711,0713;421200,咸宁市,Xianning,114.328963,29.832798,0715;421300,随州市,Suizhou,113.37377,31.717497,0722;422800,恩施土家族苗族自治州,Enshi,109.48699,30.283114,0718;429004,仙桃市,Xiantao,113.453974,30.364953,0728;429005,潜江市,Qianjiang,112.896866,30.421215,2728;429006,天门市,Tianmen,113.165862,30.653061,1728;429021,神农架林区,Shennongjia,110.671525,31.744449,1719",
              "430000": "430100,长沙市,Changsha,112.982279,28.19409,0731;430200,株洲市,Zhuzhou,113.151737,27.835806,0733;430300,湘潭市,Xiangtan,112.925083,27.846725,0732;430400,衡阳市,Hengyang,112.607693,26.900358,0734;430500,邵阳市,Shaoyang,111.46923,27.237842,0739;430600,岳阳市,Yueyang,113.132855,29.37029,0730;430700,常德市,Changde,111.691347,29.040225,0736;430800,张家界市,Zhangjiajie,110.479921,29.127401,0744;430900,益阳市,Yiyang,112.355042,28.570066,0737;431000,郴州市,Chenzhou,113.032067,25.793589,0735;431100,永州市,Yongzhou,111.608019,26.434516,0746;431200,怀化市,Huaihua,109.97824,27.550082,0745;431300,娄底市,Loudi,112.008497,27.728136,0738;433100,湘西土家族苗族自治州,Xiangxi,109.739735,28.314296,0743",
              "440000": "440100,广州市,Guangzhou,113.280637,23.125178,020;440200,韶关市,Shaoguan,113.591544,24.801322,0751;440300,深圳市,Shenzhen,114.085947,22.547,0755;440400,珠海市,Zhuhai,113.552724,22.255899,0756;440500,汕头市,Shantou,116.708463,23.37102,0754;440600,佛山市,Foshan,113.122717,23.028762,0757;440700,江门市,Jiangmen,113.094942,22.590431,0750;440800,湛江市,Zhanjiang,110.405529,21.195338,0759;440900,茂名市,Maoming,110.919229,21.659751,0668;441200,肇庆市,Zhaoqing,112.472529,23.051546,0758;441300,惠州市,Huizhou,114.412599,23.079404,0752;441400,梅州市,Meizhou,116.117582,24.299112,0753;441500,汕尾市,Shanwei,115.364238,22.774485,0660;441600,河源市,Heyuan,114.697802,23.746266,0762;441700,阳江市,Yangjiang,111.975107,21.859222,0662;441800,清远市,Qingyuan,113.036779,23.704188,0763;441900,东莞市,Dongguan,113.760234,23.048884,0769;442000,中山市,Zhongshan,113.382391,22.521113,0760;445100,潮州市,Chaozhou,116.632301,23.661701,0768;445200,揭阳市,Jieyang,116.355733,23.543778,0663;445300,云浮市,Yunfu,112.044439,22.929801,0766",
              "450000": "450100,南宁市,Nanning,108.320004,22.82402,0771;450200,柳州市,Liuzhou,109.411703,24.314617,0772;450300,桂林市,Guilin,110.299121,25.274215,0773;450400,梧州市,Wuzhou,111.316229,23.472309,0774;450500,北海市,Beihai,109.119254,21.473343,0779;450600,防城港市,Fangchenggang,108.345478,21.614631,0770;450700,钦州市,Qinzhou,108.624175,21.967127,0777;450800,贵港市,Guigang,109.602146,23.0936,1755;450900,玉林市,Yulin,110.154393,22.63136,0775;451000,百色市,Baise,106.616285,23.897742,0776;451100,贺州市,Hezhou,111.552056,24.414141,1774;451200,河池市,Hechi,108.062105,24.695899,0778;451300,来宾市,Laibin,109.229772,23.733766,1772;451400,崇左市,Chongzuo,107.353926,22.404108,1771",
              "460000": "460100,海口市,Haikou,110.33119,20.031971,0898;460200,三亚市,Sanya,109.508268,18.247872,0899;460300,三沙市,Sansha,112.34882,16.831039,2898;460321,西沙群岛,Xisha Islands,112.025528,16.331342,1895;460322,南沙群岛,Nansha Islands,116.749998,11.471888,1891;460323,中沙群岛的岛礁及其海域,Zhongsha Islands,117.740071,15.112856,2801;469001,五指山市,Wuzhishan,109.516662,18.776921,1897;469002,琼海市,Qionghai,110.466785,19.246011,1894;469003,儋州市,Danzhou,109.576782,19.517486,0805;469005,文昌市,Wenchang,110.753975,19.612986,1893;469006,万宁市,Wanning,110.388793,18.796216,1898;469007,东方市,Dongfang,108.653789,19.10198,0807;469021,定安县,Ding'an,110.323959,19.699211,0806;469022,屯昌县,Tunchang,110.102773,19.362916,1892;469023,澄迈县,Chengmai,110.007147,19.737095,0804;469024,临高县,Lingao,109.687697,19.908293,1896;469025,白沙黎族自治县,Baisha,109.452606,19.224584,0802;469026,昌江黎族自治县,Changjiang,109.053351,19.260968,0803;469027,乐东黎族自治县,Ledong,109.175444,18.74758,2802;469028,陵水黎族自治县,Lingshui,110.037218,18.505006,0809;469029,保亭黎族苗族自治县,Baoting,109.70245,18.636371,0801;469030,琼中黎族苗族自治县,Qiongzhong,109.839996,19.03557,1899",
              "500000": "",
              "510000": "510100,成都市,Chengdu,104.065735,30.659462,028;510300,自贡市,Zigong,104.773447,29.352765,0813;510400,攀枝花市,Panzhihua,101.716007,26.580446,0812;510500,泸州市,Luzhou,105.443348,28.889138,0830;510600,德阳市,Deyang,104.398651,31.127991,0838;510700,绵阳市,Mianyang,104.741722,31.46402,0816;510800,广元市,Guangyuan,105.829757,32.433668,0839;510900,遂宁市,Suining,105.571331,30.513311,0825;511000,内江市,Neijiang,105.066138,29.58708,1832;511100,乐山市,Leshan,103.761263,29.582024,0833;511300,南充市,Nanchong,106.082974,30.795281,0817;511400,眉山市,Meishan,103.831788,30.048318,1833;511500,宜宾市,Yibin,104.630825,28.760189,0831;511600,广安市,Guang'an,106.633369,30.456398,0826;511700,达州市,Dazhou,107.502262,31.209484,0818;511800,雅安市,Ya'an,103.001033,29.987722,0835;511900,巴中市,Bazhong,106.753669,31.858809,0827;512000,资阳市,Ziyang,104.641917,30.122211,0832;513200,阿坝藏族羌族自治州,Aba,102.221374,31.899792,0837;513300,甘孜藏族自治州,Garze,101.963815,30.050663,0836;513400,凉山彝族自治州,Liangshan,102.258746,27.886762,0834",
              "520000": "520100,贵阳市,Guiyang,106.713478,26.578343,0851;520200,六盘水市,Liupanshui,104.846743,26.584643,0858;520300,遵义市,Zunyi,106.937265,27.706626,0852;520400,安顺市,Anshun,105.932188,26.245544,0853;520500,毕节市,Bijie,105.28501,27.301693,0857;520600,铜仁市,Tongren,109.191555,27.718346,0856;522300,黔西南布依族苗族自治州,Qianxinan,104.897971,25.08812,0859;522600,黔东南苗族侗族自治州,Qiandongnan,107.977488,26.583352,0855;522700,黔南布依族苗族自治州,Qiannan,107.517156,26.258219,0854",
              "530000": "530100,昆明市,Kunming,102.712251,25.040609,0871;530300,曲靖市,Qujing,103.797851,25.501557,0874;530400,玉溪市,Yuxi,102.543907,24.350461,0877;530500,保山市,Baoshan,99.167133,25.111802,0875;530600,昭通市,Zhaotong,103.717216,27.336999,0870;530700,丽江市,Lijiang,100.233026,26.872108,0888;530800,普洱市,Pu'er,100.972344,22.777321,0879;530900,临沧市,Lincang,100.08697,23.886567,0883;532300,楚雄彝族自治州,Chuxiong,101.546046,25.041988,0878;532500,红河哈尼族彝族自治州,Honghe,103.384182,23.366775,0873;532600,文山壮族苗族自治州,Wenshan,104.24401,23.36951,0876;532800,西双版纳傣族自治州,Xishuangbanna,100.797941,22.001724,0691;532900,大理白族自治州,Dali,100.240037,25.592765,0872;533100,德宏傣族景颇族自治州,Dehong,98.578363,24.436694,0692;533300,怒江傈僳族自治州,Nujiang,98.854304,25.850949,0886;533400,迪庆藏族自治州,Deqen,99.706463,27.826853,0887",
              "540000": "540100,拉萨市,Lhasa,91.132212,29.660361,0891;542100,昌都地区,Qamdo,97.178452,31.136875,0895;542200,山南地区,Shannan,91.766529,29.236023,0893;542300,日喀则地区,Shigatse,88.885148,29.267519,0892;542400,那曲地区,Nagqu,92.060214,31.476004,0896;542500,阿里地区,Ngari,80.105498,32.503187,0897;542600,林芝地区,Nyingchi,94.362348,29.654693,0894",
              "610000": "610100,西安市,Xi'an,108.948024,34.263161,029;610200,铜川市,Tongchuan,108.963122,34.90892,0919;610300,宝鸡市,Baoji,107.14487,34.369315,0917;610400,咸阳市,Xianyang,108.705117,34.333439,0910;610500,渭南市,Weinan,109.502882,34.499381,0913;610600,延安市,Yan'an,109.49081,36.596537,0911;610700,汉中市,Hanzhong,107.028621,33.077668,0916;610800,榆林市,Yulin,109.741193,38.290162,0912;610900,安康市,Ankang,109.029273,32.6903,0915;611000,商洛市,Shangluo,109.939776,33.868319,0914",
              "620000": "620100,兰州市,Lanzhou,103.823557,36.058039,0931;620200,嘉峪关市,Jiayuguan,98.277304,39.786529,1937;620300,金昌市,Jinchang,102.187888,38.514238,0935;620400,白银市,Baiyin,104.173606,36.54568,0943;620500,天水市,Tianshui,105.724998,34.578529,0938;620600,武威市,Wuwei,102.634697,37.929996,1935;620700,张掖市,Zhangye,100.455472,38.932897,0936;620800,平凉市,Pingliang,106.684691,35.54279,0933;620900,酒泉市,Jiuquan,98.510795,39.744023,0937;621000,庆阳市,Qingyang,107.638372,35.734218,0934;621100,定西市,Dingxi,104.626294,35.579578,0932;621200,陇南市,Longnan,104.929379,33.388598,2935;622900,临夏回族自治州,Linxia,103.212006,35.599446,0930;623000,甘南藏族自治州,Gannan,102.911008,34.986354,0941",
              "630000": "630100,西宁市,Xining,101.778916,36.623178,0971;632100,海东地区,Haidong,102.10327,36.502916,0972;632200,海北藏族自治州,Haibei,100.901059,36.959435,0970;632300,黄南藏族自治州,Huangnan,102.019988,35.517744,0973;632500,海南藏族自治州,Hainan,100.619542,36.280353,0974;632600,果洛藏族自治州,Golog,100.242143,34.4736,0975;632700,玉树藏族自治州,Yushu,97.008522,33.004049,0976;632800,海西蒙古族藏族自治州,Haixi,97.370785,37.374663,0977",
              "640000": "640100,银川市,Yinchuan,106.278179,38.46637,0951;640200,石嘴山市,Shizuishan,106.376173,39.01333,0952;640300,吴忠市,Wuzhong,106.199409,37.986165,0953;640400,固原市,Guyuan,106.285241,36.004561,0954;640500,中卫市,Zhongwei,105.189568,37.514951,1953",
              "650000": "650100,乌鲁木齐市,Urumqi,87.617733,43.792818,0991;650200,克拉玛依市,Karamay,84.873946,45.595886,0990;652100,吐鲁番地区,Turpan,89.184078,42.947613,0995;652200,哈密地区,Kumul,93.51316,42.833248,0902;652300,昌吉回族自治州,Changji,87.304012,44.014577,0994;652700,博尔塔拉蒙古自治州,Bortala,82.074778,44.903258,0909;652800,巴音郭楞蒙古自治州,Bayingol,86.150969,41.768552,0996;652900,阿克苏地区,Aksu,80.265068,41.170712,0997;653000,克孜勒苏柯尔克孜自治州,Kizilsu,76.172825,39.713431,0908;653100,喀什地区,Kashgar,75.989138,39.467664,0998;653200,和田地区,Hotan,79.92533,37.110687,0903;654000,伊犁哈萨克自治州,Ili,81.317946,43.92186,0999;654200,塔城地区,Qoqek,82.985732,46.746301,0901;654300,阿勒泰地区,Altay,88.13963,47.848393,0906;659001,石河子市,Shihezi,86.041075,44.305886,0993;659002,阿拉尔市,Aral,81.285884,40.541914,1997;659003,图木舒克市,Tumxuk,79.077978,39.867316,1998;659004,五家渠市,Wujiaqu,87.526884,44.167401,1994",
              "710000": "",
              "810000": "",
              "820000": ""
            };
            var allcities = "100000,全国,China,116.3683244,39.915085,;110000,北京市,Beijing,116.405285,39.904989,010;120000,天津市,Tianjin,117.190182,39.125596,022;130000,河北省,Hebei,114.502461,38.045474,;140000,山西省,Shanxi,112.549248,37.857014,;150000,内蒙古自治区,Inner Mongolia,111.670801,40.818311,;210000,辽宁省,Liaoning,123.429096,41.796767,;220000,吉林省,Jilin,125.3245,43.886841,;230000,黑龙江省,Heilongjiang,126.642464,45.756967,;310000,上海市,Shanghai,121.472644,31.231706,021;320000,江苏省,Jiangsu,118.767413,32.041544,;330000,浙江省,Zhejiang,120.153576,30.287459,;340000,安徽省,Anhui,117.283042,31.86119,;350000,福建省,Fujian,119.306239,26.075302,;360000,江西省,Jiangxi,115.892151,28.676493,;370000,山东省,Shandong,117.000923,36.675807,;410000,河南省,Henan,113.665412,34.757975,;420000,湖北省,Hubei,114.298572,30.584355,;430000,湖南省,Hunan,112.982279,28.19409,;440000,广东省,Guangdong,113.280637,23.125178,;450000,广西壮族自治区,Guangxi,108.320004,22.82402,;460000,海南省,Hainan,110.33119,20.031971,;500000,重庆市,Chongqing,106.504962,29.533155,023;510000,四川省,Sichuan,104.065735,30.659462,;520000,贵州省,Guizhou,106.713478,26.578343,;530000,云南省,Yunnan,102.712251,25.040609,;540000,西藏自治区,Tibet,91.132212,29.660361,;610000,陕西省,Shaanxi,108.948024,34.263161,;620000,甘肃省,Gansu,103.823557,36.058039,;630000,青海省,Qinghai,101.778916,36.623178,;640000,宁夏回族自治区,Ningxia,106.278179,38.46637,;650000,新疆维吾尔自治区,Xinjiang,87.617733,43.792818,;810000,香港特別行政區,Hong Kong,114.173355,22.320048,1852;820000,澳門特別行政區,Macau,113.54909,22.198951,1853;710000,台湾省,Taiwan Province,121.509062,25.044332,1886;";

            var provinceList = [], provinceObj = {}, cityObj={}, i,len, j, jl, temp, provinceStrList = allcities.split(";"), stringDetail;
            var otherProvince = {code:"718182", cities:[], label:"其他", name:"其他"}, isOtherProvince, province;
            var regProvince = /省|市|壮|回|维|自/, regCity = /市$/, html;
            var hotCityName = ['北京','上海','广州','深圳','成都','沈阳','苏州','郑州','青岛','天津','重庆','武汉','杭州','西安','南京','大连','长沙'];
            for(i = 0, len = provinceStrList.length; i < len; i++){
              stringDetail = provinceStrList[i].split(",");
              if(stringDetail.length && stringDetail[0] > 110000 - 1){
                isOtherProvince = stringDetail[0] > 710000 - 1;
                temp = isOtherProvince ? stringDetail[1].substr(0,2):stringDetail[1].substr(0, 3).replace(regProvince, "");
                province = {code: stringDetail[0], label: stringDetail[1], name: temp, cities:[], lng: stringDetail[3], lat: stringDetail[4]};
                if(isOtherProvince){
                  otherProvince.cities.push(province);
                  cityObj[stringDetail[0]]= cityObj[province.name] = province;
                }
                else{
                  provinceList.push(province);
                  provinceObj[stringDetail[0]] = provinceObj[stringDetail[1]] = provinceObj[province.name] = province;
                  cityObj[stringDetail[0]] = cityObj[stringDetail[1]] = cityObj[province.name] = province;
                }
              }
            }

            provinceList.sort(function(p1, p2){
              return p1.name.charCodeAt(0) == p2.name.charCodeAt(0) ? p1.name.charCodeAt(1) - p2.name.charCodeAt(1) : p1.name.charCodeAt(0) - p2.name.charCodeAt(0);
            });

            provinceList.push(otherProvince);
            provinceObj[718182] = otherProvince;

            for(i in cities){
              if(cities[i]){
                stringDetail = cities[i].split(";");
                for(j = 0, jl = stringDetail.length; j < jl; j++){
                  temp = stringDetail[j].split(",");
                  province = {code:temp[0], label: temp[1], name: temp[1].replace(regCity, ""), lng: temp[3], lat: temp[4]};
                  cityObj[temp[0]] = cityObj[temp[1]] = cityObj[province.name] = province;
                  provinceObj[i].cities.push(province);
                }
              }
            }

            for(html = [], i = 0, len = hotCityName.length; i < len; i++){
              temp = cityObj[hotCityName[i]] || provinceObj[hotCityName[i]];
              html.push('<a href="javascript:;">', temp.name ,'</a>');
            }
            $("#tdHotCities").html(html.join(""));

            for(html = [], i = 0, len = provinceList.length; i < len; i++){
              temp = provinceList[i];
              if(temp.cities.length < 2){ continue; }
              html.push('<tr><th>', temp.name ,'</th><td>');
              for(j = 0, jl = temp.cities.length; j < jl; j++){
                html.push('<a href="javascript:;">', temp.cities[j].name, '</a>')
              }
              html.push('</td></tr>');
            }
            $("#tbodyAllCities").html(html.join(""));

            $("#btnChangeCity")
              .on("click", function(){
                $body.off("click", fnClickAllCity);
                setTimeout(function(){ $body.on("click", fnClickAllCity); }, 9);
                $allCitys.removeClass("hide");
                $btnCurrentCity.addClass("open");
              })
            $('#citySug')
              .hover(function(){
                divCoordinate.style.display = 'none'
              },function(){
                divCoordinate.style.display = 'block'

              })

            var $myPageTop = $("#myPageTop").on("click", function(e){
              var target = e.target;
              if("INPUT" == target.nodeName && "radio" == target.type){
                $txtSearch.attr("placeholder",
                  "请输入" +({keyword:"关键字", coordinate:"坐标"})[target.value] + "进行搜索");
              }
            });

            var currentCity = cityObj["北京"], // 默认值，否则获取不到容易出错
              MA = {
                //cityObj : cityObj,
                setCurrentCity: function(city){
                  currentCity = cityObj[city];
                  $btnCurrentCity.find("span")[0].innerHTML = currentCity.label;
                  mapObj.setZoomAndCenter(10, new AMap.LngLat(currentCity.lng, currentCity.lat));
                }
              },
              $body = $(document.body),
              fnClickAllCity = function(){
                $body.off("click", fnClickAllCity);
                $allCitys.addClass("hide");
                $btnCurrentCity.removeClass("open");
              },

              $btnCurrentCity = $("#btnCurrentCity"),
              $txtSearch = $("#txtSearch").on("keyup", function(e){
                if(e.keyCode ==13){
                  fnDoSearchClick();
                }
              }),
              $txtCoordinate = $("#pointInput"),
              divCoordinate = $("#divCoordinate")[0],

              $allCitys = $("#allCityList").on("click", function(e){
                var a = e.target;
                e.stopPropagation();
                if(a.tagName == "A"){
                  fnClickAllCity();
                  if(!/close-icon/.test(a.className)){
                    MA.setCurrentCity(a.innerHTML);
                  }
                }
              }),
              placeSearch, geocoder,
              marker = new AMap.Marker(),
              $msgTxtSearch = $("#txtSearchMessage"),
              fnShowSearchMessage = function(txt){
                setTimeout(function(){
                  $msgTxtSearch.fadeOut("slow", function(){
                    $msgTxtSearch.addClass("hide");
                  });
                }, 900);
                $msgTxtSearch.html(txt).removeClass("hide").css("display", "block");

              },
              fnPlaceSearchCallback = function(result){
                if(result == 'complete'){
                  return
                }

                if(result.poiList && result.poiList.pois && result.poiList.pois.length){
                  var poi = result.poiList.pois[0];
                  mapObj.setZoomAndCenter(13, poi.location);
                  marker.setTitle([poi.name, poi.address].join(poi.name && poi.address ? "\n" : ""));
                  marker.setPosition(poi.location);
                  marker.setMap(mapObj);
                  $txtCoordinate[0].value = poi.location.toString();
                }
                else{
                  fnShowSearchMessage("没有搜索到结果！！！");
                }
              },
              fnGeocoderCallback = function(result){
                if(result.regeocode && result.regeocode.formattedAddress){
                  marker.setTitle(result.regeocode.formattedAddress);
                }
                else{ fnShowSearchMessage("没有搜索到结果！"); }
              },
              fnDoSearchClick = function(){
                var $radio = $myPageTop.find("input:checked"), $input = $myPageTop.find("input[type=text]"), value = $input[0].value, lng,lat, lnglat;
                if(!value){ fnShowSearchMessage("请输入搜索内容！"); return;}
                if($radio[0].value == "coordinate"){
                  lnglat = value.split(",");
                  lng = Number(lnglat[0]);
                  lat = Number(lnglat[1]);
                  if(isNaN(lng) || isNaN(lat) || lng < -180 || lng > 180 || lat < -90 || lat > 90){
                    fnShowSearchMessage("请输入正确的经纬度坐标！");
                    $input.focus();
                  }
                  else{
                    lnglat = new AMap.LngLat(lng, lat);
                    mapObj.setZoomAndCenter(13, lnglat);
                    geocoder.getAddress(lnglat);
                    marker.setPosition(lnglat);
                    marker.setMap(mapObj);
                    $txtCoordinate[0].value = value;
                    marker.setTitle(null);
                  }
                }
                else{
                  placeSearch.setCity(currentCity.code);
                  placeSearch.search(value, fnPlaceSearchCallback);
                }
              },
              mapObj = new AMap.Map("map", {center:new AMap.LngLat(116.397428,39.90923), resizeEnable:true});

            $myPageTop.find("a.btn-search").on("click", fnDoSearchClick);

            var bodyScrollLeft, bodyScrollTop, bodyWidth;
            AMap.event.addListener(mapObj, "mousemove", function(e){
              divCoordinate.innerHTML = e.lnglat.toString();
              var style = divCoordinate.style, event = e.originalEvent, left, width = divCoordinate.offsetWidth;

              //1.3
              style.top = (e.pixel.y + 105) + "px";
              style.left = (e.pixel.x + 6) +"px";

              /* //1.2
              if("pageX" in event){
                  left = event.pageX;
                  //style.left = (event.pageX + 6) + "px";
                  style.top = (event.pageY - 70) + "px";
              }else{
                  left = bodyScrollLeft + event.clientX;
                  //style.left = (bodyScrollLeft + event.clientX + 6) + "px";
                  style.top = (bodyScrollTop + event.clientY - 70) + "px";
              }
              */

              /*
              if(left > bodyWidth - width - 6){
                  style.left = (left - divCoordinate.offsetWidth)+"px";
              }
              else{
                  style.left = (left + 6) +"px";
              }
              */
            });

            AMap.event.addListener(mapObj, "click", function(e){
              $txtCoordinate[0].value = e.lnglat.toString();
            });

            AMap.event.addListener(mapObj, "mouseover", function(e){
              divCoordinate.className = "";
              bodyWidth = $body.width();
              /* //1.2
              if(!("pageX" in e.originalEvent)){
                  bodyScrollLeft = $body.scrollLeft();
                  bodyScrollTop = $body.scrollTop();
              }
              */
            });

            AMap.event.addListener(mapObj, "mouseout", function(e){
              divCoordinate.className = "hide";
            });

            //右上角城市自动切换
            AMap.event.addListener(mapObj, "moveend", function(e){
              var center = mapObj.getCenter(),
                geocoder = new AMap.Geocoder(),
                city = ''

              geocoder.getAddress(center, function(status, result) {
                if (status === 'complete' && result.info === 'OK') {
                  var addComponent = result.regeocode.addressComponent
                  if(!addComponent.city){
                    city = addComponent.province
                  }else{
                    city = addComponent.city
                  }
                  $btnCurrentCity.find('span').html(city)
                }
              });
            });

            mapObj.plugin(["AMap.ToolBar","AMap.OverView", "AMap.PlaceSearch","AMap.CitySearch","AMap.Geocoder"], function(){
              mapObj.addControl(new AMap.ToolBar);
              mapObj.addControl(new AMap.OverView);

              placeSearch = new AMap.PlaceSearch;
              AMap.event.addListener(placeSearch, "complete", fnPlaceSearchCallback);
              AMap.event.addListener(placeSearch, "error", fnPlaceSearchCallback);

              geocoder = new AMap.Geocoder({radius: 2800});
              AMap.event.addListener(geocoder, "complete", fnGeocoderCallback);
              AMap.event.addListener(geocoder, "error", fnGeocoderCallback);

              var citySearch = new AMap.CitySearch;
              AMap.event.addListener(citySearch, "complete", function(result){
                mapObj.setBounds(result.bounds);
                MA.setCurrentCity(result.city); //TODO：暂时不处理城市名称和本地名称是否对应的问题
              });
              citySearch.getLocalCity();
            });

            //hover左上角放大缩小工具时隐藏坐标
            $('.amap-controls')
              .hover(function(){
                divCoordinate.style.display = 'none'
              },function(){
                divCoordinate.style.display = 'block'
              })

            //复制
            var $message = $("#copySuccessMessage"),
              btnPickerCopy = $('.picker-copy')
            btnPickerCopy
              .click(function(){
                copyToClipboard($txtCoordinate[0].value);
                $message.removeClass("hide").css("display", "block");
                setTimeout(function(){
                  $message.fadeOut("slow", function(){ $message.addClass("hide"); });
                }, 900);
              })
          }();

        </script>
    </div><!-- /.main_content -->
</div><!-- /.page_wrapper -->


<div id="qrcode_modal_mobile" class="qrcode_modal_mobile mobile">
    <div class="qrcode_modal_mobile_bg"></div>
    <img src="//a.amap.com/lbs/static/img/gaode_qr_big.jpg" alt="">
</div>
<script src="https://lbs.amap.com/web/public/dist/dll.7ce3ea.js"></script>
<script src="https://lbs.amap.com/web/public/dist/main.57ec30.js"></script></body>
</html>
