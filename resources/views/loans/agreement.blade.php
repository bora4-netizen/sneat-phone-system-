<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+Khmer:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/assets/vendor/css/pages/app-invoice-print.css') }}" />
     <!-- Begin shared CSS values -->
     <style class="shared-css" type="text/css" >
        body{
            margin: 0 auto;
            font-family: 'Noto Serif Khmer', serif;
        }
        .font-w-700{
            font-weight: 700
        }
        #content-to-pdf{
            overflow: hidden;
            position: relative;
            background-color: white;
            width: 909px;
            height: 1286px;
            margin: 0 auto
        }
        #pg1Overlay{
            width:100%;
            height:100%;
            position:absolute;
            z-index:1;
            background-color:rgba(0,0,0,0);
            -webkit-user-select: none;
        }
        strong i{
            border-bottom: 1px dotted black;
            padding-left:10px;
            padding-right:10px;
            font-size: 13px
        }
        strong.py-10 i{
          padding-left:10px !important;
          padding-right:10px !important;
        }
        .t {
          transform-origin: bottom left;
          z-index: 2;
          position: absolute;
          white-space: pre;
          overflow: visible;
          line-height: 1.5;
        }
        .text-container {
          white-space: pre;
        }
        @supports (-webkit-touch-callout: none) {
          .text-container {
            white-space: normal;
          }
        }
        </style>
        <!-- End shared CSS values -->
        <style type="text/css" media="print">
          @page
          {
              size: auto;   /* auto is the initial value */
              margin: 0mm;  /* this affects the margin in the printer settings */
          }
        </style>
        <!-- Begin inline CSS -->
        <style type="text/css" >

          #t1_1{left:30px;bottom:928px;}
          #t2_1{left:34px;bottom:928px;letter-spacing:0.13px;}
          #t3_1{left:76px;bottom:928px;letter-spacing:-0.01px;}
          #t4_1{left:97px;bottom:928px;letter-spacing:0.11px;word-spacing:-0.04px;}
          #t5_1{left:30px;bottom:906px;}
          #t6_1{left:34px;bottom:906px;letter-spacing:0.13px;}
          #t7_1{left:76px;bottom:906px;letter-spacing:-0.01px;}
          #t8_1{left:97px;bottom:906px;letter-spacing:0.11px;word-spacing:-0.03px;}
          #t9_1{left:30px;bottom:885px;letter-spacing:0.15px;}
          #ta_1{left:103px;bottom:885px;letter-spacing:0.12px;}
          #tb_1{left:241px;bottom:885px;}
          #tc_1{left:241px;bottom:881px;}
          #td_1{left:241px;bottom:885px;letter-spacing:0.12px;}
          #te_1{left:408px;bottom:883px;}
          #tf_1{left:408px;bottom:885px;letter-spacing:0.12px;}
          #tg_1{left:500px;bottom:883px;}
          #th_1{left:30px;bottom:864px;letter-spacing:-0.05px;word-spacing:0.92px;}
          #ti_1{left:211px;bottom:864px;letter-spacing:0.13px;}
          #tj_1{left:244px;bottom:864px;letter-spacing:0.07px;word-spacing:0.6px;}
          #tk_1{left:264px;bottom:864px;letter-spacing:0.12px;}
          #tl_1{left:443px;bottom:864px;letter-spacing:0.12px;}
          #tm_1{left:484px;bottom:861px;}
          #tn_1{left:30px;bottom:842px;letter-spacing:0.12px;}
          #to_1{left:312px;bottom:842px;}
          #tp_1{left:312px;bottom:840px;}
          #tq_1{left:312px;bottom:842px;}
          #tr_1{left:316px;bottom:842px;letter-spacing:0.19px;}
          #ts_1{left:30px;bottom:821px;letter-spacing:-0.25px;word-spacing:0.34px;}
          #tt_1{left:120px;bottom:821px;letter-spacing:-0.07px;word-spacing:0.19px;}
          #tu_1{left:265px;bottom:821px;letter-spacing:0.12px;}
          #tv_1{left:451px;bottom:819px;}
          #tw_1{left:451px;bottom:821px;letter-spacing:0.1px;}
          #tx_1{left:542px;bottom:819px;}
          #ty_1{left:542px;bottom:821px;letter-spacing:0.12px;}
          #tz_1{left:641px;bottom:975px;letter-spacing:0.14px;}
          #t10_1{left:694px;bottom:966px;}
          #t11_1{left:695px;bottom:968px;letter-spacing:0.15px;}
          #t12_1{left:641px;bottom:955px;}
          #t13_1{left:645px;bottom:948px;letter-spacing:0.17px;}
          #t14_1{left:692px;bottom:946px;}
          #t15_1{left:692px;bottom:948px;letter-spacing:0.15px;}
          #t16_1{left:641px;bottom:935px;letter-spacing:0.37px;}
          #t16_2{left:641px;bottom:915px;letter-spacing:0.37px;}
          #t16_3{left:765px;bottom:915px;letter-spacing:0.37px;}
          #t17_1{left:649px;bottom:928px;letter-spacing:0.1px;}
          #t18_1{left:38px;bottom:66px;}
          #t19_1{left:42px;bottom:66px;letter-spacing:0.16px;}
          #t1a_1{left:77px;bottom:66px;letter-spacing:0.1px;}
          #t1b_1{left:94px;bottom:66px;}
          #t1c_1{left:94px;bottom:64px;}
          #t1d_1{left:94px;bottom:66px;letter-spacing:0.12px;}
          #t1e_1{left:38px;bottom:43px;}
          #t1f_1{left:42px;bottom:43px;letter-spacing:0.1px;}
          #t1g_1{left:59px;bottom:41px;}
          #t1h_1{left:59px;bottom:43px;letter-spacing:0.12px;}
          #t1i_1{left:146px;bottom:517px;letter-spacing:0.11px;}
          #t1j_1{left:171px;bottom:517px;}
          #t1k_1{left:171px;bottom:515px;}
          #t1l_1{left:53px;bottom:495px;letter-spacing:0.13px;}
          #t1m_1{left:82px;bottom:495px;}
          #t1n_1{left:93px;bottom:495px;letter-spacing:0.14px;word-spacing:2.39px;}
          #t1o_1{left:137px;bottom:495px;}
          #t1p_1{left:174px;bottom:495px;letter-spacing:0.09px;}
          #t1q_1{left:245px;bottom:495px;letter-spacing:0.11px;}
          #t1r_1{left:53px;bottom:474px;letter-spacing:0.11px;}
          #t1s_1{left:111px;bottom:472px;}
          #t1t_1{left:116px;bottom:474px;}
          #t1u_1{left:174px;bottom:474px;letter-spacing:0.09px;}
          #t1v_1{left:245px;bottom:474px;letter-spacing:0.11px;}
          #t1w_1{left:53px;bottom:452px;letter-spacing:0.11px;}
          #t1x_1{left:111px;bottom:450px;}
          #t1y_1{left:116px;bottom:452px;}
          #t1z_1{left:174px;bottom:452px;letter-spacing:0.09px;}
          #t20_1{left:245px;bottom:452px;letter-spacing:0.13px;}
          #t21_1{left:53px;bottom:431px;}
          #t22_1{left:57px;bottom:431px;letter-spacing:0.17px;}
          #t23_1{left:24px;bottom:363px;}
          #t24_1{left:34px;bottom:363px;letter-spacing:-0.04px;}
          #t25_1{left:63px;bottom:363px;letter-spacing:-0.06px;}
          #t26_1{left:80px;bottom:362px;}
          #t27_1{left:80px;bottom:363px;letter-spacing:-0.04px;}
          #t28_1{left:131px;bottom:362px;}
          #t29_1{left:131px;bottom:363px;letter-spacing:-0.04px;}
          #t2a_1{left:426px;bottom:363px;}
          #t2b_1{left:426px;bottom:360px;}
          #t2c_1{left:426px;bottom:363px;letter-spacing:-0.05px;}
          #t2d_1{left:453px;bottom:362px;}
          #t2e_1{left:460px;bottom:363px;letter-spacing:-0.03px;}
          #t2f_1{left:479px;bottom:363px;}
          #t2g_1{left:484px;bottom:363px;}
          #t2h_1{left:491px;bottom:363px;letter-spacing:-0.04px;}
          #t2i_1{left:546px;bottom:362px;}
          #t2j_1{left:546px;bottom:363px;letter-spacing:-0.04px;}
          #t2k_1{left:580px;bottom:362px;}
          #t2l_1{left:579px;bottom:363px;letter-spacing:-0.05px;}
          #t2m_1{left:661px;bottom:362px;}
          #t2n_1{left:661px;bottom:363px;letter-spacing:-0.04px;}
          #t2o_1{left:694px;bottom:362px;}
          #t2p_1{left:694px;bottom:363px;letter-spacing:-0.03px;}
          #t2q_1{left:742px;bottom:362px;}
          #t2r_1{left:742px;bottom:363px;letter-spacing:-0.04px;}
          #t2s_1{left:811px;bottom:363px;letter-spacing:-0.03px;word-spacing:0.24px;}
          #t2t_1{left:844px;bottom:363px;letter-spacing:-0.03px;}
          #t2u_1{left:864px;bottom:363px;}
          #t2v_1{left:868px;bottom:363px;}
          #t2w_1{left:875px;bottom:363px;}
          #t2x_1{left:24px;bottom:345px;letter-spacing:-0.02px;}
          #t2y_1{left:30px;bottom:342px;}
          #t2z_1{left:31px;bottom:345px;letter-spacing:-0.05px;}
          #t30_1{left:58px;bottom:343px;}
          #t31_1{left:64px;bottom:345px;letter-spacing:-0.04px;}
          #t32_1{left:84px;bottom:345px;}
          #t33_1{left:89px;bottom:345px;}
          #t34_1{left:95px;bottom:345px;letter-spacing:-0.04px;}
          #t35_1{left:151px;bottom:343px;}
          #t36_1{left:151px;bottom:345px;letter-spacing:-0.04px;}
          #t37_1{left:181px;bottom:343px;}
          #t38_1{left:181px;bottom:345px;letter-spacing:-0.05px;}
          #t39_1{left:238px;bottom:343px;}
          #t3a_1{left:239px;bottom:345px;letter-spacing:-0.06px;}
          #t3b_1{left:256px;bottom:343px;}
          #t3c_1{left:256px;bottom:345px;letter-spacing:-0.04px;}
          #t3d_1{left:284px;bottom:345px;letter-spacing:-0.04px;}
          #t3e_1{left:301px;bottom:345px;}
          #t3f_1{left:305px;bottom:345px;}
          #t3g_1{left:312px;bottom:345px;letter-spacing:-0.05px;}
          #t3h_1{left:346px;bottom:343px;}
          #t3i_1{left:347px;bottom:345px;letter-spacing:-0.04px;}
          #t3j_1{left:455px;bottom:345px;}
          #t3k_1{left:455px;bottom:345px;}
          #t3l_1{left:499px;bottom:343px;}
          #t3m_1{left:499px;bottom:345px;letter-spacing:-0.04px;}
          #t3n_1{left:611px;bottom:342px;}
          #t3o_1{left:611px;bottom:345px;letter-spacing:-0.04px;}
          #t3p_1{left:677px;bottom:343px;}
          #t3q_1{left:677px;bottom:345px;}
          #t3r_1{left:681px;bottom:345px;}
          #t3s_1{left:688px;bottom:345px;letter-spacing:-0.03px;}
          #t3t_1{left:703px;bottom:343px;}
          #t3u_1{left:702px;bottom:345px;letter-spacing:-0.04px;}
          #t3v_1{left:777px;bottom:343px;}
          #t3w_1{left:777px;bottom:345px;letter-spacing:-0.06px;}
          #t3x_1{left:801px;bottom:343px;}
          #t3y_1{left:801px;bottom:345px;}
          #t3z_1{left:811px;bottom:345px;letter-spacing:-0.04px;}
          #t40_1{left:828px;bottom:345px;}
          #t41_1{left:833px;bottom:345px;}
          #t42_1{left:839px;bottom:345px;letter-spacing:-0.06px;}
          #t43_1{left:871px;bottom:343px;}
          #t44_1{left:871px;bottom:345px;letter-spacing:-0.02px;}
          #t45_1{left:24px;bottom:327px;letter-spacing:-0.04px;}
          #t46_1{left:149px;bottom:325px;}
          #t47_1{left:149px;bottom:327px;letter-spacing:-0.05px;}
          #t48_1{left:189px;bottom:323px;}
          #t49_1{left:189px;bottom:327px;letter-spacing:-0.31px;}
          #t4a_1{left:264px;bottom:327px;letter-spacing:-0.04px;}
          #t4b_1{left:336px;bottom:327px;letter-spacing:-0.05px;}
          #t4c_1{left:356px;bottom:325px;}
          #t4d_1{left:356px;bottom:327px;letter-spacing:-0.04px;}
          #t4e_1{left:373px;bottom:325px;}
          #t4f_1{left:373px;bottom:327px;letter-spacing:-0.03px;}
          #t4g_1{left:414px;bottom:327px;letter-spacing:-0.02px;}
          #t4h_1{left:421px;bottom:325px;}
          #t4i_1{left:421px;bottom:327px;letter-spacing:-0.04px;}
          #t4j_1{left:567px;bottom:327px;letter-spacing:-0.04px;}
          #t4k_1{left:584px;bottom:327px;}
          #t4l_1{left:589px;bottom:327px;}
          #t4m_1{left:596px;bottom:327px;letter-spacing:-0.04px;}
          #t4n_1{left:668px;bottom:325px;}
          #t4o_1{left:668px;bottom:327px;letter-spacing:-0.04px;}
          #t4p_1{left:721px;bottom:327px;letter-spacing:-0.04px;}
          #t4q_1{left:732px;bottom:327px;letter-spacing:-0.04px;}
          #t4r_1{left:762px;bottom:325px;}
          #t4s_1{left:762px;bottom:327px;letter-spacing:-0.03px;}
          #t4t_1{left:800px;bottom:327px;letter-spacing:-0.03px;}
          #t4u_1{left:24px;bottom:308px;}
          #t4v_1{left:34px;bottom:308px;letter-spacing:-0.04px;}
          #t4w_1{left:64px;bottom:308px;letter-spacing:-0.04px;}
          #t4x_1{left:81px;bottom:308px;}
          #t4y_1{left:86px;bottom:308px;}
          #t4z_1{left:93px;bottom:308px;letter-spacing:-0.03px;}
          #t50_1{left:154px;bottom:308px;}
          #t51_1{left:163px;bottom:308px;}
          #t52_1{left:168px;bottom:308px;letter-spacing:-0.02px;}
          #t53_1{left:187px;bottom:307px;}
          #t54_1{left:187px;bottom:308px;letter-spacing:-0.04px;}
          #t55_1{left:323px;bottom:307px;}
          #t56_1{left:323px;bottom:308px;letter-spacing:-0.05px;}
          #t57_1{left:356px;bottom:307px;}
          #t58_1{left:357px;bottom:308px;letter-spacing:-0.04px;}
          #t59_1{left:374px;bottom:307px;}
          #t5a_1{left:374px;bottom:308px;}
          #t5b_1{left:381px;bottom:307px;}
          #t5c_1{left:380px;bottom:308px;letter-spacing:-0.04px;}
          #t5d_1{left:455px;bottom:307px;}
          #t5e_1{left:455px;bottom:308px;letter-spacing:-0.03px;}
          #t5f_1{left:506px;bottom:308px;letter-spacing:-0.04px;}
          #t5g_1{left:516px;bottom:308px;letter-spacing:-0.04px;}
          #t5h_1{left:546px;bottom:307px;}
          #t5i_1{left:546px;bottom:308px;letter-spacing:-0.03px;}
          #t5j_1{left:584px;bottom:308px;letter-spacing:-0.04px;word-spacing:0.01px;}
          #t5k_1{left:24px;bottom:290px;}
          #t5l_1{left:34px;bottom:290px;letter-spacing:-0.04px;}
          #t5m_1{left:64px;bottom:290px;letter-spacing:-0.06px;}
          #t5n_1{left:81px;bottom:288px;}
          #t5o_1{left:81px;bottom:290px;letter-spacing:-0.05px;}
          #t5p_1{left:211px;bottom:290px;letter-spacing:-0.03px;}
          #t5q_1{left:228px;bottom:288px;}
          #t5r_1{left:228px;bottom:290px;letter-spacing:-0.06px;}
          #t5s_1{left:300px;bottom:290px;letter-spacing:-0.04px;}
          #t5t_1{left:317px;bottom:290px;}
          #t5u_1{left:321px;bottom:290px;}
          #t5v_1{left:328px;bottom:290px;}
          #t5w_1{left:338px;bottom:290px;letter-spacing:-0.04px;}
          #t5x_1{left:382px;bottom:290px;}
          #t5y_1{left:382px;bottom:287px;}
          #t5z_1{left:382px;bottom:290px;letter-spacing:-0.05px;}
          #t60_1{left:410px;bottom:288px;}
          #t61_1{left:413px;bottom:290px;}
          #t62_1{left:416px;bottom:290px;letter-spacing:-0.06px;}
          #t63_1{left:433px;bottom:290px;letter-spacing:-0.04px;}
          #t64_1{left:450px;bottom:290px;}
          #t65_1{left:455px;bottom:290px;}
          #t66_1{left:462px;bottom:290px;letter-spacing:-0.03px;}
          #t67_1{left:476px;bottom:288px;}
          #t68_1{left:476px;bottom:290px;letter-spacing:-0.04px;}
          #t69_1{left:541px;bottom:290px;letter-spacing:-0.02px;}
          #t6a_1{left:547px;bottom:288px;}
          #t6b_1{left:547px;bottom:290px;letter-spacing:-0.03px;}
          #t6c_1{left:585px;bottom:290px;letter-spacing:-0.05px;}
          #t6d_1{left:659px;bottom:290px;letter-spacing:-0.04px;}
          #t6e_1{left:741px;bottom:288px;}
          #t6f_1{left:741px;bottom:290px;letter-spacing:-0.04px;}
          #t6g_1{left:765px;bottom:288px;}
          #t6h_1{left:765px;bottom:290px;letter-spacing:-0.03px;}
          #t6i_1{left:798px;bottom:290px;}
          #t6j_1{left:798px;bottom:287px;}
          #t6k_1{left:798px;bottom:290px;letter-spacing:-0.04px;}
          #t6l_1{left:24px;bottom:272px;}
          #t6m_1{left:34px;bottom:272px;letter-spacing:-0.03px;}
          #t6n_1{left:63px;bottom:272px;}
          #t6o_1{left:70px;bottom:270px;}
          #t6p_1{left:70px;bottom:272px;letter-spacing:-0.03px;}
          #t6q_1{left:107px;bottom:272px;letter-spacing:-0.04px;}
          #t6r_1{left:142px;bottom:272px;}
          #t6s_1{left:142px;bottom:270px;}
          #t6t_1{left:142px;bottom:272px;}
          #t6u_1{left:146px;bottom:272px;}
          #t6v_1{left:156px;bottom:270px;}
          #t6w_1{left:156px;bottom:272px;letter-spacing:-0.04px;}
          #t6x_1{left:237px;bottom:271px;letter-spacing:-0.03px;}
          #t6y_1{left:258px;bottom:272px;letter-spacing:-0.02px;}
          #t6z_1{left:264px;bottom:270px;}
          #t70_1{left:264px;bottom:272px;letter-spacing:-0.06px;}
          #t71_1{left:281px;bottom:270px;}
          #t72_1{left:281px;bottom:272px;letter-spacing:-0.06px;}
          #t73_1{left:329px;bottom:270px;}
          #t74_1{left:329px;bottom:272px;letter-spacing:-0.05px;}
          #t75_1{left:355px;bottom:270px;}
          #t76_1{left:355px;bottom:272px;letter-spacing:-0.06px;}
          #t77_1{left:383px;bottom:270px;}
          #t78_1{left:383px;bottom:272px;letter-spacing:-0.04px;}
          #t79_1{left:406px;bottom:270px;}
          #t7a_1{left:406px;bottom:272px;letter-spacing:-0.27px;word-spacing:0.38px;}
          #t7b_1{left:528px;bottom:272px;}
          #t7c_1{left:528px;bottom:270px;}
          #t7d_1{left:528px;bottom:272px;letter-spacing:-0.04px;}
          #t7e_1{left:601px;bottom:270px;}
          #t7f_1{left:601px;bottom:272px;letter-spacing:-0.04px;}
          #t7g_1{left:710px;bottom:272px;letter-spacing:-0.05px;}
          #t7h_1{left:727px;bottom:272px;letter-spacing:-0.04px;word-spacing:0.24px;}
          #t7i_1{left:781px;bottom:270px;}
          #t7j_1{left:781px;bottom:272px;letter-spacing:-0.04px;}
          #t7k_1{left:857px;bottom:272px;letter-spacing:-0.02px;}
          #t7l_1{left:24px;bottom:253px;letter-spacing:-0.04px;}
          #t7m_1{left:64px;bottom:250px;}
          #t7n_1{left:65px;bottom:253px;letter-spacing:-0.05px;}
          #t7o_1{left:91px;bottom:252px;}
          #t7p_1{left:91px;bottom:253px;letter-spacing:-0.03px;}
          #t7q_1{left:129px;bottom:253px;letter-spacing:-0.04px;}
          #t7r_1{left:149px;bottom:253px;letter-spacing:-0.04px;}
          #t7s_1{left:180px;bottom:253px;}
          #t7t_1{left:180px;bottom:252px;}
          #t7u_1{left:180px;bottom:253px;}
          #t7v_1{left:183px;bottom:253px;}
          #t7w_1{left:193px;bottom:252px;}
          #t7x_1{left:193px;bottom:253px;letter-spacing:-0.04px;}
          #t7y_1{left:327px;bottom:252px;}
          #t7z_1{left:327px;bottom:253px;letter-spacing:-0.04px;}
          #t80_1{left:385px;bottom:253px;}
          #t81_1{left:384px;bottom:252px;}
          #t82_1{left:385px;bottom:253px;letter-spacing:-0.03px;word-spacing:-0.01px;}
          #t83_1{left:524px;bottom:253px;letter-spacing:-0.04px;}
          #t84_1{left:541px;bottom:253px;}
          #t85_1{left:546px;bottom:253px;}
          #t86_1{left:553px;bottom:253px;letter-spacing:-0.01px;word-spacing:-0.02px;}
          #t87_1{left:625px;bottom:253px;letter-spacing:-0.04px;}
          #t88_1{left:642px;bottom:253px;}
          #t89_1{left:647px;bottom:253px;}
          #t8a_1{left:654px;bottom:253px;letter-spacing:-0.03px;}
          #t8b_1{left:668px;bottom:252px;}
          #t8c_1{left:668px;bottom:253px;letter-spacing:-0.04px;}
          #t8d_1{left:793px;bottom:253px;letter-spacing:-0.04px;word-spacing:0.48px;}
          #t8e_1{left:851px;bottom:253px;letter-spacing:-0.02px;}
          #t8f_1{left:36px;bottom:959px;letter-spacing:0.15px;}
          #t8g_1{left:36px;bottom:783px;letter-spacing:0.16px;}
          #t8h_1{left:36px;bottom:542px;letter-spacing:0.13px;}
          #t8i_1{left:39px;bottom:395px;letter-spacing:0.24px;}
          #t8j_1{left:65px;bottom:392px;}
          #t8k_1{left:65px;bottom:395px;letter-spacing:0.17px;}
          #t8l_1{left:102px;bottom:392px;}
          #t8m_1{left:102px;bottom:395px;letter-spacing:0.17px;}
          #t8n_1{left:201px;bottom:395px;letter-spacing:0.15px;word-spacing:0.75px;}
          #t8o_1{left:30px;bottom:1150px;letter-spacing:0.13px;}
          #t8p_1{left:59px;bottom:1150px;}
          #t8q_1{left:70px;bottom:1150px;letter-spacing:0.14px;word-spacing:2.39px;}
          #t8r_1{left:113px;bottom:1150px;letter-spacing:0.09px;word-spacing:0.6px;}
          #t8s_1{left:360px;bottom:1150px;}
          #t8t_1{left:450px;bottom:1150px;letter-spacing:0.15px;}
          #t8u_1{left:30px;bottom:1128px;}
          #t8v_1{left:34px;bottom:1128px;letter-spacing:0.09px;}
          #t8w_1{left:415px;bottom:1128px;}
          #t8x_1{left:419px;bottom:1128px;letter-spacing:0.1px;}
          #t8y_1{left:464px;bottom:1128px;letter-spacing:0.15px;}
          #t8z_1{left:480px;bottom:1126px;}
          #t90_1{left:510px;bottom:1128px;letter-spacing:0.11px;}
          #t91_1{left:30px;bottom:1107px;}
          #t92_1{left:34px;bottom:1107px;letter-spacing:0.12px;}
          #t93_1{left:93px;bottom:1107px;letter-spacing:0.11px;}
          #t94_1{left:30px;bottom:1085px;letter-spacing:0.27px;}
          #t95_1{left:53px;bottom:1085px;letter-spacing:6.1px;}
          #t96_1{left:67px;bottom:1083px;}
          #t97_1{left:92px;bottom:1085px;}
          #t98_1{left:96px;bottom:1085px;letter-spacing:0.06px;}
          #t99_1{left:130px;bottom:1085px;}
          #t9a_1{left:134px;bottom:1085px;letter-spacing:0.1px;}
          #t9b_1{left:162px;bottom:1085px;}
          #t9c_1{left:167px;bottom:1085px;letter-spacing:0.11px;}
          #t9d_1{left:212px;bottom:1083px;}
          #t9e_1{left:217px;bottom:1085px;}
          #t9f_1{left:360px;bottom:1085px;letter-spacing:0.15px;}
          #t9g_1{left:410px;bottom:1085px;letter-spacing:0.09px;}
          #t9h_1{left:456px;bottom:1085px;}
          #t9i_1{left:460px;bottom:1085px;letter-spacing:0.23px;}
          #t9j_1{left:484px;bottom:1083px;}
          #t9k_1{left:485px;bottom:1085px;}
          #t9l_1{left:521px;bottom:1085px;}
          #t9m_1{left:526px;bottom:1085px;letter-spacing:0.1px;}
          #t9n_1{left:30px;bottom:1064px;letter-spacing:0.15px;}
          #t9o_1{left:96px;bottom:1064px;letter-spacing:0.12px;}
          #t9p_1{left:203px;bottom:1064px;}
          #t9q_1{left:202px;bottom:1060px;}
          #t9r_1{left:203px;bottom:1064px;letter-spacing:0.12px;}
          #t9s_1{left:336px;bottom:1062px;}
          #t9t_1{left:336px;bottom:1064px;letter-spacing:0.12px;}
          #t9u_1{left:469px;bottom:1062px;}
          #t9v_1{left:30px;bottom:1043px;letter-spacing:-0.05px;word-spacing:0.92px;}
          #t9w_1{left:211px;bottom:1043px;letter-spacing:0.13px;}
          #t9x_1{left:244px;bottom:1043px;letter-spacing:0.07px;word-spacing:0.6px;}
          #t9y_1{left:264px;bottom:1043px;letter-spacing:0.12px;}
          #t9z_1{left:443px;bottom:1043px;letter-spacing:0.12px;}
          #ta0_1{left:484px;bottom:1041px;}
          #ta1_1{left:30px;bottom:1021px;letter-spacing:0.13px;}
          #ta2_1{left:58px;bottom:1019px;}
          #ta3_1{left:59px;bottom:1021px;letter-spacing:0.08px;}
          #ta4_1{left:67px;bottom:1019px;}
          #ta5_1{left:67px;bottom:1021px;letter-spacing:0.11px;}
          #ta6_1{left:140px;bottom:1021px;letter-spacing:0.13px;}
          #ta7_1{left:169px;bottom:1019px;}
          #ta8_1{left:170px;bottom:1021px;letter-spacing:0.08px;}
          #ta9_1{left:178px;bottom:1019px;}
          #taa_1{left:178px;bottom:1021px;letter-spacing:-1.29px;word-spacing:3.37px;}
          #tab_1{left:211px;bottom:1021px;}
          #tac_1{left:211px;bottom:1017px;}
          #tad_1{left:211px;bottom:1021px;}
          #tae_1{left:241px;bottom:1021px;letter-spacing:0.11px;}
          #taf_1{left:289px;bottom:1021px;letter-spacing:4.28px;}
          #tag_1{left:327px;bottom:1021px;letter-spacing:0.12px;}
          #tah_1{left:366px;bottom:1021px;}
          #tai_1{left:365px;bottom:1017px;}
          #taj_1{left:366px;bottom:1021px;}
          #tak_1{left:396px;bottom:1021px;letter-spacing:0.09px;}
          #tal_1{left:452px;bottom:1021px;}
          #tam_1{left:456px;bottom:1021px;letter-spacing:0.11px;}
          #tan_1{left:30px;bottom:1000px;letter-spacing:0.1px;}
          #tao_1{left:410px;bottom:1000px;letter-spacing:0.2px;}
          #tap_1{left:443px;bottom:998px;}
          #taq_1{left:443px;bottom:1000px;letter-spacing:0.09px;}
          #tar_1{left:284px;bottom:1213px;letter-spacing:-0.02px;}
          #tas_1{left:750px;bottom:1181px;letter-spacing:0.33px;}
          #tat_1{left:36px;bottom:1181px;letter-spacing:0.14px;}
          #tau_1{left:114px;bottom:1181px;}
          #tav_1{left:114px;bottom:1178px;}
          #taw_1{left:278px;bottom:1000px;}
          #tax_1{left:148px;bottom:1000px;}
          #tay_1{left:30px;bottom:748px;letter-spacing:0.13px;}
          #taz_1{left:59px;bottom:748px;}
          #tb0_1{left:70px;bottom:748px;letter-spacing:0.14px;word-spacing:2.39px;}
          #tb1_1{left:113px;bottom:748px;letter-spacing:0.09px;word-spacing:0.6px;}
          #tb2_1{left:450px;bottom:748px;}
          #tb3_1{left:364px;bottom:748px;letter-spacing:0.15px;}
          #tb4_1{left:30px;bottom:726px;}
          #tb5_1{left:34px;bottom:726px;letter-spacing:0.09px;}
          #tb6_1{left:422px;bottom:726px;}
          #tb7_1{left:426px;bottom:726px;letter-spacing:0.1px;}
          #tb8_1{left:471px;bottom:726px;letter-spacing:0.15px;}
          #tb9_1{left:487px;bottom:724px;}
          #tba_1{left:517px;bottom:726px;letter-spacing:0.11px;}
          #tbb_1{left:30px;bottom:705px;}
          #tbc_1{left:34px;bottom:705px;letter-spacing:0.12px;}
          #tbd_1{left:93px;bottom:705px;letter-spacing:0.11px;}
          #tbe_1{left:30px;bottom:683px;letter-spacing:0.12px;}
          #tbf_1{left:142px;bottom:683px;}
          #tbg_1{left:142px;bottom:681px;}
          #tbh_1{left:168px;bottom:683px;letter-spacing:0.08px;}
          #tbi_1{left:176px;bottom:681px;}
          #tbj_1{left:176px;bottom:683px;letter-spacing:0.09px;}
          #tbk_1{left:227px;bottom:683px;letter-spacing:0.11px;}
          #tbl_1{left:298px;bottom:683px;letter-spacing:0.11px;}
          #tbm_1{left:323px;bottom:679px;}
          #tbn_1{left:323px;bottom:683px;}
          #tbo_1{left:353px;bottom:683px;}
          #tbp_1{left:362px;bottom:681px;}
          #tbq_1{left:361px;bottom:683px;letter-spacing:0.09px;}
          #tbr_1{left:387px;bottom:681px;}
          #tbs_1{left:30px;bottom:662px;letter-spacing:0.27px;}
          #tbt_1{left:53px;bottom:662px;letter-spacing:6.1px;}
          #tbu_1{left:67px;bottom:660px;}
          #tbv_1{left:92px;bottom:662px;}
          #tbw_1{left:96px;bottom:662px;letter-spacing:0.06px;}
          #tbx_1{left:130px;bottom:662px;}
          #tby_1{left:134px;bottom:662px;letter-spacing:0.1px;}
          #tbz_1{left:200px;bottom:662px;}
          #tc0_1{left:167px;bottom:662px;letter-spacing:0.11px;}
          #tc1_1{left:212px;bottom:660px;}
          #tc2_1{left:217px;bottom:662px;}
          #tc3_1{left:370px;bottom:662px;letter-spacing:0.15px;}
          #tc4_1{left:410px;bottom:662px;letter-spacing:0.09px;}
          #tc5_1{left:456px;bottom:662px;}
          #tc6_1{left:460px;bottom:662px;letter-spacing:0.23px;}
          #tc7_1{left:484px;bottom:660px;}
          #tc8_1{left:485px;bottom:662px;}
          #tc9_1{left:521px;bottom:662px;}
          #tca_1{left:526px;bottom:662px;letter-spacing:0.1px;}
          #tcb_1{left:30px;bottom:641px;letter-spacing:0.15px;}
          #tcc_1{left:96px;bottom:641px;letter-spacing:0.12px;}
          #tcd_1{left:203px;bottom:641px;}
          #tce_1{left:202px;bottom:637px;}
          #tcf_1{left:203px;bottom:641px;letter-spacing:0.12px;}
          #tcg_1{left:336px;bottom:638px;}
          #tch_1{left:336px;bottom:641px;letter-spacing:0.12px;}
          #tci_1{left:469px;bottom:638px;}
          #tcj_1{left:30px;bottom:619px;letter-spacing:-0.05px;word-spacing:0.92px;}
          #tck_1{left:211px;bottom:619px;letter-spacing:0.13px;}
          #tcl_1{left:244px;bottom:619px;letter-spacing:0.07px;word-spacing:0.6px;}
          #tcm_1{left:264px;bottom:619px;letter-spacing:0.12px;}
          #tcn_1{left:443px;bottom:619px;letter-spacing:0.12px;}
          #tco_1{left:484px;bottom:617px;}
          #tcp_1{left:30px;bottom:598px;letter-spacing:0.13px;}
          #tcq_1{left:58px;bottom:596px;}
          #tcr_1{left:59px;bottom:598px;letter-spacing:0.08px;}
          #tcs_1{left:67px;bottom:596px;}
          #tct_1{left:67px;bottom:598px;letter-spacing:0.11px;}
          #tcu_1{left:140px;bottom:598px;letter-spacing:0.13px;}
          #tcv_1{left:169px;bottom:596px;}
          #tcw_1{left:170px;bottom:598px;letter-spacing:0.08px;}
          #tcx_1{left:178px;bottom:596px;}
          #tcy_1{left:178px;bottom:598px;letter-spacing:-1.29px;word-spacing:3.37px;}
          #tcz_1{left:211px;bottom:598px;}
          #td0_1{left:211px;bottom:594px;}
          #td1_1{left:211px;bottom:598px;}
          #td2_1{left:241px;bottom:598px;letter-spacing:0.11px;}
          #td3_1{left:289px;bottom:598px;letter-spacing:4.28px;}
          #td4_1{left:327px;bottom:598px;letter-spacing:0.12px;}
          #td5_1{left:366px;bottom:598px;}
          #td6_1{left:365px;bottom:594px;}
          #td7_1{left:366px;bottom:598px;}
          #td8_1{left:396px;bottom:598px;letter-spacing:0.09px;}
          #td9_1{left:452px;bottom:598px;}
          #tda_1{left:456px;bottom:598px;letter-spacing:0.11px;}
          #tdb_1{left:30px;bottom:576px;letter-spacing:0.1px;}
          #tdc_1{left:410px;bottom:576px;letter-spacing:0.2px;}
          #tdd_1{left:443px;bottom:574px;}
          #tde_1{left:443px;bottom:576px;letter-spacing:0.14px;}
          #tdf_1{left:37px;bottom:496px;}
          #tdg_1{left:37px;bottom:475px;}
          #tdh_1{left:37px;bottom:454px;}
          #tdi_1{left:37px;bottom:432px;}
          #tdj_1{left:358px;bottom:496px;}
          #tdk_1{left:358px;bottom:475px;}
          #tdl_1{left:358px;bottom:454px;}
          #tdm_1{left:358px;bottom:432px;}
          #tdn_1{left:491px;bottom:517px;letter-spacing:0.15px;}
          #tdo_1{left:373px;bottom:495px;letter-spacing:0.13px;}
          #tdp_1{left:402px;bottom:495px;}
          #tdq_1{left:413px;bottom:495px;letter-spacing:0.14px;word-spacing:2.39px;}
          #tdr_1{left:457px;bottom:495px;}
          #tds_1{left:494px;bottom:495px;letter-spacing:0.09px;}
          #tdt_1{left:565px;bottom:495px;letter-spacing:0.11px;}
          #tdu_1{left:373px;bottom:474px;letter-spacing:0.11px;}
          #tdv_1{left:432px;bottom:472px;}
          #tdw_1{left:436px;bottom:474px;}
          #tdx_1{left:494px;bottom:474px;letter-spacing:0.09px;}
          #tdy_1{left:565px;bottom:474px;letter-spacing:0.11px;}
          #tdz_1{left:373px;bottom:452px;letter-spacing:0.11px;}
          #te0_1{left:432px;bottom:450px;}
          #te1_1{left:436px;bottom:452px;}
          #te2_1{left:494px;bottom:452px;letter-spacing:0.09px;}
          #te3_1{left:565px;bottom:452px;letter-spacing:0.13px;}
          #te4_1{left:373px;bottom:431px;}
          #te5_1{left:377px;bottom:431px;letter-spacing:0.17px;}
          #te6_1{left:278px;bottom:576px;}
          #te7_1{left:148px;bottom:576px;}
          #te8_1{left:349px;bottom:66px;}
          #te9_1{left:353px;bottom:66px;letter-spacing:0.16px;}
          #tea_1{left:388px;bottom:66px;letter-spacing:0.13px;}
          #teb_1{left:349px;bottom:43px;}
          #tec_1{left:353px;bottom:43px;letter-spacing:0.1px;}
          #ted_1{left:369px;bottom:41px;}
          #tee_1{left:369px;bottom:43px;letter-spacing:0.12px;}
          #tef_1{left:642px;bottom:66px;}
          #teg_1{left:646px;bottom:66px;letter-spacing:0.16px;}
          #teh_1{left:681px;bottom:66px;letter-spacing:0.14px;}
          #tei_1{left:727px;bottom:66px;}
          #tej_1{left:727px;bottom:64px;}
          #tek_1{left:727px;bottom:66px;letter-spacing:0.12px;}
          #tel_1{left:642px;bottom:43px;}
          #tem_1{left:646px;bottom:43px;letter-spacing:0.1px;}
          #ten_1{left:663px;bottom:41px;}
          #teo_1{left:663px;bottom:43px;letter-spacing:0.12px;}
          #tep_1{left:642px;bottom:423px;}
          #teq_1{left:646px;bottom:423px;letter-spacing:0.16px;}
          #ter_1{left:681px;bottom:423px;letter-spacing:0.14px;}
          #tes_1{left:727px;bottom:423px;}
          #tet_1{left:727px;bottom:421px;}
          #teu_1{left:727px;bottom:423px;letter-spacing:0.12px;}
          #tev_1{left:642px;bottom:400px;}
          #tew_1{left:646px;bottom:400px;letter-spacing:0.1px;}
          #tex_1{left:663px;bottom:398px;}
          #tey_1{left:663px;bottom:400px;letter-spacing:0.12px;}
          #tez_1{left:714px;bottom:998px;letter-spacing:0.13px;}
          #tf0_1{left:735px;bottom:995px;}
          #tf1_1{left:735px;bottom:998px;letter-spacing:0.24px;}
          #tf2_1{left:760px;bottom:995px;}
          #tf3_1{left:761px;bottom:998px;letter-spacing:0.22px;}
          #tf4_1{left:641px;bottom:857px;letter-spacing:0.13px;}
          #tf5_1{left:682px;bottom:855px;}
          #tf6_1{left:682px;bottom:857px;letter-spacing:0.15px;}
          #tf7_1{left:641px;bottom:837px;letter-spacing:0.1px;}
          #tf8_1{left:641px;bottom:817px;letter-spacing:0.1px;}
          #tf9_1{left:674px;bottom:815px;}
          #tfa_1{left:674px;bottom:817px;letter-spacing:0.11px;}
          #tfb_1{left:724px;bottom:815px;}
          #tfc_1{left:724px;bottom:817px;}
          #tfd_1{left:641px;bottom:797px;letter-spacing:0.11px;}
          #tfe_1{left:641px;bottom:777px;}
          #tff_1{left:649px;bottom:775px;}
          #tfg_1{left:649px;bottom:777px;letter-spacing:0.12px;}
          #tfh_1{left:715px;bottom:775px;}
          #tfi_1{left:716px;bottom:777px;letter-spacing:0.15px;}
          #tfj_1{left:733px;bottom:775px;}
          #tfk_1{left:733px;bottom:777px;letter-spacing:0.11px;}
          #tfl_1{left:641px;bottom:758px;}
          #tfm_1{left:649px;bottom:756px;}
          #tfn_1{left:649px;bottom:758px;letter-spacing:0.11px;}
          #tfo_1{left:714px;bottom:887px;letter-spacing:0.25px;}
          #tfp_1{left:641px;bottom:690px;letter-spacing:0.08px;}
          #tfq_1{left:648px;bottom:687px;}
          #tfr_1{left:649px;bottom:690px;}
          #tfs_1{left:649px;bottom:690px;letter-spacing:0.17px;}
          #tft_1{left:689px;bottom:690px;}
          #tfu_1{left:695px;bottom:690px;letter-spacing:0.1px;}
          #tfv_1{left:727px;bottom:687px;}
          #tfw_1{left:728px;bottom:690px;}
          #tfx_1{left:728px;bottom:690px;}
          #tfy_1{left:736px;bottom:688px;}
          #tfz_1{left:736px;bottom:690px;letter-spacing:0.15px;}
          #tg0_1{left:824px;bottom:688px;}
          #tg1_1{left:824px;bottom:690px;letter-spacing:0.13px;}
          #tg2_1{left:641px;bottom:671px;letter-spacing:0.13px;}
          #tg3_1{left:817px;bottom:671px;}
          #tg4_1{left:827px;bottom:671px;letter-spacing:0.11px;word-spacing:2.39px;}
          #tg5_1{left:641px;bottom:651px;}
          #tg6_1{left:645px;bottom:651px;}
          #tg7_1{left:657px;bottom:649px;}
          #tg8_1{left:661px;bottom:651px;letter-spacing:0.11px;}
          #tg9_1{left:711px;bottom:649px;}
          #tga_1{left:711px;bottom:651px;letter-spacing:0.15px;}
          #tgb_1{left:736px;bottom:649px;}
          #tgc_1{left:736px;bottom:651px;letter-spacing:0.13px;}
          #tgd_1{left:812px;bottom:649px;}
          #tge_1{left:812px;bottom:651px;letter-spacing:0.1px;}
          #tgf_1{left:858px;bottom:651px;letter-spacing:0.11px;}
          #tgg_1{left:641px;bottom:631px;}
          #tgh_1{left:645px;bottom:631px;}
          #tgi_1{left:657px;bottom:629px;}
          #tgj_1{left:657px;bottom:631px;}
          #tgk_1{left:661px;bottom:631px;letter-spacing:0.14px;}
          #tgl_1{left:843px;bottom:629px;}
          #tgm_1{left:843px;bottom:631px;letter-spacing:0.21px;}
          #tgn_1{left:641px;bottom:611px;letter-spacing:-0.01px;word-spacing:0.87px;}
          #tgo_1{left:641px;bottom:591px;letter-spacing:0.15px;}
          #tgp_1{left:748px;bottom:589px;}
          #tgq_1{left:748px;bottom:591px;letter-spacing:0.14px;}
          #tgr_1{left:802px;bottom:591px;}
          #tgs_1{left:802px;bottom:589px;}
          #tgt_1{left:806px;bottom:591px;}
          #tgu_1{left:810px;bottom:591px;letter-spacing:0.21px;}
          #tgv_1{left:641px;bottom:571px;letter-spacing:0.11px;}
          #tgw_1{left:655px;bottom:569px;}
          #tgx_1{left:653px;bottom:571px;}
          #tgy_1{left:657px;bottom:571px;letter-spacing:0.11px;}
          #tgz_1{left:682px;bottom:571px;}
          #th0_1{left:682px;bottom:567px;}
          #th1_1{left:682px;bottom:571px;letter-spacing:0.16px;}
          #th2_1{left:753px;bottom:569px;}
          #th3_1{left:753px;bottom:571px;letter-spacing:0.11px;}
          #th4_1{left:679px;bottom:720px;}
          #th5_1{left:684px;bottom:720px;letter-spacing:0.17px;}
          #th6_1{left:720px;bottom:718px;}
          #th7_1{left:720px;bottom:720px;letter-spacing:0.28px;}
          #th8_1{left:744px;bottom:720px;letter-spacing:0.13px;word-spacing:2.99px;}
          #th9_1{left:682px;bottom:546px;letter-spacing:0.13px;}
          #tha_1{left:744px;bottom:544px;}
          #thb_1{left:744px;bottom:546px;letter-spacing:0.15px;}
          #thc_1{left:811px;bottom:546px;letter-spacing:0.1px;}
          #thd_1{left:827px;bottom:546px;}
          #the_1{left:827px;bottom:544px;}

          .s0{font-size:12px;color:#231F20;}
          .s1{font-size:12px;color:#231F20;}
          .s2{font-size:12px;color:#231F20;}
          .s3{font-size:12px;color:#231F20;}
          .s4{font-size:12px;color:#231F20;}
          .s5{font-size:12px;color:#231F20;}
          .s6{font-size:12px;color:#231F20;}
          .s7{font-size:12px;color:#231F20;}
          .s8{font-size:12px;color:#231F20;}
          .s9{font-size:12px;color:#231F20;}
          .sa{font-size:12px;color:#231F20;}
          .sb{font-size:12px;color:#231F20;}
          .sc{font-size:12px;color:#231F20;}
          .sd{font-size:12px;color:#231F20;}
          .se{font-size:10px;color:#231F20;}
          .sf{font-size:10px;color:#231F20;}
          .sg{font-size:10px;color:#231F20;}
          .sh{font-size:10px;color:#231F20;}
          .si{font-size:10px;color:#231F20;}
          .sj{font-size:10px;color:#231F20;}
          .sk{font-size:10px;color:#231F20;}
          .sl{font-size:10px;color:#231F20;}
          .sm{font-size:10px;color:#231F20;}
          .sn{font-size:10px;color:#231F20;}
          .so{font-size:10px;color:#231F20;}
          .sp{font-size:10px;color:#231F20;}
          .sq{font-size:10px;color:#231F20;}
          .sr{font-size:10px;color:#231F20;}
          .ss{font-size:10px;color:#231F20;}
          .st{font-size:10px;color:#231F20;}
          .su{font-size:10px;color:#231F20;}
          .sv{font-size:10px;color:#231F20;}
          .sw{font-size:10px;color:#231F20;}
          .sx{font-size:10px;color:#231F20;}
          .sy{font-size:10px;color:#231F20;}
          .sz{font-size:10px;color:#231F20;}
          .s10{font-size:10px;color:#231F20;}
          .s11{font-size:15px;color:#FFF;}
          .s12{font-size:15px;color:#FFF;}
          .s13{font-size:15px;color:#FFF;}
          .s14{font-size:15px;color:#FFF;}
          .s15{font-size:12px;color:#231F20;}
          .s16{font-size:12px;color:#231F20;}
          .s17{font-size:12px;color:#231F20;}
          .s18{font-size:12px;color:#231F20;}
          .s19{font-size:12px;color:#231F20;}
          .s1a{font-size:29px;color:#231F20;}
          .s1b{font-size:24px;color:#231F20;}
          .s1c{font-size:15px;color:#FFF;}
          .s1d{font-size:12px;color:#231F20;}
          .s1e{font-size:11px;color:#231F20;}
          .s1f{font-size:12px;color:#231F20;}
          .s1g{font-size:12px;color:#231F20;}
          .s1h{font-size:12px;color:#231F20;}
          .s1i{font-size:15px;color:#FFF;}
          .s1j{font-size:15px;color:#FFF;}
          .s1k{font-size:15px;color:#FFF;}
          .s1l{font-size:15px;color:#FFF;}
          .s1m{font-size:15px;color:#FFF;}
        </style>
        <!-- End inline CSS -->
  </head>
  <body style="margin: 0;">
    <div id="content-to-pdf" class="invoice-print p-5">
        <!-- Begin page background -->
        <div id="pg1Overlay"></div>
        <div id="pg1" style="-webkit-user-select: none;">
            <object width="909" height="1286" data="{{ asset('assets/agreement/bg.svg') }}" type="image/svg+xml" id="pdf1" style="width:909px; height:1286px; -moz-transform:scale(1); z-index: 0;"></object>
        </div>
        <!-- End page background -->

        <!-- Begin text definitions (Positioned/styled in CSS) -->
        <div class="text-container">
            <span id="t1_1" class="t s0">ឈ្មោះក្រុមហ៊ុន (ខ្មែរ) <strong><i>{{ $loan->customer->job->name ?? ''}}</i></strong></span>
            <span id="t5_1" class="t s0">ឈ្មោះក្រុមហ៊ុន ( អង់គ្លេល) <strong><i>{{ $loan->customer->job->latin_name ?? ''}}</i></strong></span>
            <span id="t9_1" class="t s3">អាសយដ្ឋាន: ផ្ទះលេខ <strong><i>{{ $loan->customer->job->house_number ?? ''}}</i></strong>   ផ្លូវលេខ <strong><i>{{ $loan->customer->job->street_number ?? ''}}</i></strong>    ក្រុមទី <strong><i>{{ $loan->customer->job->group_number ?? ''}}</i></strong>  ភូមិ <strong><i>{{ $loan->customer->job->village ?? ''}}</i></strong></span>
            <span id="th_1" class="t s5">ឃុំ/សង្កាត់ <strong><i>{{ $loan->customer->job->commune ?? ''}}</i></strong></span>
            <span id="tk_1" class="t s1">ស្រុក/ខណ្ឌ/ក្រុង <strong><i>{{ $loan->customer->job->district ?? ''}}</i></strong></span>
            <span id="tm_1" class="t s0">ខេត្ត/រាជធានី <strong><i>{{ $loan->customer->job->province ?? ''}}</i></strong> </span>
            <span id="tn_1" class="t s4">ទូស័ព្ទទំនាក់ទំនង <strong><i>{{ $loan->customer->job->phone ?? ''}}</i></strong></span>
            <span id="tr_1" class="t s0">អ៊ីមែល <strong><i>{{ $loan->customer->job->email ?? ''}}</i></strong></span>
            <span id="ts_1" class="t s0">ប្រាក់បៀវត្ស/ ចំណូលប្រចាំខែ <strong class="py-10"><i>{{ setToStringDolla($loan->customer->job->salary ?? 0)}}</i></strong></span>
            <span id="tu_1" class="t s8">ចំណូលផ្សេងៗ <strong class="py-10"><i>{{ setToStringDolla($loan->customer->job->other_income ?? 0)}}</i></strong> ថ្ងៃបើកប្រាក់បៀវត្ស ថ្ងៃទី  <strong class="py-10"><i>{{ $loan->customer->job->salary_date ?? ''}}</i></strong> រាល់ខែ</span>
            <span id="tz_1" class="t s0">ប្រភេទផលិតផល: <strong><i>{{ $loan->product->brand->name}}</i></strong></span>
            <span id="t12_1" class="t s0">ឈ្មោះផលិតផល: <strong class="py-10"><i>{{ $loan->product->product_name}}</i></strong></span>
            <span id="t16_1" class="t s0">ម៉ូដែល: <strong><i>{{ $loan->product->series_name}}</i></strong></span>
            <span id="t16_2" class="t s0">IMEI: <strong><i>{{ $loan->product->product_imei}}</i></strong></span>
            <span id="t16_3" class="t s0">ទំហំផ្ទុក: <strong><i>{{ $loan->product->storage->name}}</i></strong></span>
            <span id="t1i_1" class="t s9">អ្នកខ្ចី </span>
            <span id="t1l_1" class="t s7">អត្តសញ្ញាណប័ណ្ណ </span>
            <span id="t1p_1" class="t s0">@if($loan->document && $loan->document->customer_id_card == 1) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ច្បាប់ដើម </span>
            <span id="t1q_1" class="t s0">@if($loan->document && $loan->document->customer_id_card == 2) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ចំលង </span>
            <span id="t1r_1" class="t s0">សំបុត្រកំណើត </span>
            <span id="t1u_1" class="t s0">@if($loan->document && $loan->document->customer_birth_certificate == 1) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ច្បាប់ដើម </span>
            <span id="t1v_1" class="t s0">@if($loan->document && $loan->document->customer_birth_certificate == 2) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ចំលង </span>
            <span id="t1w_1" class="t s0">សៀវភៅគ្រួរសារ</span>
            <span id="t1z_1" class="t s0">@if($loan->document && $loan->document->customer_family_book == 1) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ច្បាប់ដើម </span>
            <span id="t20_1" class="t s0">@if($loan->document && $loan->document->customer_family_book == 2) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ចំលង </span>
            <span id="t21_1" class="t s0">ផ្សេង ៗ {{ $loan->document->customer_other ?? ''}} </span>
            <span id="t8f_1" class="t s11">ព័ត៌មានការងារ/អាជីវកម្ម </span>
            <span id="t8g_1" class="t s12">ព័ត៌មានអ្នកធានា </span>
            <span id="t8h_1" class="t s13">ឯកសារយល់ព្រមតម្កល់ </span>
            <span id="t8i_1" class="t s11">ភាគីទាំងពីបានព្រមព្រៀងគ្នាតាមប្រការដូចខាងក្រោម </span>
            <span id="t8o_1" class="t s7">អត្តសញ្ញាណប័ណ្ណលេខ <strong><i>{{ $loan->customer->id_card_number }}</i></strong></span>
            <span id="t8t_1" class="t s0">ចេញដោយ <strong><i>{{ auth()->user()->employee->name }}</i></strong></span>
            <span id="t8u_1" class="t s0">ឈ្មោះ(ខ្មែរ) <strong><i>{{ $loan->customer->name }}</i></strong></span>
            <span id="t8w_1" class="t s0">ភេទ</span>
            <span id="t8y_1" class="t s0">@if($loan->customer->gender == 2) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ស្រី </span>
            <span id="t90_1" class="t s1">@if($loan->customer->gender == 1) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ប្រុស </span>
            <span id="t91_1" class="t s0">ឈ្មោះ អង់គ្លេស <strong><i>{{ $loan->customer->latin_name }}</i></strong></span>
            <span id="t94_1" class="t sb">សញ្ញាតិ </span>
            <span id="t97_1" class="t s0">@if($loan->customer->nationality == 1) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ខ្មែរ</span><span id="t9a_1" class="t s0">@if($loan->customer->nationality == 2) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ផ្សេង </span><span id="t9b_1" class="t s0">        ថ្ងៃខែកំណើត <strong><i>{{ $loan->customer->dob }} </i></strong></span>
            <span id="t9f_1" class="t s16">ស្ថានភាពគ្រួសារ</span>
            <span id="t9h_1" class="t s0">@if($loan->customer->family_status == 1) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif នៅលីវ</span>
            <span id="t9l_1" class="t s0">@if($loan->customer->family_status == 2) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif រៀបការ</span>
            <span id="t9n_1" class="t s3">អស័យដ្ឋាន: ផ្ទះលេខ <strong><i>{{ $loan->customer->house_number }}</i></strong></span>
            <span id="t9r_1" class="t s1">ផ្លូវលេខ <strong><i>{{ $loan->customer->street_number }}</i></strong></span>
            <span id="t9s_1" class="t s0">ក្រុមទី <strong><i>{{ $loan->customer->group_number }}</i></strong></span>
            <span id="t9u_1" class="t s0">ភូមិ <strong><i>{{ $loan->customer->village }}</i></strong></span>
            <span id="t9v_1" class="t s5">ឃុំ/សង្កាត់ <strong><i>{{ $loan->customer->commune }}</i></strong></span>
            <span id="t9y_1" class="t s1">ស្រុក/ខណ្ឌ/ក្រុង <strong><i>{{ $loan->customer->district }} </i></strong></span>
            <span id="t9z_1" class="t s7">ខេត្ត /រាជធានី <strong><i>{{ $loan->customer->province }}</i></strong></span>
            <span id="ta0_1" class="t s0"></span>
            <span id="ta1_1" class="t s0">កម្មសិទ្ធិលំនៅដ្ឋានៈ </span>
            <span id="ta6_1" class="t s0">@if($loan->customer->housing_ownership_type == 1) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif កម្មសិទ្ធិផ្ទាល់ខ្លួន</span>
            <span id="tae_1" class="t s4">@if($loan->customer->housing_ownership_type == 2) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ផ្ទះឪពុកម្ដាយ </span>
            <span id="tag_1" class="t s4">@if($loan->customer->housing_ownership_type == 3) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ផ្ទះបងប្អូន</span>
            <span id="tak_1" class="t s4">@if($loan->customer->housing_ownership_type == 4) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ផ្ទះជួល </span>
            <span id="tal_1" class="t s0">@if($loan->customer->housing_ownership_type == 5) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ផ្សេងៗ</span>
            <span id="tan_1" class="t s4">ទូរស័ព្ទលេខទំនាក់ទំនង </span>
            <span id="tao_1" class="t s0">គណនីFB <strong><i>{{ $loan->customer->facebook }}</i></strong></span>
            <span id="tar_1" class="t s1a font-w-700">កិច្ចព្រមព្រៀងសេវាបង់រំលស់ </span>
            <span id="tas_1" class="t s1b">No <strong><i>#{{ $loan->number }}</i></strong></span>
            <span id="tat_1" class="t s12">ព័ត៌មានអ្នកខ្ចី</span>
            <span id="tax_1" class="t s1d">1 <strong><i>{{ $loan->customer->phone }}</i></strong></span>
            <span id="taw_1" class="t s1d">2 <strong><i>{{ $loan->customer->mobile }}</i></strong></span>
            <span id="tay_1" class="t s7">អត្តសញ្ញាណប័ណ្ណលេខ <strong><i>{{ $loan->customer->guarantor->id_card_number ?? ''}}</i></strong></span>
            <span id="tb2_1" class="t s0">ចេញដោយ <strong><i>{{ auth()->user()->employee->name }}</i></strong></span>
            <span id="tb4_1" class="t s0">ឈ្មោះ(ខ្មែរ) <strong><i>{{ $loan->customer->guarantor->name ?? ''}}</i></strong></span>
            <span id="tbb_1" class="t s0">ឈ្មោះ អង់គ្លេស <strong><i>{{ $loan->customer->guarantor->latin_name ?? ''}}</i></strong></span>
            <span id="tb6_1" class="t s0">ភេទ </span>
            <span id="tb8_1" class="t s0">@if($loan->customer->guarantor && $loan->customer->guarantor->gender == 2) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ស្រី </span>
            <span id="tba_1" class="t s1">@if($loan->customer->guarantor && $loan->customer->guarantor->gender == 1) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ប្រុស </span>
            <span id="tbe_1" class="t s9">ទំនាក់ទំនងជាមួយអ្នកខ្ចី </span>
            <span id="tbh_1" class="t s7">@if($loan->customer->guarantor && $loan->customer->guarantor->customer_relation_type == 1) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ប្តីប្រពន្ធ </span>
            <span id="tbk_1" class="t s7">@if($loan->customer->guarantor && $loan->customer->guarantor->customer_relation_type == 2) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ឪពុកម្តាយ </span>
            <span id="tbl_1" class="t s19">@if($loan->customer->guarantor && $loan->customer->guarantor->customer_relation_type == 3) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif បងប្អូន </span>
            <span id="tbo_1" class="t s0">@if($loan->customer->guarantor && $loan->customer->guarantor->customer_relation_type == 4) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif មិត្តភក្តិ </span>
            <span id="tbs_1" class="t sb">សញ្ញាតិ </span>
            <span id="tbv_1" class="t s0">@if($loan->customer->guarantor && $loan->customer->guarantor->nationality == 1) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ខ្មែរ </span>
            <span id="tbx_1" class="t s0">@if($loan->customer->guarantor && $loan->customer->guarantor->nationality == 2) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ផ្សេងៗ</span>
            <span id="tbz_1" class="t s0">ថ្ងៃខែកំណើត <strong><i>{{ $loan->customer->guarantor->dob ?? ''}}</i></strong></span>
            <span id="tc3_1" class="t s16">សា្ថភាពគ្រួសារ </span>
            <span id="tc5_1" class="t s0">@if($loan->customer->guarantor && $loan->customer->guarantor->family_status == 1) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif នៅលីវ</span>
            <span id="tc9_1" class="t s0">@if($loan->customer->guarantor && $loan->customer->guarantor->family_status == 2) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif រៀបការ</span>
            <span id="tcb_1" class="t s3">អាសយដ្ឋាន: ផ្ទះលេខ <strong><i>{{ $loan->customer->guarantor->house_number ?? ''}}</i></strong> ផ្លូវលេខ <strong><i>{{ $loan->customer->guarantor->street_number ?? ''}}</i></strong> ក្រុមទី <strong><i>{{ $loan->customer->guarantor->group_number ?? ''}}</i></strong> ភូមិ <strong><i>{{ $loan->customer->guarantor->village ?? ''}}</i></strong></span>
            <span id="tcj_1" class="t s5">ឃុំ/សង្កាត់ <strong><i>{{ $loan->customer->guarantor->commune ?? ''}}</i></strong></span>
            <span id="tcl_1" class="t s6">ស្រុក/ខណ្ឌ/ក្រុង <strong><i>{{ $loan->customer->guarantor->district ?? ''}}</i></strong></span>
            <span id="tcn_1" class="t s7">ខេត្ត/រាជធានី <strong><i>{{ $loan->customer->guarantor->province ?? ''}}</i></strong></span>
            <span id="tcp_1" class="t s0">កម្មសិទ្ធិលំនៅដ្ឋានៈ </span>
            <span id="tcu_1" class="t s0">@if($loan->customer->guarantor && $loan->customer->guarantor->housing_ownership_type == 1) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif កម្មសិទ្ធិផ្ទាល់ខ្លួន </span>
            <span id="td2_1" class="t s4">@if($loan->customer->guarantor && $loan->customer->guarantor->housing_ownership_type == 2) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ផ្ទះឪពុកម្តាយ </span>
            <span id="td4_1" class="t s4">@if($loan->customer->guarantor && $loan->customer->guarantor->housing_ownership_type == 3) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ផ្ទះបងប្អូន </span>
            <span id="td8_1" class="t s4">@if($loan->customer->guarantor && $loan->customer->guarantor->housing_ownership_type == 4) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ផ្ទះជួល </span>
            <span id="td9_1" class="t s0">@if($loan->customer->guarantor && $loan->customer->guarantor->housing_ownership_type == 5) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ផ្សេងៗ </span>
            <span id="tdb_1" class="t s4">ទូរស័ព្ទលេខទំនាក់ទំនង </span>
            <span id="te6_1" class="t s1d">2 <strong><i>{{ $loan->customer->guarantor->phone ?? ''}}</i></strong></span>
            <span id="te7_1" class="t s1d">1 <strong><i>{{ $loan->customer->guarantor->mobile ?? ''}}</i></strong></span>
            <span id="tdc_1" class="t s0">គណនីFB <strong><i>{{ $loan->customer->guarantor->facebook ?? ''}}</i></strong></span>
            <span id="tdf_1" class="t s1e">1 </span>
            <span id="tdg_1" class="t s1e">2 </span>
            <span id="tdh_1" class="t s1e">3 </span>
            <span id="tdi_1" class="t s1e">4 </span>
            <span id="tdj_1" class="t s1e">1 </span>
            <span id="tdk_1" class="t s1e">2 </span>
            <span id="tdl_1" class="t s1e">3 </span>
            <span id="tdm_1" class="t s1e">4 </span>
            <span id="tdn_1" class="t s9">អ្នកធានា </span>
            <span id="tdo_1" class="t s7">អត្តសញ្ញាណប័ណ្ណ </span>
            <span id="tds_1" class="t s0">@if($loan->document && $loan->document->guarantor_id_card == 1) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ច្បាប់ដើម </span>
            <span id="tdt_1" class="t s0">@if($loan->document && $loan->document->guarantor_id_card == 2) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ចំលង </span>
            <span id="tdu_1" class="t s0">សំបុត្រកំណើត </span>
            <span id="tdx_1" class="t s0">@if($loan->document && $loan->document->guarantor_birth_certificate == 1) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ច្បាប់ដើម </span>
            <span id="tdy_1" class="t s0">@if($loan->document && $loan->document->guarantor_birth_certificate == 2) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ចំលង </span>
            <span id="tdz_1" class="t s0">សៀវភៅគ្រួរសារ </span>
            <span id="te2_1" class="t s0">@if($loan->document && $loan->document->guarantor_family_book == 1) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ច្បាប់ដើម </span>
            <span id="te3_1" class="t s0">@if($loan->document && $loan->document->guarantor_family_book == 2) <i class="fa-regular fa-square-check"></i> @else <i class="fa-regular fa-square"></i> @endif ចំលង </span>
            <span id="te4_1" class="t s0">ផ្សេង ៗ {{ $loan->document->guarantor_other ?? ''}} </span>
            <span id="t24_1" class="t sf"><b>ប្រការ១៖</b>ភាគីខ មានកាព្វកិច្ចបង់ប្រាក់អោយបានទៀងទាត់តាមកាលវិភាគសងប្រាក់ដែលបានកំណត់។ ក្នុងករណី <b>ភាគី «ខ»</b> សងប្រាក់យឺត យ៉ាវមិនទាន់ពេលវេលាភាគីខ សុខចិត្តបង់ប្រាក់ពិន័យមួយថ្ងៃ១ដុល្លារអោយ <b>ភាគី «ក»</b>  </span>
            <span id="t2x_1" class="t sj">ក្នុងករណី <b>ភាគី «ខ»</b> សងប្រាក់យឺតយ៉ាវមិនទាន់វេលាលើសពី១០ថ្ងៃ <b>ភាគី«ក»</b> មានសិទ្ធឈូសលុប ដោយប្រព័ន្ធស្វ័យប្រវិត្តហើយឯកសារដែលបាត់បង់នៅក្នុងទូសព្ទនោះ<b>ភាគី«ក»</b> មិនទទួលខុសត្រូវឡើយហើយ<b>ភាគី«ក»</b>មានសិទ្ធ </span>
            <span id="t45_1" class="t sq">ដកហូតយកទូស័ព្ទ មកវិញ ដើម្បីលក់ឡៃឡុងសំរាប់ទូទាត់បំណុលដែលនៅខ្វះ ។ ប្រសិនបើតម្លៃទូស័ព្ទមិនអាចទូទាត់បំណុលគ្រប់ចំនួននោះទេ <b>ភាគី«ខ»</b> នៅតែជាប់កាព្វកិច្ចសងប្រាក់ បង្គ្រប់តាមកិច្ចព្រមព្រៀងនេះ ។ </span>
            <span id="t4u_1" class="t se"><b>ប្រការ២៖</b> <b>ភាគី«ខ»</b> គ្មានលក់ដូរ បញ្ចាំ ឬធ្វើអំណោយទៅជនដទៃផ្សេងទៀតឡើយ ប្រសិនបើមិនបានបំពេញកាព្វកិច្ចបង់ប្រាក់ បង្គ្រប់តាមកិច្ចព្រមព្រៀងនេះ ។</span>
            <span id="t5k_1" class="t se"><b>ប្រការ៣៖</b> ភាគីអ្នកធានាបានអះអាងទទួលខុសត្រូវលើបន្ទកបំណុលរបស់<b>ភាគី«ខ»</b> ទាំងស្រុងក្នុងករណីដែលភាគី«ខ» មិនបានអនុវត្តកាព្វកិច្ចព្រមព្រៀងដោយពុំមានលទ្ធភាពសងឬគេចវេសពីកាព្វកិច្ចរបស់ខ្លូន ។ </span>
            <span id="t6l_1" class="t se"><b>ប្រការ៤៖</b> កិច្ចព្រមព្រៀងនេះធ្វើឡើងដោយពុំមានការបង្ខិតបង្ខំពីភាគីណាមួយឡើយ ហើយភាគីទាំងពីបានអាន បានស្តាប់ បានយល់ខ្លឹមសារ ទាំងស្រុង និងព្រមព្រៀងជាមួយគ្រប់លក្ខខណ្ឌនៃសន្យា ហើយចុះហត្ថលេខាឬផ្តិតមេៃដ </span>
            <span id="t7l_1" class="t sm">ទុកជាភស្តុតាង កិច្ចព្រមព្រៀងត្រូវបានធ្វើឡើងចំនួន០៣ ច្បាប់ ជាភាសាខ្មែរ ហើយមានតម្លៃស្មើគ្នា ចំពោះមុខច្បាប់ ០១ ច្បាប់ សំរាប់<b>ភាគី«ក»</b> ០១ ច្បាប់ សំរាប់<b>ភាគី«ខ»</b> និងមួយច្បាប់ទៀត ទុកតំម្កល់នៅម្ចាស់ហាងទូស័ព្ទ។ </span>
            <span id="t18_1" class="t s0">ឈ្មោះអ្នកខ្ចី <strong><i> {{ $loan->customer->name ?? '' }} </i></strong></span>
            <span id="t1e_1" class="t s0">ថ្ងៃទី <strong><i> {{ setToStringDateFormat($loan->date, 'd') }} </i></strong>ខែ <strong><i>{{ setToStringDateFormat($loan->date, 'm') }} </i></strong> ឆ្នាំ <strong class="py-10"><i>{{ setToStringDateFormat($loan->date, 'Y') }} </i></strong></span>
            <span id="te8_1" class="t s0">ឈ្មោះអ្នកធានា <strong><i> {{ $loan->customer->guarantor->name ?? '' }} </i></strong></span>
            <span id="teb_1" class="t s0">ថ្ងៃទី <strong><i> {{ setToStringDateFormat($loan->date, 'd') }} </i></strong>ខែ <strong><i>{{ setToStringDateFormat($loan->date, 'm') }} </i></strong> ឆ្នាំ <strong class="py-10"><i>{{ setToStringDateFormat($loan->date, 'Y') }} </i></strong></span>
            <span id="tef_1" class="t s0">ឈ្មោះអ្នកអោយខ្ចី <strong><i> {{ $loan->employee->name }} </i></strong></span>
            <span id="tel_1" class="t s0">ថ្ងៃទី <strong><i> {{ setToStringDateFormat($loan->date, 'd') }} </i></strong>ខែ <strong><i>{{ setToStringDateFormat($loan->date, 'm') }} </i></strong> ឆ្នាំ <strong class="py-10"><i>{{ setToStringDateFormat($loan->date, 'Y') }} </i></strong></span>
            <span id="tep_1" class="t s0">ឈ្មោះអ្នកខ្ចី <strong><i> {{ $loan->employee->name }} </i></strong></span>
            <span id="tev_1" class="t s0">ថ្ងៃទី <strong><i> {{ setToStringDateFormat($loan->date, 'd') }} </i></strong>ខែ <strong><i>{{ setToStringDateFormat($loan->date, 'm') }} </i></strong> ឆ្នាំ <strong class="py-10"><i>{{ setToStringDateFormat($loan->date, 'Y') }} </i></strong></span>
            <span id="tez_1" class="t s11">អំពីផលិតផល </span>
            <span id="tf4_1" class="t s2">តម្លៃផលិតផល: <strong><i>{{ setToStringDolla($loan->amount ?? 0) }}</i></strong></span>
            <span id="tf7_1" class="t s0">ប្រាក់កក់: <strong><i>{{ setToStringDolla(0) }}</i></strong></span>
            <span id="tf8_1" class="t s0">ចំនួនទឹកប្រាក់កំចី: <strong><i>{{ setToStringDolla($loan->total_balance ?? 0) }}</i></strong></span>
            <span id="tfd_1" class="t s0">រយះពេលបង់រំលស់: <strong><i>{{ $loan->duration }} ខែ</i></strong></span>
            <span id="tfe_1" class="t s0">ទឹកប្រាក់បង់លើកទី១: <strong><i>{{ setToStringDolla($loan->first_amount ?? 0) }}</i></strong></span>
            <span id="tfl_1" class="t s0">ទឹកប្រាក់បង់ប្រចាំខែ: <strong><i>{{ setToStringDolla($loan->monthly_payment ?? 0) }}</i></strong></span>
            <span id="tfo_1" class="t s11">ការគណនា </span>
            <span id="tfp_1" class="t s1f">ខ្ញុំសូមបញ្ជាក់ថា ខ្ញុំពិតជាបានទទួលទំនិញ ព្រម </span>
            <span id="tg2_1" class="t s2">ទាំងបានបង់ថ្លៃផ្សេងៗដូចដែលបានបញ្ជាក់ខាង </span>
            <span id="tg5_1" class="t s0">លើ រួចរាល់ហើយ និងយល់ព្រមចុះកិច្ចព្រមព្រៀង </span>
            <span id="tgg_1" class="t s0">លើសេវាកម្មបង់រំលស់នេះដោយសន្យាថានិងបង់ </span>
            <span id="tgn_1" class="t s15">ប្រាក់ប្រចាំខែទៅតាមតារាងបង់ប្រាក់ដែលភ្ជាប់មក </span>
            <span id="tgo_1" class="t s0">ជាមួយ ទៅអោយ ភាគីអ្នកអោយខ្ចី ទៅតាមកាល </span>
            <span id="tgv_1" class="t s0">បរិច្ឆេទក្នុងតារាងជាកំហិត។ </span>
            <span id="th4_1" class="t s11">សេចក្តីបញ្ជាក់ចុងក្រោយ </span>
            <span id="th9_1" class="t s9">ស្នាមមេដៃ និងហត្ថលេខាអ្នកខ្ចី </span></div>
            <!-- End text definitions -->
        </div>
        <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>
          window.addEventListener("load", window.print());
        </script>
    </body>
</html>
