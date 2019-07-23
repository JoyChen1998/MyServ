<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
<head>
    <!-- Basic Page Needs
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>JoyChan's web proj</title>
    <meta name="description" content="">

    <!-- Mobile Specific Metas
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- FONT
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link href='https://fonts.googleapis.com/css?family=Raleway:400,600,700,800' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Libre+Baskerville:400,700,400italic" rel="stylesheet" type="text/css">

    <!-- CSS
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link rel="stylesheet" href="./css/styles.css">


    <!-- Favicon
    –––––––––––––––––––––––––––––––––––––––––––––––––– -->
    <link rel="shortcut icon" href="./favicon.ico"/>
    <script src="/chart/code/highcharts.js"></script>
    <script src="/chart/code/highcharts-3d.js"></script>
    <script src="/js/jquery-3.4.1.min.js"></script>

    <script>
        $(function () {
            $(".sub-btn").click(function () {
                let it = $('#goo').val();
                $.ajax({
                    type: "get",
                    //url: "https://req.jyc1998.cn/item?item="+it,
                    // send msg for scrapy all items.
                    success: function (data) {
                        console.log('data', data);
                    },
                    error: function (res) {
                        console.log("错误信息：" + res.text);
                    }

                })
            });

            $(".item-btn").click(function () {
                let goods_name = $(this).attr('name');
                console.log(goods_name);
                $.ajax({
                    type: "get",
                    //url: "https://req.jyc1998.cn/gvalue?value="+goods_name,
                    // send msg for classify
                    success: function (data) {
                        console.log('data', data);
                            $.ajax({
                                type: "GET",
                                url:  "api.php",
                                success: function (data) {
                                    $('#container1').show();
                                    $('#container2').show();
                                    let content = JSON.parse(data);
                                    console.log(content['data']);

                                    let arr = content['data'];
                                    let score_arr = Array(0,0,0,0,0);
                                    let vip_array = Array(0,0,0,0,0,0);
                                    for (let i of arr){
                                        score_arr[parseInt(i['score'])-1]++;
                                        switch (i['level']){
                                            case '铜牌会员':
                                                vip_array[0]++;
                                                break;
                                            case '银牌会员':
                                                vip_array[1]++;
                                                break;
                                            case '金牌会员':
                                                vip_array[2]++;
                                                break;
                                            case '钻石会员':
                                                vip_array[3]++;
                                                break;
                                            case 'PLUS会员':
                                                vip_array[4]++;
                                                break;
                                            default:
                                                vip_array[5]++;
                                        }
                                    }
                                    console.log(vip_array);
                                    // if success , show chart 
                                    showchart(score_arr, vip_array);
                                },
                                error: function () {
                                    alert("error ajax");
                                }
                            })
                    },
                    error: function (res) {
                        console.log("错误信息：" + res.text);
                    }

                })
            });
        });


        function showchart(arr1, vip_arr) {
            Highcharts.chart('container1', {
                chart: {
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45,
                        beta: 0
                    }
                },
                title: {
                    text: 'Part of item\'s remark score, 2019'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        depth: 35,
                        dataLabels: {
                            enabled: true,
                            format: '{point.name}'
                        }
                    }
                },
                series: [{
                    type: 'pie',
                    name: 'score',
                    data: [
                        ['score 5', arr1[4]],
                        ['score 4', arr1[3]],
                        {
                            name: 'score 1',
                            y: arr1[0],
                            sliced: true,
                            selected: true
                        },
                        ['score 3', arr1[2]],
                        ['score 2', arr1[1]],
                    ]
                }]
            });


            Highcharts.chart('container2', {
                chart: {
                    type: 'pie',
                    options3d: {
                        enabled: true,
                        alpha: 45
                    }
                },
                title: {
                    text: 'JD all kinds of costumers\'s remark'
                },
                plotOptions: {
                    pie: {
                        innerSize: 100,
                        depth: 45
                    }
                },
                series: [{
                    name: 'count',
                    data: [
                        ['铜牌会员', vip_arr[0]],
                        ['银牌会员', vip_arr[1]],
                        ['金牌会员', vip_arr[2]],
                        ['钻石会员', vip_arr[3]],
                        ['PLUS会员', vip_arr[4]],
                        ['其他', vip_arr[5]]
                    ]
                }]
            });

        }
    </script>
</head>

<body>
<!--[if lt IE 7]>
<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

<!-- Top Bar -->
<section class="top-bar">
    <div class="container">


    </div>
</section>

<!-- Header -->
<header class="header">
    <div class="container">
        <div class="logo">
            <a href="#">
                <h2>JoyChan's Tool</h2>

            </a>
        </div>
    </div>
</header>

<!-- Main Nav -->
<section class="container">
    <nav class="nav">


        <ul>
            <li><a href="https://www.jyc1998.cn">Blog</a></li>
            <li><a href="index.html">Index</a></li>
            <li><a href="tool.php">Tool</a></li>
            <li><a href="contact.html">Contact</a></li>

        </ul>
    </nav>
</section>

<section class="main container">

    <input type="text" class="input-box" name="goo" id="goo" placeholder="Input item for search"/>
<button class="sub-btn" >submit</button>

<div id="container1" style="height: 400px; display: none"></div>
<div id="container2" style="min-width: 310px; height: 400px; max-width: 800px; margin: 0 auto; display: none"></div>
<br>

<?php
    include "search.php";
?>
</section>

<!-- Footer -->



<footer>
    <div class="inner">
        <div class="container">
            <div class="copyright">
                <span class="sub">© Copyright 2019 Aristotheme - All Rights Reserved.</span>
            </div>

            <a href="#0" class="backtotop">Top</a>
        </div>
    </div>
</footer>

</body>

</html>
