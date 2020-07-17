
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>拾取坐标系统</title>
    <link href="http://api.map.baidu.com/lbsapi/getpoint/Css/public.css?20200211" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="https://lbsyun.baidu.com/skins/MySkin/resources/img/icon/lbsyunlogo_icon.ico">
    <script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=E4805d16520de693a3fe707cdc962045"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/lbsapi/getpoint/Js/tangram.js"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/lbsapi/getpoint/Js/mapext.js"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/lbsapi/getpoint/Js/public.js?20200211"></script>
    <script type="text/javascript">
      DomReady.ready(localsearch);
    </script>
</head>

<body onresize="mapResize()">
<div class="content">
    <div class="LogoCon clear">
        <div class="logo"><img src="http://api.map.baidu.com/lbsapi/getpoint/Images/logo.gif" width="146" height="80" border="0" /></div>
        <div class="search map_search"><input type="text" class="text" id="localvalue" value="请输入关键字进行搜索，坐标反查需经度在前" onfocus="foucs_(this,'请输入关键字进行搜索，坐标反查需经度在前','')"
                                              onblur="blur_(this,'请输入关键字进行搜索，坐标反查需经度在前','')" callback="beginsearch(l_local)" /><input class="button" type="button"
                                                                                                                                      id="localsearch" />
            <span
                    class="searchTip" id="searchTip"></span>
        </div>
        <label class="pointLabel" for="pointLabel"><input type="checkbox" onfocus="this.blur()" id="pointLabel" />坐标反查</label>
        <div style="width:400px;position:relative;float:right;">
            <div style="color:#666;line-height:25px;">当前坐标点如下：</div>
            <div class="pointContainer">
                <input type="text" readonly id="pointInput" class="pointInput" />
                <input type="button" id="copyButton" data-clipboard-target="#pointInput" class="button" />
            </div>
            <span id="copyMessage" style="width:60px;position:absolute;top:5px;right:190px;*right:160px;color:#f00;display:none"></span>
            <div
                    style="color:#777;margin-top:5px;display:none">(默认显示地图中心点坐标,鼠标左键单击后显示单击点的坐标)</div>
        </div>
    </div>
    <div class="dt_nav"><span class="result" id="resultNum"></span>
        <ul class="nav">
            <li>
                <div class="l"><b id="curCity"></b><span>[<a id="curCityText" onclick="showPop()">更换城市</a>]</span></div><span class="r"></span></li>
            <li>
                <div class="l"><b>当前层级：<span id="ZoomNum"></span>级</b></div><span class="r"></span></li>
        </ul>
    </div>
    <div id="wrapper">
        <div id="MapHolder" style="overflow:hidden;"></div>
        <!--右侧地图Info begin-->
        <div id="MapInfo">
            <div id="txtPanel">
                <h3>功能简介：</h3>
                <p class="tip_info">1、支持地址 精确/模糊 查询；<br/>2、支持POI点坐标显示、复制；<br/>3、坐标鼠标跟随显示；<br/>4、
                    <font color="red">支持坐标查询(需要将坐标反查框勾选)；</font><br/></p>
                <h3>使用说明：</h3>
                <p class="tip_info">1、获取坐标并复制：<br/><span class="tip_info_em">1)、在搜索框中搜索关键词后，左侧列表中会有该点的坐标，点击该条信息或地图上该点，都会将坐标显示在地图右上角的Input框中,然后点击复制按钮，该点坐标就复制成功了;<br />2)、在地图上用鼠标左键单击地图，就能将该点坐标显示在地图右上角的Input框中,然后点击复制按钮，该点坐标就复制成功了;</span>2、坐标反查：<br/>
                    <span
                            class="tip_info_em">1)、先勾选住 搜索框后面的
                        <font color="red">坐标反查框</font><br />2)、输入一个正确的坐标(比如：116.307629,40.058359)，点击按钮 <b>百度一下</b>，就能将该点显示在地图上、切换地图，
                        <font color="red">如果解析成功，还能返回一个地址</font>
                        </span>
                </p>
            </div>
        </div>
        <!--右侧地图Info end-->
        <!--地图上边右边透明立体边框 begin-->
        <div id="shad">
            <div id="shad_v"></div>
            <div id="shad_h"></div>
        </div>
        <!--地图上边右边透明立体边框 end-->
    </div>
</div>
<!--更换城市 begin-->
<div style="width: 382px; display: none; left: 5px; top: 139px; height: 344px;" class="map_popup" id="map_popup">
    <div class="popup_main">
        <div class="title">城市列表</div>
        <div class="sel_city" style="height: 320px; overflow-y: auto;overflow-x:hidden;margin:0;padding-left:5px">

            <table style="width:345px;margin-bottom:20px;overflow:hidden;" id="selCity">
                <tr>
                    <td colspan="2" class="selCityInput"><input id="selCityInput" type="text" value="请输入城市名" onfocus="foucs_(this,'请输入城市名','')" onblur="blur_(this,'请输入城市名','')"
                                                                class="selCityInputT" callback="goCity(Fe.G('selCityInput'))" style="color:#8C8C8C" />
                        <input
                                id="selCityButton" value="确定" type="button" onclick="goCity(Fe.G('selCityInput'))"><span style="color:#f00;display:none" id="selCityMessage">请输入正确的城市名</span></td>
                </tr>
                <tr>
                    <td width="57">直辖市：</td>
                    <td width="287">
                        <nobr><a onclick="goCity(this)" name="北京市">北京</a></nobr>
                        <nobr><a onclick="goCity(this)" name="上海市">上海</a></nobr>
                        <nobr><a onclick="goCity(this)" name="天津市">天津</a></nobr>
                        <nobr><a onclick="goCity(this)" name="重庆市">重庆</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" onclick="goCity(this)">安徽</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)" name="合肥市">合肥</a></nobr>
                        <nobr><a onclick="goCity(this)" name="安庆市">安庆</a></nobr>
                        <nobr><a onclick="goCity(this)" name="蚌埠市">蚌埠</a></nobr>
                        <nobr><a onclick="goCity(this)" name="亳州市">亳州</a></nobr>
                        <nobr><a onclick="goCity(this)" name="巢湖市">巢湖</a></nobr>
                        <nobr><a onclick="goCity(this)" name="池州市">池州</a></nobr>
                        <nobr><a onclick="goCity(this)" name="滁州市">滁州</a></nobr>
                        <nobr><a onclick="goCity(this)" name="阜阳市">阜阳</a></nobr>
                        <nobr><a onclick="goCity(this)" name="淮北市">淮北</a></nobr>
                        <nobr><a onclick="goCity(this)" name="淮南市">淮南</a></nobr>
                        <nobr><a onclick="goCity(this)" name="黄山市">黄山</a></nobr>
                        <nobr><a onclick="goCity(this)" name="六安市">六安</a></nobr>
                        <nobr><a onclick="goCity(this)" name="马鞍山市">马鞍山</a></nobr>
                        <nobr><a onclick="goCity(this)" name="宿州市">宿州</a></nobr>
                        <nobr><a onclick="goCity(this)" name="铜陵市">铜陵</a></nobr>
                        <nobr><a onclick="goCity(this)" name="芜湖市">芜湖</a></nobr>
                        <nobr><a onclick="goCity(this)" name="宣城市">宣城</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" onclick="goCity(this)">福建</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">福州</a></nobr>
                        <nobr><a onclick="goCity(this)">龙岩</a></nobr>
                        <nobr><a onclick="goCity(this)">南平</a></nobr>
                        <nobr><a onclick="goCity(this)">宁德</a></nobr>
                        <nobr><a onclick="goCity(this)">莆田</a></nobr>
                        <nobr><a onclick="goCity(this)">泉州</a></nobr>
                        <nobr><a onclick="goCity(this)">三明</a></nobr>
                        <nobr><a onclick="goCity(this)">厦门</a></nobr>
                        <nobr><a onclick="goCity(this)">漳州</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" onclick="goCity(this)">甘肃</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">兰州</a></nobr>
                        <nobr><a onclick="goCity(this)">白银</a></nobr>
                        <nobr><a onclick="goCity(this)">定西</a></nobr>
                        <nobr><a name="甘南藏族自治州" onclick="goCity(this)">甘南州</a></nobr>
                        <nobr><a onclick="goCity(this)">嘉峪关</a></nobr>
                        <nobr><a onclick="goCity(this)">金昌</a></nobr>
                        <nobr><a onclick="goCity(this)">酒泉</a></nobr>
                        <nobr><a name="临夏回族自治州" onclick="goCity(this)">临夏州</a></nobr>
                        <nobr><a onclick="goCity(this)">平凉</a></nobr>
                        <nobr><a onclick="goCity(this)">庆阳</a></nobr>
                        <nobr><a onclick="goCity(this)">天水</a></nobr>
                        <nobr><a onclick="goCity(this)">武威</a></nobr>
                        <nobr><a onclick="goCity(this)">张掖</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" onclick="goCity(this)">广东</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">广州</a></nobr>
                        <nobr><a onclick="goCity(this)">潮州</a></nobr>
                        <nobr><a onclick="goCity(this)">东莞</a></nobr>
                        <nobr><a onclick="goCity(this)">佛山</a></nobr>
                        <nobr><a onclick="goCity(this)">河源</a></nobr>
                        <nobr><a onclick="goCity(this)">惠州</a></nobr>
                        <nobr><a onclick="goCity(this)">江门</a></nobr>
                        <nobr><a onclick="goCity(this)">揭阳</a></nobr>
                        <nobr><a onclick="goCity(this)">茂名</a></nobr>
                        <nobr><a onclick="goCity(this)">梅州</a></nobr>
                        <nobr><a onclick="goCity(this)">清远</a></nobr>
                        <nobr><a onclick="goCity(this)">汕头</a></nobr>
                        <nobr><a onclick="goCity(this)">汕尾</a></nobr>
                        <nobr><a onclick="goCity(this)">韶关</a></nobr>
                        <nobr><a onclick="goCity(this)">深圳</a></nobr>
                        <nobr><a onclick="goCity(this)">阳江</a></nobr>
                        <nobr><a onclick="goCity(this)">云浮</a></nobr>
                        <nobr><a onclick="goCity(this)">湛江</a></nobr>
                        <nobr><a onclick="goCity(this)">肇庆</a></nobr>
                        <nobr><a onclick="goCity(this)">中山</a></nobr>
                        <nobr><a onclick="goCity(this)">珠海</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" onclick="goCity(this)">广西</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">南宁</a></nobr>
                        <nobr><a onclick="goCity(this)">百色</a></nobr>
                        <nobr><a onclick="goCity(this)">北海</a></nobr>
                        <nobr><a onclick="goCity(this)">崇左</a></nobr>
                        <nobr><a onclick="goCity(this)">防城港</a></nobr>
                        <nobr><a onclick="goCity(this)">桂林</a></nobr>
                        <nobr><a onclick="goCity(this)">贵港</a></nobr>
                        <nobr><a onclick="goCity(this)">河池</a></nobr>
                        <nobr><a onclick="goCity(this)">贺州</a></nobr>
                        <nobr><a onclick="goCity(this)">来宾</a></nobr>
                        <nobr><a onclick="goCity(this)">柳州</a></nobr>
                        <nobr><a onclick="goCity(this)">钦州</a></nobr>
                        <nobr><a onclick="goCity(this)">梧州</a></nobr>
                        <nobr><a onclick="goCity(this)">玉林</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" onclick="goCity(this)">贵州</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">贵阳</a></nobr>
                        <nobr><a onclick="goCity(this)">安顺</a></nobr>
                        <nobr><a onclick="goCity(this)">毕节地区</a></nobr>
                        <nobr><a onclick="goCity(this)">六盘水</a></nobr>
                        <nobr><a onclick="goCity(this)">铜仁地区</a></nobr>
                        <nobr><a onclick="goCity(this)">遵义</a></nobr>
                        <nobr><a name="黔西南布依族苗族自治州" onclick="goCity(this)">黔西南州</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" onclick="goCity(this)">海南</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">海口</a></nobr>
                        <nobr><a name="白沙黎族自治县" onclick="goCity(this)">白沙</a></nobr>
                        <nobr><a name="保亭黎族苗族自治县" onclick="goCity(this)">保亭</a></nobr>
                        <nobr><a name="昌江黎族自治县" onclick="goCity(this)">昌江</a></nobr>
                        <nobr><a onclick="goCity(this)">儋州</a></nobr>
                        <nobr><a onclick="goCity(this)" name="澄迈县">澄迈</a></nobr>
                        <nobr><a onclick="goCity(this)">东方</a></nobr>
                        <nobr><a onclick="goCity(this)" name="定安县">定安</a></nobr>
                        <nobr><a onclick="goCity(this)">琼海</a></nobr>
                        <nobr><a name="琼中黎族苗族自治县" onclick="goCity(this)">琼中</a></nobr>
                        <nobr><a name="乐东黎族自治县" onclick="goCity(this)">乐东</a></nobr>
                        <nobr><a onclick="goCity(this)" name="临高县">临高</a></nobr>
                        <nobr><a name="陵水黎族自治县" onclick="goCity(this)">陵水</a></nobr>
                        <nobr><a onclick="goCity(this)">三亚</a></nobr>
                        <nobr><a onclick="goCity(this)" name="屯昌县">屯昌</a></nobr>
                        <nobr><a onclick="goCity(this)">万宁</a></nobr>
                        <nobr><a onclick="goCity(this)">文昌</a></nobr>
                        <nobr><a onclick="goCity(this)">五指山</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" onclick="goCity(this)">河北</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">石家庄</a></nobr>
                        <nobr><a onclick="goCity(this)">保定</a></nobr>
                        <nobr><a onclick="goCity(this)">沧州</a></nobr>
                        <nobr><a onclick="goCity(this)">承德</a></nobr>
                        <nobr><a onclick="goCity(this)">邯郸</a></nobr>
                        <nobr><a onclick="goCity(this)">衡水</a></nobr>
                        <nobr><a onclick="goCity(this)">廊坊</a></nobr>
                        <nobr><a onclick="goCity(this)">秦皇岛</a></nobr>
                        <nobr><a onclick="goCity(this)">唐山</a></nobr>
                        <nobr><a onclick="goCity(this)">邢台</a></nobr>
                        <nobr><a onclick="goCity(this)">张家口</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" onclick="goCity(this)">河南</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">郑州</a></nobr>
                        <nobr><a onclick="goCity(this)">安阳</a></nobr>
                        <nobr><a onclick="goCity(this)">鹤壁</a></nobr>
                        <nobr><a onclick="goCity(this)">焦作</a></nobr>
                        <nobr><a onclick="goCity(this)">开封</a></nobr>
                        <nobr><a onclick="goCity(this)">洛阳</a></nobr>
                        <nobr><a onclick="goCity(this)">漯河</a></nobr>
                        <nobr><a onclick="goCity(this)">南阳</a></nobr>
                        <nobr><a onclick="goCity(this)">平顶山</a></nobr>
                        <nobr><a onclick="goCity(this)">濮阳</a></nobr>
                        <nobr><a onclick="goCity(this)">三门峡</a></nobr>
                        <nobr><a onclick="goCity(this)">商丘</a></nobr>
                        <nobr><a onclick="goCity(this)">新乡</a></nobr>
                        <nobr><a onclick="goCity(this)">信阳</a></nobr>
                        <nobr><a onclick="goCity(this)">许昌</a></nobr>
                        <nobr><a onclick="goCity(this)">周口</a></nobr>
                        <nobr><a onclick="goCity(this)">驻马店</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" onclick="goCity(this)">黑龙江</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">哈尔滨</a></nobr>
                        <nobr><a onclick="goCity(this)">大庆</a></nobr>
                        <nobr><a onclick="goCity(this)" name="大兴安岭地区">大兴安岭地区</a></nobr>
                        <nobr><a onclick="goCity(this)">鹤岗</a></nobr>
                        <nobr><a onclick="goCity(this)">黑河</a></nobr>
                        <nobr><a onclick="goCity(this)">鸡西</a></nobr>
                        <nobr><a onclick="goCity(this)">佳木斯</a></nobr>
                        <nobr><a onclick="goCity(this)">牡丹江</a></nobr>
                        <nobr><a onclick="goCity(this)">七台河</a></nobr>
                        <nobr><a onclick="goCity(this)">齐齐哈尔</a></nobr>
                        <nobr><a onclick="goCity(this)">双鸭山</a></nobr>
                        <nobr><a onclick="goCity(this)">绥化</a></nobr>
                        <nobr><a onclick="goCity(this)">伊春</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" onclick="goCity(this)">湖北</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">武汉</a></nobr>
                        <nobr><a onclick="goCity(this)">鄂州</a></nobr>
                        <nobr><a name="恩施土家族苗族自治州" onclick="goCity(this)">恩施</a></nobr>
                        <nobr><a onclick="goCity(this)">黄冈</a></nobr>
                        <nobr><a onclick="goCity(this)">黄石</a></nobr>
                        <nobr><a onclick="goCity(this)">荆门</a></nobr>
                        <nobr><a onclick="goCity(this)">荆州</a></nobr>
                        <nobr><a onclick="goCity(this)">潜江</a></nobr>
                        <nobr><a onclick="goCity(this)">神农架林区</a></nobr>
                        <nobr><a onclick="goCity(this)">十堰</a></nobr>
                        <nobr><a onclick="goCity(this)">随州</a></nobr>
                        <nobr><a onclick="goCity(this)">天门</a></nobr>
                        <nobr><a onclick="goCity(this)">仙桃</a></nobr>
                        <nobr><a onclick="goCity(this)">咸宁</a></nobr>
                        <nobr><a onclick="goCity(this)">襄樊</a></nobr>
                        <nobr><a onclick="goCity(this)">孝感</a></nobr>
                        <nobr><a onclick="goCity(this)">宜昌</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" onclick="goCity(this)">湖南</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">长沙</a></nobr>
                        <nobr><a onclick="goCity(this)">常德</a></nobr>
                        <nobr><a onclick="goCity(this)">郴州</a></nobr>
                        <nobr><a onclick="goCity(this)">衡阳</a></nobr>
                        <nobr><a onclick="goCity(this)">怀化</a></nobr>
                        <nobr><a onclick="goCity(this)">娄底</a></nobr>
                        <nobr><a onclick="goCity(this)">邵阳</a></nobr>
                        <nobr><a onclick="goCity(this)">湘潭</a></nobr>
                        <nobr><a onclick="goCity(this)">益阳</a></nobr>
                        <nobr><a onclick="goCity(this)">永州</a></nobr>
                        <nobr><a onclick="goCity(this)">岳阳</a></nobr>
                        <nobr><a onclick="goCity(this)">张家界</a></nobr>
                        <nobr><a onclick="goCity(this)">株洲</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" onclick="goCity(this)">江苏</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">南京</a></nobr>
                        <nobr><a onclick="goCity(this)">常州</a></nobr>
                        <nobr><a onclick="goCity(this)">淮安</a></nobr>
                        <nobr><a onclick="goCity(this)">连云港</a></nobr>
                        <nobr><a onclick="goCity(this)">南通</a></nobr>
                        <nobr><a onclick="goCity(this)">苏州</a></nobr>
                        <nobr><a onclick="goCity(this)">宿迁</a></nobr>
                        <nobr><a onclick="goCity(this)">泰州</a></nobr>
                        <nobr><a onclick="goCity(this)">无锡</a></nobr>
                        <nobr><a onclick="goCity(this)">徐州</a></nobr>
                        <nobr><a onclick="goCity(this)">盐城</a></nobr>
                        <nobr><a onclick="goCity(this)">扬州</a></nobr>
                        <nobr><a onclick="goCity(this)">镇江</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" onclick="goCity(this)">江西</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">南昌</a></nobr>
                        <nobr><a onclick="goCity(this)">抚州</a></nobr>
                        <nobr><a onclick="goCity(this)">赣州</a></nobr>
                        <nobr><a onclick="goCity(this)">吉安</a></nobr>
                        <nobr><a onclick="goCity(this)">景德镇</a></nobr>
                        <nobr><a onclick="goCity(this)">九江</a></nobr>
                        <nobr><a onclick="goCity(this)">萍乡</a></nobr>
                        <nobr><a onclick="goCity(this)">上饶</a></nobr>
                        <nobr><a onclick="goCity(this)">新余</a></nobr>
                        <nobr><a onclick="goCity(this)">宜春</a></nobr>
                        <nobr><a onclick="goCity(this)">鹰潭</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" name="吉林省" onclick="goCity(this)">吉林</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">长春</a></nobr>
                        <nobr><a onclick="goCity(this)">白城</a></nobr>
                        <nobr><a onclick="goCity(this)">白山</a></nobr>
                        <nobr><a onclick="goCity(this)">吉林市</a></nobr>
                        <nobr><a onclick="goCity(this)" /></nobr>
                        <nobr><a onclick="goCity(this)">辽源</a></nobr>
                        <nobr><a onclick="goCity(this)">四平</a></nobr>
                        <nobr><a onclick="goCity(this)">松原</a></nobr>
                        <nobr><a onclick="goCity(this)">通化</a></nobr>
                        <nobr><a name="延边朝鲜族自治州" onclick="goCity(this)">延边</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td><a class="black" onclick="goCity(this)">辽宁</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">沈阳</a></nobr>
                        <nobr><a onclick="goCity(this)">鞍山</a></nobr>
                        <nobr><a onclick="goCity(this)">本溪</a></nobr>
                        <nobr><a onclick="goCity(this)">朝阳</a></nobr>
                        <nobr><a onclick="goCity(this)">大连</a></nobr>
                        <nobr><a onclick="goCity(this)">丹东</a></nobr>
                        <nobr><a onclick="goCity(this)">抚顺</a></nobr>
                        <nobr><a onclick="goCity(this)">阜新</a></nobr>
                        <nobr><a onclick="goCity(this)">葫芦岛</a></nobr>
                        <nobr><a onclick="goCity(this)">锦州</a></nobr>
                        <nobr><a onclick="goCity(this)">辽阳</a></nobr>
                        <nobr><a onclick="goCity(this)">盘锦</a></nobr>
                        <nobr><a onclick="goCity(this)">铁岭</a></nobr>
                        <nobr><a onclick="goCity(this)">营口</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" onclick="goCity(this)">内蒙古</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">呼和浩特</a></nobr>
                        <nobr><a onclick="goCity(this)">包头</a></nobr>
                        <nobr><a onclick="goCity(this)">巴彦淖尔</a></nobr>
                        <nobr><a onclick="goCity(this)">赤峰</a></nobr>
                        <nobr><a onclick="goCity(this)">鄂尔多斯</a></nobr>
                        <nobr><a onclick="goCity(this)">呼伦贝尔</a></nobr>
                        <nobr><a onclick="goCity(this)">通辽</a></nobr>
                        <nobr><a onclick="goCity(this)">乌海</a></nobr>
                        <nobr><a onclick="goCity(this)">乌兰察布</a></nobr>
                        <nobr><a onclick="goCity(this)" name="兴安盟">兴安盟</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" onclick="goCity(this)">宁夏</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">银川</a></nobr>
                        <nobr><a onclick="goCity(this)">固原</a></nobr>
                        <nobr><a onclick="goCity(this)">石嘴山</a></nobr>
                        <nobr><a onclick="goCity(this)">吴忠</a></nobr>
                        <nobr><a onclick="goCity(this)">中卫</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" onclick="goCity(this)">青海</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">西宁</a></nobr>
                        <nobr><a name="果洛藏族自治州" onclick="goCity(this)">果洛州</a></nobr>
                        <nobr><a onclick="goCity(this)" name="海东地区">海东地区</a></nobr>
                        <nobr><a name="海北藏族自治州" onclick="goCity(this)">海北州</a></nobr>
                        <nobr><a name="海南藏族自治州" onclick="goCity(this)">海南州</a></nobr>
                        <nobr><a name="海西蒙古族藏族自治州" onclick="goCity(this)">海西州</a></nobr>
                        <nobr><a name="黄南藏族自治州" onclick="goCity(this)">黄南州</a></nobr>
                        <nobr><a name="玉树藏族自治州" onclick="goCity(this)">玉树州</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" onclick="goCity(this)">山东</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">济南</a></nobr>
                        <nobr><a onclick="goCity(this)">滨州</a></nobr>
                        <nobr><a onclick="goCity(this)">东营</a></nobr>
                        <nobr><a onclick="goCity(this)">德州</a></nobr>
                        <nobr><a onclick="goCity(this)">菏泽</a></nobr>
                        <nobr><a onclick="goCity(this)">济宁</a></nobr>
                        <nobr><a onclick="goCity(this)">莱芜</a></nobr>
                        <nobr><a onclick="goCity(this)">聊城</a></nobr>
                        <nobr><a onclick="goCity(this)">临沂</a></nobr>
                        <nobr><a onclick="goCity(this)">青岛</a></nobr>
                        <nobr><a onclick="goCity(this)">日照</a></nobr>
                        <nobr><a onclick="goCity(this)">泰安</a></nobr>
                        <nobr><a onclick="goCity(this)">威海</a></nobr>
                        <nobr><a onclick="goCity(this)">潍坊</a></nobr>
                        <nobr><a onclick="goCity(this)">烟台</a></nobr>
                        <nobr><a onclick="goCity(this)">枣庄</a></nobr>
                        <nobr><a onclick="goCity(this)">淄博</a></nobr>
                        <nobr><a onclick="goCity(this)" /></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" onclick="goCity(this)">山西</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">太原</a></nobr>
                        <nobr><a onclick="goCity(this)">长治</a></nobr>
                        <nobr><a onclick="goCity(this)">大同</a></nobr>
                        <nobr><a onclick="goCity(this)">晋城</a></nobr>
                        <nobr><a onclick="goCity(this)">晋中</a></nobr>
                        <nobr><a onclick="goCity(this)">临汾</a></nobr>
                        <nobr><a onclick="goCity(this)">吕梁</a></nobr>
                        <nobr><a onclick="goCity(this)">朔州</a></nobr>
                        <nobr><a onclick="goCity(this)">忻州</a></nobr>
                        <nobr><a onclick="goCity(this)">阳泉</a></nobr>
                        <nobr><a onclick="goCity(this)">运城</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" onclick="goCity(this)">陕西</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">西安</a></nobr>
                        <nobr><a onclick="goCity(this)">安康</a></nobr>
                        <nobr><a onclick="goCity(this)">宝鸡</a></nobr>
                        <nobr><a onclick="goCity(this)">汉中</a></nobr>
                        <nobr><a onclick="goCity(this)">商洛</a></nobr>
                        <nobr><a onclick="goCity(this)">铜川</a></nobr>
                        <nobr><a onclick="goCity(this)">渭南</a></nobr>
                        <nobr><a onclick="goCity(this)">咸阳</a></nobr>
                        <nobr><a onclick="goCity(this)">延安</a></nobr>
                        <nobr><a onclick="goCity(this)">榆林</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" onclick="goCity(this)">四川</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">成都</a></nobr>
                        <nobr><a name="阿坝藏族羌族自治州" onclick="goCity(this)">阿坝州</a></nobr>
                        <nobr><a onclick="goCity(this)">巴中</a></nobr>
                        <nobr><a onclick="goCity(this)">达州</a></nobr>
                        <nobr><a onclick="goCity(this)">德阳</a></nobr>
                        <nobr><a name="甘孜藏族自治州" onclick="goCity(this)">甘孜州</a></nobr>
                        <nobr><a onclick="goCity(this)">广安</a></nobr>
                        <nobr><a onclick="goCity(this)">广元</a></nobr>
                        <nobr><a onclick="goCity(this)">乐山</a></nobr>
                        <nobr><a name="凉山彝族自治州" onclick="goCity(this)">凉山州</a></nobr>
                        <nobr><a onclick="goCity(this)">泸州</a></nobr>
                        <nobr><a onclick="goCity(this)">南充</a></nobr>
                        <nobr><a onclick="goCity(this)">眉山</a></nobr>
                        <nobr><a onclick="goCity(this)">绵阳</a></nobr>
                        <nobr><a onclick="goCity(this)">内江</a></nobr>
                        <nobr><a onclick="goCity(this)">攀枝花</a></nobr>
                        <nobr><a onclick="goCity(this)">遂宁</a></nobr>
                        <nobr><a onclick="goCity(this)">雅安</a></nobr>
                        <nobr><a onclick="goCity(this)">宜宾</a></nobr>
                        <nobr><a onclick="goCity(this)">资阳</a></nobr>
                        <nobr><a onclick="goCity(this)">自贡</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" onclick="goCity(this)">西藏</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">拉萨</a></nobr>
                        <nobr><a onclick="goCity(this)" name="阿里地区">阿里地区</a></nobr>
                        <nobr><a onclick="goCity(this)" name="昌都地区">昌都地区</a></nobr>
                        <nobr><a onclick="goCity(this)" name="林芝地区">林芝地区</a></nobr>
                        <nobr><a onclick="goCity(this)" name="那曲地区">那曲地区</a></nobr>
                        <nobr><a onclick="goCity(this)" name="日喀则地区">日喀则地区</a></nobr>
                        <nobr><a onclick="goCity(this)" name="山南地区">山南地区</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" onclick="goCity(this)">新疆</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">乌鲁木齐</a></nobr>
                        <nobr><a onclick="goCity(this)">阿拉尔</a></nobr>
                        <nobr><a onclick="goCity(this)" name="阿克苏地区">阿克苏地区</a></nobr>
                        <nobr><a onclick="goCity(this)">阿勒泰地区</a></nobr>
                        <nobr><a name="昌吉回族自治州" onclick="goCity(this)">昌吉州</a></nobr>
                        <nobr><a onclick="goCity(this)">哈密地区</a></nobr>
                        <nobr><a onclick="goCity(this)">和田地区</a></nobr>
                        <nobr><a onclick="goCity(this)">喀什地区</a></nobr>
                        <nobr><a onclick="goCity(this)">克拉玛依</a></nobr>
                        <nobr><a onclick="goCity(this)">石河子</a></nobr>
                        <nobr><a onclick="goCity(this)">塔城地区</a></nobr>
                        <nobr><a onclick="goCity(this)">吐鲁番地区</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" onclick="goCity(this)">云南</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">昆明</a></nobr>
                        <nobr><a onclick="goCity(this)">保山</a></nobr>
                        <nobr><a name="楚雄彝族自治州" onclick="goCity(this)">楚雄州</a></nobr>
                        <nobr><a name="大理白族自治州" onclick="goCity(this)">大理州</a></nobr>
                        <nobr><a name="德宏傣族景颇族自治州" onclick="goCity(this)">德宏州</a></nobr>
                        <nobr><a name="迪庆藏族自治州" onclick="goCity(this)">迪庆州</a></nobr>
                        <nobr><a name="红河哈尼族彝族自治州" onclick="goCity(this)">红河州</a></nobr>
                        <nobr><a onclick="goCity(this)">丽江</a></nobr>
                        <nobr><a onclick="goCity(this)">临沧</a></nobr>
                        <nobr><a name="怒江傈僳族自治州" onclick="goCity(this)">怒江州</a></nobr>
                        <nobr><a onclick="goCity(this)">普洱</a></nobr>
                        <nobr><a onclick="goCity(this)">曲靖</a></nobr>
                        <nobr><a onclick="goCity(this)">昭通</a></nobr>
                        <nobr><a name="文山壮族苗族自治州" onclick="goCity(this)">文山</a></nobr>
                        <nobr><a name="西双版纳傣族自治州" onclick="goCity(this)">西双版纳</a></nobr>
                        <nobr><a onclick="goCity(this)">玉溪</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td>
                        <nobr><a class="black" onclick="goCity(this)">浙江</a></nobr>：</td>
                    <td>
                        <nobr><a onclick="goCity(this)">杭州</a></nobr>
                        <nobr><a onclick="goCity(this)">湖州</a></nobr>
                        <nobr><a onclick="goCity(this)">嘉兴</a></nobr>
                        <nobr><a onclick="goCity(this)">金华</a></nobr>
                        <nobr><a onclick="goCity(this)">丽水</a></nobr>
                        <nobr><a onclick="goCity(this)">宁波</a></nobr>
                        <nobr><a onclick="goCity(this)">衢州</a></nobr>
                        <nobr><a onclick="goCity(this)">绍兴</a></nobr>
                        <nobr><a onclick="goCity(this)">台州</a></nobr>
                        <nobr><a onclick="goCity(this)">温州</a></nobr>
                        <nobr><a onclick="goCity(this)">舟山</a></nobr>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <nobr><a onclick="goCity(this)" name="香港特别行政区">香港</a></nobr>
                        <nobr><a onclick="goCity(this)" name="澳门特别行政区">澳门</a></nobr>
                        <nobr><a onclick="goCity(this)" name="台北县">台湾</a></nobr>
                    </td>
                </tr>
            </table>
        </div><button onclick="hidePop()"></button></div>
    <div class="poput_shadow" style="height: 291px;width:100%"></div>
</div>
<!--更换城市 end-->

</body>
<script type="text/javascript" src="http://api.map.baidu.com/lbsapi/getpoint/Js/clipboard.min.js?update"></script>
<script>
  loadBody();
</script>


</html>