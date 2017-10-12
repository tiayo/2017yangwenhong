$(document).ready(function(){
    // 回到顶部按钮
    $(window).scroll(function() {
        var scrollTop = $(window).scrollTop();
        if (scrollTop > 300) {
            $(".return-top").fadeIn();
        } else {
            $(".return-top").fadeOut();
        }
    });
    $(".return-top").click(function() {
        $("html,body").animate({ scrollTop : 0 }, 500);
        $(".classification-list .content").animate({ scrollTop : 0 }, 500);
    });

    // 快速导航
    $(".quick-nav").on("click", function() {
        if(this.bool == true || this.bool == undefined) {
            $(".quick-nav-mask").show();
            $(this).animate({"right" : 165}, 1000);
            $(".quick-nav-mask .quick-con").animate({"right" : 0}, 1000);
            $(this).css({
                "background" : "rgba(0, 0, 0, 0.7) url(../icon/more2.png) no-repeat 2px center",
                "background-size" : "15px"
            });
            $(".quick-nav em").html("收起");
            $(".quick-nav em").css({
                "line-height" : "37px"
            });
            $("quick-con").animate({"right" : 0}, 1000);
            this.bool = false;
        } else {
            $(this).animate({"right" : 0}, 1000);
            $(".quick-nav-mask .quick-con").animate({"right" : -165}, 1000);
            $(this).css({
                "background" : "rgba(0, 0, 0, 0.7) url(../icon/icon_arrow_left.png) no-repeat 4px center",
                "background-size" : "15px"
            });
            $(".quick-nav em").html("快速导航");
            $(".quick-nav em").css({
                "line-height" : "18px"
            });
            $(".quick-nav-mask").fadeOut(1000);
            this.bool = true;
        }
    });

    // 商品分类页面
    // tab切换
    $(".classification .tab li").click(function() {
        $(this).addClass('on').siblings().removeClass('on');
        $(".classification .tabcon li").hide().eq($(".classification .tab li").index(this)).show();
    });
    // 导航栏
    $(".classification .header span").click(function() {
        if(this.bool == undefined || this.bool ==true) {
            $(".classification-nav").show();
            $(".classification .tab").css({"top":"95px"});
            $(".classification .tabcon").css({"top":"95px"});
            this.bool = false;
        } else {
            $(".classification-nav").hide();
            $(".classification .tab").css({"top":"45px"});
            $(".classification .tabcon").css({"top":"45px"});
            this.bool = true;
        }
    });
    // 内容清浮动
    $(".classification .tabcon li").addClass('clearfix');
    $(".classification .tabcon li a").addClass('clearfix');


    // 购物车页面
    var gwcSp = $(".shopping-cart .content .list").length;
    $(".shopping-cart .batch-delete span em").html(gwcSp);
    $(".shopping-cart .content .list .delete").click(function() {
        $(this).parent(".list").remove();
        var gwcSp = $(".shopping-cart .content .list").length;
        $(".shopping-cart .batch-delete span em").html(gwcSp);
    });
    $(".shopping-cart .batch-delete strong").on("click", function() {
        if($(".sel-red1").length > 0) {
            $(".shopping-cart .delete-mask").show();
            var len = $(".sel-red1").length;
            $(".shopping-cart .delete-mask em").html(len);
            $(".shopping-cart .delete-mask .confirm-delete").on("click", function() {
                $(".shopping-cart .content .sel-red1").parent().parent(".list").remove();
                if($(".shopping-cart .content .list").length == 0) {
                    $(".shopping-cart .none-mask").show();
                    $(".shopping-cart").css("padding", 0);
                } else {
                    $(".shopping-cart .none-mask").hide();
                }
                var gwcSp = $(".shopping-cart .content .list").length;
                $(".shopping-cart .batch-delete span em").html(gwcSp);
                $(".shopping-cart .settlement em").html(0);
                $(".all-choose em").removeClass('sel-red');
                var sum = 0;
                $(".total em").html(sum);
                $(".preferential span em").html(sum);
                $(".shopping-cart .delete-mask").hide();
            });
            $(".shopping-cart .delete-mask .cancel-delete").on("click", function() {
                $(".shopping-cart .delete-mask").hide();
            });
        } else {
            $(".shopping-cart .delete-prompt").show();
            var timer = setInterval(function() {
                clearInterval(timer);
                $(".shopping-cart .delete-prompt").fadeOut();
            }, 1000);
        }
    });
    $(".shopping-cart .settlement a").click(function() {
        var len = $(".shopping-cart .sel-red1").length;
        if(len > 0) {
            $("#car_post_form").submit();
        } else {
            $(".shopping-cart .delete-prompt").show();
            var timer = setInterval(function() {
                clearInterval(timer);
                $(".shopping-cart .delete-prompt").fadeOut();
            }, 1000);
        }
    });
    if($(".shopping-cart .content .list").length == 0) {
        $(".shopping-cart .none-mask").show();
    } else {
        $(".shopping-cart .none-mask").hide();
    }
    // jwy add-demo
    var shop = {
        init: function(){
            this.sel();
            this.add();
            this.del();
        },
        sel: function(){
            $(".choose em").on("click", function(){
                var _this = $(this);
                if(_this.hasClass('sel-red1')){
                    _this.removeClass('sel-red1');
                    $(".all-choose em").removeClass('sel-red');
                    var len1 = $(".sel-red1").length;
                    $(".shopping-cart .settlement em").html(len1);
                } else {
                    _this.addClass('sel-red1');
                    var len2 = $(".sel-red1").length;
                    $(".shopping-cart .settlement em").html(len2);
                };
                shop.show();
            });
            $(".all-choose em").on("click", function(){
                var _this = $(this);
                if(_this.hasClass('sel-red')){
                    _this.removeClass('sel-red'),
                        $(".choose em").removeClass('sel-red1');
                    $(".shopping-cart .settlement em").html(0);
                } else {
                    _this.addClass('sel-red'),
                        $(".choose em").addClass('sel-red1');
                    var len3 = $(".sel-red1").length;
                    $(".shopping-cart .settlement em").html(len3);
                };
                shop.show();
            });

            $(".shopping-cart .list .delete").on("click", function() {
                $(this).siblings('.choose').children().removeClass('sel-red');
                shop.show();
            });
        },
        show: function(){
            var length = $(".list").length;
            var sum = 0;
            var discount = $(".preferential strong").data("discount");
            var price = 0;
            var num = 0;
            for(var i = 0; i < length; i++){
                if($(".price").eq(i).parent("h4").siblings('.choose').children('em').hasClass('sel-red1')){
                    price = $(".price").eq(i).data("price");
                    num = $(".num").eq(i).val();
                    sum = (price * 100 * num + sum * 100)/100;
                }
            }
            if(sum <= 0){
                sum = "0.00";
            };
            $(".preferential span em").html(sum);
            sum = (parseInt(sum * 100 - discount * 100))/100;
            if(sum <= 0){
                sum = "0.00";
            };
            $(".total em").html(sum);
        },
        add: function(){
            $('.jia').on("click", function(){
                var _this = $(this);
                var num = _this.siblings('input').val();
                num = parseInt(num) + 1;
                _this.siblings('input').val(num);
                shop.show();
            });
        },
        del: function(){
            $('.jian').on("click", function(){
                var _this = $(this);
                var num = _this.siblings('input').val();
                num = parseInt(num) - 1;
                if(num == 0){
                    num = 1;
                };
                _this.siblings('input').val(num);
                shop.show();
            });
        }
    }
    shop.init();

    // 商品列表页面
    // 条件筛选
    // $(".classification-list .Comprehensive").click(function() {
    //     $(this).addClass('on').siblings().removeClass('on');
    //     $(".classification-list .screening-list li").toggle();
    //     $(".classification-list .Sales .T").css({"background-image":"url(../icon/caret-up1.png)"});
    //     $(".classification-list .Sales .B").css({"background-image":"url(../icon/caret-down1.png)"});
    //     $(".classification-list .Price .T").css({"background-image":"url(../icon/caret-up1.png)"});
    //     $(".classification-list .Price .B").css({"background-image":"url(../icon/caret-down1.png)"});
    // });
    // $(".classification-list .screening-list li span").click(function() {
    //     $(this).addClass('on').siblings().removeClass('on');
    // });
    // $(".classification-list .Sales").click(function() {
    //     $(this).addClass('on').siblings().removeClass('on');
    //     $(".classification-list .screening-list li").hide();
    //     if(this.bool == true || this.bool == undefined) {
    //         $(".classification-list .Sales .T").css({"background-image":"url(../icon/caret-up2.png)"});
    //         $(".classification-list .Sales .B").css({"background-image":"url(../icon/caret-down1.png)"});
    //         $(".classification-list .Price .T").css({"background-image":"url(../icon/caret-up1.png)"});
    //         $(".classification-list .Price .B").css({"background-image":"url(../icon/caret-down1.png)"});
    //         this.bool = false;
    //     } else {
    //         $(".classification-list .Sales .B").css({"background-image":"url(../icon/caret-down2.png)"});
    //         $(".classification-list .Sales .T").css({"background-image":"url(../icon/caret-up1.png)"});
    //         $(".classification-list .Price .T").css({"background-image":"url(../icon/caret-up1.png)"});
    //         $(".classification-list .Price .B").css({"background-image":"url(../icon/caret-down1.png)"});
    //         this.bool = true;
    //     }
    // });
    // $(".classification-list .Price").click(function() {
    //     $(this).addClass('on').siblings().removeClass('on');
    //     $(".classification-list .screening-list li").hide();
    //     if(this.bool == true || this.bool == undefined) {
    //         $(".classification-list .Price .T").css({"background-image":"url(../icon/caret-up2.png)"});
    //         $(".classification-list .Price .B").css({"background-image":"url(../icon/caret-down1.png)"});
    //         $(".classification-list .Sales .T").css({"background-image":"url(../icon/caret-up1.png)"});
    //         $(".classification-list .Sales .B").css({"background-image":"url(../icon/caret-down1.png)"});
    //         this.bool = false;
    //     } else {
    //         $(".classification-list .Price .T").css({"background-image":"url(../icon/caret-up1.png)"});
    //         $(".classification-list .Price .B").css({"background-image":"url(../icon/caret-down2.png)"});
    //         $(".classification-list .Sales .T").css({"background-image":"url(../icon/caret-up1.png)"});
    //         $(".classification-list .Sales .B").css({"background-image":"url(../icon/caret-down1.png)"});
    //         this.bool = true;
    //     }
    // });


    // 商品详情页tab切换
    // $(".goods-details .show-title li").click(function() {
    //     $(this).addClass('on').siblings().removeClass('on');
    //     $(".goods-details .show-details li").hide().eq($(".goods-details .show-title li").index(this)).show();
    // });
    // 商品详情页商品规格选择
    $(".goods-details .nav-bottom .join-cart").click(function() {
        $(".goods-details .mask").show();
        $("body,html").css({"position":"fixed","top":"0px","bottom":"0px"});
        $(".goods-details .mask .confirm").click(function() {
            var len1 = $(".goods-details .mask .mask-content li").length;
            var len2 = $(".goods-details .mask .mask-content li .on").length;
            if(len1 == len2) {
                $(".goods-details .mask").hide();
                $(".goods-details .join-successful").show();
                $("body,html").css({"position":"static","overflow":"scroll"});
                var timer1 = setInterval(function() {
                    $(".goods-details .join-successful").fadeOut();
                    clearInterval(timer1);
                }, 1000);
            } else {
                $(".goods-details .join-failure").show();
                var timer2 = setInterval(function() {
                    clearInterval(timer2);
                    $(".goods-details .join-failure").fadeOut();
                }, 1000);
            }
        });
    });
    $(".goods-details .nav-bottom .exchange-now").click(function() {
        $(".goods-details .mask").show();
        $("body,html").css({"position":"fixed","top":"0px","bottom":"0px"});
        $(".goods-details .mask .confirm").click(function() {
            var len1 = $(".goods-details .mask .mask-content li").length;
            var len2 = $(".goods-details .mask .mask-content li .on").length;
            if(len1 == len2) {
                $(".goods-details .mask .confirm").attr("href","goods-settlement.html");
            } else {
                $(".goods-details .join-failure").show();
                var timer2 = setInterval(function() {
                    clearInterval(timer2);
                    $(".goods-details .join-failure").fadeOut();
                }, 1000);
            }
        });
    });
    $(".goods-details .mask .mask-close").click(function() {
        $(".goods-details .mask").hide();
        $("body,html").css({"position":"static","overflow":"scroll"});
    });
    $(".goods-details .mask .mask-con .type-choose input").click(function() {
        $(this).addClass('on').siblings().removeClass('on');
    });
    $(".goods-details .nav-bottom .join-collection").click(function() {
        if(this.bool == true || this.bool == undefined) {
            $(this).addClass('join-collection2').removeClass('join-collection1');
            $(".goods-details .collection-successful").show();
            var timer1 = setInterval(function() {
                clearInterval(timer1);
                $(".goods-details .collection-successful").fadeOut();
            }, 1000);
            this.bool = false;
        } else {
            $(this).addClass('join-collection1').removeClass('join-collection2');
            $(".goods-details .collection-failure").show();
            var timer2 = setInterval(function() {
                clearInterval(timer2);
                $(".goods-details .collection-failure").fadeOut();
            }, 1000);
            this.bool = true;
        }
    });

    // 选择收货地址
    $(".address-choose .address-list li .info").addClass('clearfix');
    $(".address-choose .address-list li h3 b").click(function() {
        var _this = $(this);
        var id = _this.parents("li").data("id");
        $(".address-choose .delete-mask").show();
        $(".address-choose .delete-mask .confirm-delete").unbind('click');
        $(".address-choose .delete-mask .confirm-delete").click(function(){
            /*发送ajax请求*/
            $(".address-choose .delete-mask").hide();
            // 成功时调用
            $(".address-choose .address-list li").each(function(){
                var _this = $(this);
                if(_this.data("id") == id){
                    _this.remove();
                }
                if($(".address-choose .address-list li").length <= 3) {
                    $(".address-choose .address-list").css({"padding-bottom":"3px"});
                }
            });
        });
        $(".address-choose .delete-mask .cancel-delete").click(function() {
            $(".address-choose .delete-mask").hide();
        });
    });
    $(".address-choose .address-list li h3 span").on("click", function() {
        $(this).children('em').addClass('default').parent().parent().parent().siblings().children('h3').children('span').children('em').removeClass('default');
        $(this).children('em').addClass('default').parent().parent().parent().siblings().children('h3').children('span').children('strong').html("设为默认");
        $(this).children('strong').html("默认地址");
    });

    // 添加新地址
    $(".add-address .address-info li:nth-last-child(1) h1 span").on("click", function() {
        if(this.bool == true || this.bool == undefined) {
            $(".add-address .address-info li:nth-last-child(1) h1 span em").css({
                "float":"right",
                "background":"#fff"
            });
            $(".add-address .address-info li:nth-last-child(1) h1 span").css({
                "background":"#ffda44"
            });
            this.bool = false;
        } else {
            $(".add-address .address-info li:nth-last-child(1) h1 span em").css({
                "float":"left",
                "background":"#fff"
            });
            $(".add-address .address-info li:nth-last-child(1) h1 span").css({
                "background":"#fff"
            });
            this.bool = true;
        }
    });
    //手机号码正则
    $("#psCustomerTel").blur(function() {
        var regs = /^0?1[3|4|5|7|8|9][0-9]\d{8}$/;
        var val = $(this).val();
        if(!regs.test(val)) {
            $(this).val("");
            $(this).attr("placeholder","请输入正确的手机号码");
            $(this).addClass('showc');
        }
    });
    $(".save").click(function() {
        if($("#customerName").val() != "" && $("#psCustomerTel").val() != "" && $("#detailed-address").val() != "" ) {
           $('#address_form').submit();
        } else {
            $(".mask-false").fadeIn(1000, function() {
                $(".mask-false").fadeOut(1000);
            });
        }
    });

    // 立即提现
    $(".change-withdrawal h4 span").click(function() {
        var money = $(".change-withdrawal h4 em").text();
        $("#money").val(money);
    });
    $(".change-withdrawal h5").on("click", function() {
        var val = $("#money").val();
        var reg = /^\d+(?:\.\d{2})?$/;
        if(val == "" || !reg.test(val) || val == 0) {
            $(".change-withdrawal .mask1").fadeIn(1000, function() {
                $(".change-withdrawal .mask1").fadeOut(1000);
            });
        } else if(parseFloat(val) > parseFloat($(".change-withdrawal h4 em").text())) {
            $(".change-withdrawal .mask2").fadeIn(1000, function() {
                $(".change-withdrawal .mask2").fadeOut(1000);
            });
            console.log(parseFloat(val));
            console.log(parseFloat($(".change-withdrawal h4 em").text()));
        } else {
            $(".change-withdrawal .mask").show();
        }
    });

    // 商品结算界面
    $(".goods-settlement .nav-bottom em").on("click", function() {
        $(".goods-settlement .mask").show();
        $(".goods-settlement .mask .payment .payment-details em").on("click",function() {
            $(".goods-settlement .mask").hide();
        });
    });



    // if($(".content").length == 1) {
    //     var numOf = parseInt($(".goods-settlement .info .num-of span").text());
    //     $(".goods-settlement .goods-num .num").val(numOf);
    //     var totalAmount = parseInt($(".goods-settlement .info .num-of span").text())*parseInt($(".goods-settlement .info .pay-for").text());
    //     $(".goods-settlement .nav-bottom h1 span").html(totalAmount);
    //     $(".goods-settlement .mask .payment .payment-amount span").html(totalAmount);
    //     $(".goods-settlement .goods-num .jia").on("click", function() {
    //         numOf += 1;
    //         console.log($(".goods-settlement .goods-num .num").val());
    //         $(".goods-settlement .info .num-of span").html(numOf);
    //         $(".goods-settlement .goods-num .num").val(numOf);
    //         var totalAmount = parseInt($(".goods-settlement .info .num-of span").text())*parseInt($(".goods-settlement .info .pay-for").text());
    //         $(".goods-settlement .nav-bottom h1 span").html(totalAmount);
    //         $(".goods-settlement .mask .payment .payment-amount span").html(totalAmount);
    //     });
    //     $(".goods-settlement .goods-num .jian").on("click", function() {
    //         numOf -= 1;
    //         $(".goods-settlement .info .num-of span").html(numOf);
    //         $(".goods-settlement .goods-num .num").val(numOf);
    //         var totalAmount = parseInt($(".goods-settlement .info .num-of span").text())*parseInt($(".goods-settlement .info .pay-for").text());
    //         $(".goods-settlement .nav-bottom h1 span").html(totalAmount);
    //         $(".goods-settlement .mask .payment .payment-amount span").html(totalAmount);
    //         if(numOf <= 1) {
    //             numOf = 1;
    //             $(".goods-settlement .info .num-of span").html(numOf);
    //             $(".goods-settlement .goods-num .num").val(numOf);
    //             $(".goods-settlement .nav-bottom h1 span").html($(".goods-settlement .info .pay-for").text());
    //             $(".goods-settlement .mask .payment .payment-amount span").html($(".goods-settlement .info .pay-for").text());
    //         }
    //     });
    //     $(".goods-settlement").css({"padding-bottom" : 0});
    // } else {
    //     $(".goods-settlement .content .goods-num").remove();
    //     var len = $(".content").length;
    //     var sum = 0;
    //     var price = 0;
    //     var num = 0;
    //     var allsum = 0;
    //     for(var i = 0; i < len; i++) {
    //         var numOf = parseInt($(".goods-settlement .content .info .num-of span").eq(i).text());
    //         $(".goods-settlement .content .goods-num .num").eq(i).val(numOf);
    //         price = $(".pay-for").eq(i).text();
    //         num = $(".number").eq(i).text();
    //         sum = (price * num);
    //         allsum = allsum + sum;
    //         $(".goods-settlement .nav-bottom h1 span").html(allsum);
    //         $(".goods-settlement .mask .payment .payment-amount span").html(allsum);
    //     }
    // }

    // 我的收藏
    var sclSp = $(".my-collection .content .list").length;
    $(".my-collection .batch-delete span em").html(sclSp);
    $(".my-collection .content .list .delete").click(function() {
        $(this).parent(".list").remove();
        var sclSp = $(".my-collection .content .list").length;
        $(".my-collection .batch-delete span em").html(sclSp);
    });
    $(".my-collection .batch-delete strong").on("click", function() {
        if($(".sel-red1").length > 0) {
            $(".my-collection .delete-mask").show();
            var len = $(".sel-red1").length;
            $(".my-collection .delete-mask em").html(len);
            $(".my-collection .delete-mask .confirm-delete").on("click", function() {
                $(".my-collection .content .sel-red1").parent().parent(".list").remove();
                if($(".my-collection .content .list").length == 0) {
                    $(".my-collection .none-mask").show();
                    $(".my-collection .batch-delete").remove();
                    $(".my-collection .total-price").remove();
                    $(".my-collection").css({"padding" : 0});
                } else {
                    $(".my-collection .none-mask").hide();
                }
                var sclSp = $(".my-collection .content .list").length;
                $(".my-collection .batch-delete span em").html(sclSp);
                $(".all-choose em").removeClass('sel-red');
                $(".my-collection .delete-mask").hide();
            });
            $(".my-collection .delete-mask .cancel-delete").on("click", function() {
                $(".my-collection .delete-mask").hide();
            });
        } else {
            $(".my-collection .delete-prompt").show();
            var timer = setInterval(function() {
                clearInterval(timer);
                $(".my-collection .delete-prompt").fadeOut();
            }, 1000);
        }
    });

    // 我的奖品
    $(".my-prize .prize-title li").click(function() {
        $(this).addClass('on1').siblings().removeClass('on1');
        $(".my-prize .prize-details li").hide().eq($(".my-prize .prize-title li").index(this)).show();
    });
    $(".my-prize .prize-details li:nth-child(1) .prize-list .on2").on("click", function() {
        $(this).removeClass('on2');
        $(this).html("已领取");
        $(".my-prize .mask").show(function() {
            $(".my-prize .mask").fadeOut(2000);
        });
    });
    $(".my-prize .prize-details li:nth-child(2) .prize-list em").on("click", function() {
        $(this).parent(".prize-list").remove();
        $(".my-prize .mask").show(function() {
            $(".my-prize .mask").fadeOut(2000);
        });
    });
});