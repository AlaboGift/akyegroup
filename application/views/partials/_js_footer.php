<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
    var is_recaptcha_enabled = false;
    <?php if ($recaptcha_status == true): ?>
    is_recaptcha_enabled = true;
    <?php endif; ?>
    //update token
    $("form").submit(function () {
        $("input[name='" + csfr_token_name + "']").val($.cookie(csfr_cookie_name));
    });

    $(document).ready(function () {
        //main slider
        $("#main-slider").owlCarousel({
            autoplay: true,
            loop: $(".owl-carousel > .item").length <= 2 ? false : true,
            lazyLoad: true,
            slideSpeed: 3000,
            paginationSpeed: 1000,
            items: 1,
            dots: true,
            nav: true,
            navText: ["<i class='icon-arrow-slider-left random-arrow-prev' aria-hidden='true'></i>", "<i class='icon-arrow-slider-right random-arrow-next' aria-hidden='true'></i>"],
            itemsDesktop: false,
            itemsDesktopSmall: false,
            itemsTablet: false,
            itemsMobile: false,
        });

        $(document).ready(function () {
            $("#product-slider").owlCarousel({
                items: 1,
                autoplay: false,
                nav: true,
                loop: $(".owl-carousel > .item").length <= 2 ? false : true,
                navText: ["<i class='icon-arrow-slider-left random-arrow-prev' aria-hidden='true'></i>", "<i class='icon-arrow-slider-right random-arrow-next' aria-hidden='true'></i>"],
                dotsContainer: '.dots-container',
            });
        });


        //blog slider
        $("#blog-slider").owlCarousel({
            autoplay: true,
            loop: $(".owl-carousel > .item").length <= 2 ? false : true,
            margin: 20,
            nav: true,
            lazyLoad: true,
            navText: ["<i class='icon-arrow-slider-left random-arrow-prev' aria-hidden='true'></i>", "<i class='icon-arrow-slider-right random-arrow-next' aria-hidden='true'></i>"],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }
        });

        //custom scrollbar
        var custom_scrollbar = $('.custom-scrollbar');
        if (custom_scrollbar.length) {
            var ps = new PerfectScrollbar('.custom-scrollbar', {
                useBothWheelAxes: true
            });
        }

        //message custom scrollbar
        var message_custom_scrollbar = $('.message-custom-scrollbar');
        if (message_custom_scrollbar.length) {
            var ps = new PerfectScrollbar('.message-custom-scrollbar', {
                useBothWheelAxes: true
            });
            $('.messages-list').scrollTop($('.messages-list')[0].scrollHeight);
        }


        //rate product
        $(document).on('click', '.rating-stars .label-star', function () {
            $('#user_rating').val($(this).attr('data-star'));
        });


        //mobile memu
        $(document).on('click', '.btn-open-mobile-nav', function () {
            document.getElementById("navMobile").style.width = "100%";
        });
        $(document).on('click', '.btn-close-mobile-nav', function () {
            document.getElementById("navMobile").style.width = "0";
        });
        $(document).on('click', '.close-mobile-nav', function () {
            document.getElementById("navMobile").style.width = "0";
        });
        //mobile menu search
        $(document).on('click', '.search-icon', function () {
            if ($(".mobile-search-form").hasClass("open-search")) {
                $(".mobile-search-form").removeClass("open-search");
                $(".mobile-search-button i").removeClass("icon-times");
                $(".mobile-search-button i").addClass("icon-search")
            } else {
                $(".mobile-search-form").addClass("open-search");
                $(".mobile-search-button i").removeClass("icon-search");
                $(".mobile-search-button i").addClass("icon-times")
            }
        });

    });

    //magnific popup
    $(document).ready(function (b) {
        b(".image-popup").magnificPopup({
            type: "image", titleSrc: function (a) {
                return a.el.attr("title") + "<small></small>"
            }, image: {verticalFit: true,}, gallery: {enabled: true, navigateByImgClick: true, preload: [0, 1]}, removalDelay: 100, fixedContentPos: true,
        })
    });

    /*mega menu*/
    $(".mega-menu .nav-item").hover(function () {
        var menu_id = $(this).attr('data-category-id');
        $("#mega_menu_content_" + menu_id).show();
        //   $("#wrapper-overlay").addClass('wrapper-overlay');
    }, function () {
        var menu_id = $(this).attr('data-category-id');
        $("#mega_menu_content_" + menu_id).hide();
        // $("#wrapper-overlay").removeClass('wrapper-overlay');
    });

    $(".mega-menu .dropdown-menu").hover(function () {
        $(this).show();
    }, function () {
    });

    //scrollup
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $(".scrollup").fadeIn()
        } else {
            $(".scrollup").fadeOut()
        }
    });
    $(".scrollup").click(function () {
        $("html, body").animate({scrollTop: 0}, 700);
        return false
    });

    $(function () {
        $(".search-select a").click(function () {
            $(".search-select .btn").text($(this).text());
            $(".search-select .btn").val($(this).text());
            $(".search_type_input").val($(this).attr("data-value"));
        });
    });

    $(function () {
        $(".sort-select a").click(function () {
            $(".sort-select .btn").text($(this).text());
            $(".sort-select .btn").val($(this).text());
        });
    });

    //check all checkboxes
    $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
        if ($(".checkbox-table").is(':checked')) {
            $('.btn-delete-messages').show();
        } else {
            $('.btn-delete-messages').hide();
        }
    });
    //show hide delete button
    $('.checkbox-table').click(function () {
        if ($(".checkbox-table").is(':checked')) {
            $('.btn-delete-messages').show();
        } else {
            $('.btn-delete-messages').hide();
        }
    });

    //set default location
    function set_default_location(location_id) {
        var data = {
            location_id: location_id
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "home_controller/set_default_location",
            data: data,
            success: function (response) {
                location.reload();
            }
        });
    }


    /*
     *------------------------------------------------------------------------------------------
     * AUTH FUNCTIONS
     *------------------------------------------------------------------------------------------
     */

    //login
    $(document).ready(function () {
        $("#form_login").submit(function (event) {
            var form = $(this);
            if (form[0].checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            } else {
                event.preventDefault();
                var inputs = form.find("input, select, button, textarea");
                var serializedData = form.serializeArray();
                serializedData.push({name: csfr_token_name, value: $.cookie(csfr_cookie_name)});
                $.ajax({
                    url: base_url + "auth_controller/login_post",
                    type: "post",
                    data: serializedData,
                    success: function (response) {
                        if (response == 'success') {
                            location.reload();
                        } else {
                            document.getElementById("result-login").innerHTML = response;
                        }
                    }
                });
            }
            form[0].classList.add('was-validated');
        });
    });


    /*
     *------------------------------------------------------------------------------------------
     * REVIEW FUNCTIONS
     *------------------------------------------------------------------------------------------
     */

    //make review
    $(document).on('click', '#submit_review', function () {
        var user_rating = $.trim($('#user_rating').val());
        var user_review = $.trim($('#user_review').val());
        var product_id = $.trim($('#review_product_id').val());
        var limit = parseInt($("#product_review_limit").val());

        if (!user_rating) {
            $('.rating-stars').addClass('invalid-rating');
            return false;
        } else {
            $('.rating-stars').removeClass('invalid-rating');
        }

        var data = {
            "review": user_review,
            "rating": user_rating,
            "product_id": product_id,
            "limit": limit,
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $('#submit_review').prop("disabled", true);
        $.ajax({
            type: "POST",
            url: base_url + "product_controller/make_review",
            data: data,
            success: function (response) {
                $('#submit_review').prop("disabled", false);
                if (response == "voted_error") {
                    $('.error-reviewed').show();
                } else if (response == "error_own_product") {
                    $('.error-own-product').show();
                }
                else {
                    document.getElementById("review-result").innerHTML = response;
                }
            }
        });
    });

    //load more review
    function load_more_review(product_id) {
        var limit = parseInt($("#product_review_limit").val());
        var data = {
            product_id: product_id,
            limit: limit
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $("#load_review_spinner").show();
        $.ajax({
            method: "POST",
            url: base_url + "product_controller/load_more_review",
            data: data
        })
            .done(function (response) {
                setTimeout(function () {
                    $("#load_review_spinner").hide();
                    document.getElementById("review-result").innerHTML = response
                }, 1000);
            })
    }

    //delete review
    function delete_review(review_id, product_id, message) {
        swal({
            text: message,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then(function (willDelete) {
            if (willDelete) {
                var limit = parseInt($("#product_review_limit").val());
                var data = {
                    id: review_id,
                    product_id: product_id,
                    limit: limit
                };
                data[csfr_token_name] = $.cookie(csfr_cookie_name);

                $.ajax({
                    method: "POST",
                    url: base_url + "product_controller/delete_review",
                    data: data
                })
                    .done(function (response) {
                        document.getElementById("review-result").innerHTML = response;
                    })
            }
        });
    }


    /*
     *------------------------------------------------------------------------------------------
     * BLOG COMMENTS FUNCTIONS
     *------------------------------------------------------------------------------------------
     */

    //make blog comment
    $(document).ready(function () {
        var request;
        //make registered comment
        $("#make_blog_comment_registered").submit(function (event) {
            event.preventDefault();
            var comment_text = $.trim($('#comment_text').val());
            if (comment_text.length < 1) {
                $('#comment_text').addClass("is-invalid");
                return false;
            } else {
                $('#comment_text').removeClass("is-invalid");
            }
            if (request) {
                request.abort();
            }
            var $form = $(this);
            var $inputs = $form.find("input, select, button, textarea");
            var limit = parseInt($("#blog_comment_limit").val());

            var serializedData = $form.serializeArray();
            serializedData.push({name: csfr_token_name, value: $.cookie(csfr_cookie_name)});
            serializedData.push({name: "limit", value: limit});
            $inputs.prop("disabled", true);
            request = $.ajax({
                url: base_url + "home_controller/add_comment_post",
                type: "post",
                data: serializedData,
            });
            request.done(function (response) {
                $inputs.prop("disabled", false);
                document.getElementById("comment-result").innerHTML = response;
                $("#make_blog_comment_registered")[0].reset();
            });

        });

        //make comment
        $("#make_blog_comment").submit(function (event) {
            event.preventDefault();
            var comment_name = $.trim($('#comment_name').val());
            var comment_email = $.trim($('#comment_email').val());
            var comment_text = $.trim($('#comment_text').val());

            if (comment_name.length < 1) {
                $('#comment_name').addClass("is-invalid");
                return false;
            } else {
                $('#comment_name').removeClass("is-invalid");
            }
            if (comment_email.length < 1) {
                $('#comment_email').addClass("is-invalid");
                return false;
            } else {
                $('#comment_email').removeClass("is-invalid");
            }
            if (comment_text.length < 1) {
                $('#comment_text').addClass("is-invalid");
                return false;
            } else {
                $('#comment_text').removeClass("is-invalid");
            }

            if (request) {
                request.abort();
            }
            var $form = $(this);
            var $inputs = $form.find("input, select, button, textarea");
            var limit = parseInt($("#blog_comment_limit").val());
            var serializedData = $form.serializeArray();
            serializedData.push({name: csfr_token_name, value: $.cookie(csfr_cookie_name)});
            serializedData.push({name: "limit", value: limit});

            var recaptcha_status = true;
            if (is_recaptcha_enabled == true) {
                $(serializedData).each(function (i, field) {
                    if (field.name == "g-recaptcha-response") {
                        if (field.value == "") {
                            $('.g-recaptcha').addClass("is-recaptcha-invalid");
                            recaptcha_status = false;
                        }
                    }
                });
            }
            if (recaptcha_status == true) {
                $('.g-recaptcha').removeClass("is-recaptcha-invalid");
                $inputs.prop("disabled", true);
                request = $.ajax({
                    url: base_url + "home_controller/add_comment_post",
                    type: "post",
                    data: serializedData,
                });
                request.done(function (response) {
                    $inputs.prop("disabled", false);
                    if (is_recaptcha_enabled == true) {
                        grecaptcha.reset();
                    }
                    document.getElementById("comment-result").innerHTML = response;
                    $("#make_blog_comment")[0].reset();
                });
            }
        });
    });

    //load more blog comment
    function load_more_blog_comment(post_id) {
        var limit = parseInt($("#blog_comment_limit").val());
        var data = {
            post_id: post_id,
            limit: limit
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $("#load_comment_spinner").show();
        $.ajax({
            method: "POST",
            url: base_url + "home_controller/load_more_comment",
            data: data
        })
            .done(function (response) {
                setTimeout(function () {
                    $("#load_comment_spinner").hide();
                    document.getElementById("comment-result").innerHTML = response
                }, 1000)
            })
    }

    //delete blog comment
    function delete_blog_comment(comment_id, post_id, message) {
        swal({
            text: message,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then(function (willDelete) {
            if (willDelete) {
                var limit = parseInt($("#blog_comment_limit").val());
                var data = {
                    comment_id: comment_id,
                    post_id: post_id,
                    limit: limit
                };
                data[csfr_token_name] = $.cookie(csfr_cookie_name);

                $.ajax({
                    method: "POST",
                    url: base_url + "home_controller/delete_comment_post",
                    data: data
                })
                    .done(function (response) {
                        document.getElementById("comment-result").innerHTML = response

                    })
            }
        });
    }


    /*
     *------------------------------------------------------------------------------------------
     * PRODUCT COMMENT FUNCTIONS
     *------------------------------------------------------------------------------------------
     */

    $(document).ready(function () {
        var request;
        //make registered comment
        $("#make_comment_registered").submit(function (event) {
            event.preventDefault();
            var comment_text = $.trim($('#comment_text').val());
            if (comment_text.length < 1) {
                $('#comment_text').addClass("is-invalid");
                return false;
            } else {
                $('#comment_text').removeClass("is-invalid");
            }
            if (request) {
                request.abort();
            }
            var $form = $(this);
            var $inputs = $form.find("input, select, button, textarea");
            var limit = parseInt($("#product_comment_limit").val());

            var serializedData = $form.serializeArray();
            serializedData.push({name: csfr_token_name, value: $.cookie(csfr_cookie_name)});
            serializedData.push({name: "limit", value: limit});

            $inputs.prop("disabled", true);
            request = $.ajax({
                url: base_url + "product_controller/make_comment",
                type: "post",
                data: serializedData,
            });
            request.done(function (response) {
                $inputs.prop("disabled", false);
                document.getElementById("comment-result").innerHTML = response;
                $("#make_comment_registered")[0].reset();
            });

        });

        //make comment
        $("#make_comment").submit(function (event) {
            event.preventDefault();
            var comment_name = $.trim($('#comment_name').val());
            var comment_email = $.trim($('#comment_email').val());
            var comment_text = $.trim($('#comment_text').val());

            if (comment_name.length < 1) {
                $('#comment_name').addClass("is-invalid");
                return false;
            } else {
                $('#comment_name').removeClass("is-invalid");
            }
            if (comment_email.length < 1) {
                $('#comment_email').addClass("is-invalid");
                return false;
            } else {
                $('#comment_email').removeClass("is-invalid");
            }
            if (comment_text.length < 1) {
                $('#comment_text').addClass("is-invalid");
                return false;
            } else {
                $('#comment_text').removeClass("is-invalid");
            }

            if (request) {
                request.abort();
            }
            var $form = $(this);
            var $inputs = $form.find("input, select, button, textarea");
            var limit = parseInt($("#product_comment_limit").val());

            var serializedData = $form.serializeArray();
            serializedData.push({name: csfr_token_name, value: $.cookie(csfr_cookie_name)});
            serializedData.push({name: "limit", value: limit});

            var recaptcha_status = true;
            if (is_recaptcha_enabled == true) {
                $(serializedData).each(function (i, field) {
                    if (field.name == "g-recaptcha-response") {
                        if (field.value == "") {
                            $('.g-recaptcha').addClass("is-recaptcha-invalid");
                            recaptcha_status = false;
                        }
                    }
                });
            }
            if (recaptcha_status == true) {
                $('.g-recaptcha').removeClass("is-recaptcha-invalid");
                $inputs.prop("disabled", true);
                request = $.ajax({
                    url: base_url + "product_controller/make_comment",
                    type: "post",
                    data: serializedData,
                });
                request.done(function (response) {
                    $inputs.prop("disabled", false);
                    if (is_recaptcha_enabled == true) {
                        grecaptcha.reset();
                    }
                    document.getElementById("comment-result").innerHTML = response;
                    $("#make_comment")[0].reset();
                });
            }
        });

    });

    //make registered subcomment
    $(document).on('click', '.btn-subcomment-registered', function () {
        var comment_id = $(this).attr("data-comment-id");
        var data = {};
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $("#make_subcomment_registered_" + comment_id).ajaxSubmit({
            beforeSubmit: function () {
                var form = $("#make_subcomment_registered_" + comment_id).serializeArray();
                var comment = $.trim(form[0].value);
                if (comment.length < 1) {
                    $(".form-comment-text").addClass("is-invalid");
                    return false;
                } else {
                    $(".form-comment-text").removeClass("is-invalid");
                }
            },
            type: "POST",
            url: base_url + "product_controller/make_comment",
            data: data,
            success: function (response) {
                document.getElementById("comment-result").innerHTML = response;
            }
        })
    });

    //make subcomment
    $(document).on('click', '.btn-subcomment', function () {
        var comment_id = $(this).attr("data-comment-id");
        var data = {};
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $("#make_subcomment_" + comment_id).ajaxSubmit({
            beforeSubmit: function () {
                var form = $("#make_subcomment_" + comment_id).serializeArray();
                var name = $.trim(form[0].value);
                var email = $.trim(form[1].value);
                var comment = $.trim(form[2].value);
                if (is_recaptcha_enabled == true) {
                    var recaptcha = $.trim(form[3].value);
                }

                if (name.length < 1) {
                    $(".form-comment-name").addClass("is-invalid");
                    return false;
                } else {
                    $(".form-comment-name").removeClass("is-invalid");
                }
                if (email.length < 1) {
                    $(".form-comment-email").addClass("is-invalid");
                    return false;
                } else {
                    $(".form-comment-email").removeClass("is-invalid");
                }
                if (comment.length < 1) {
                    $(".form-comment-text").addClass("is-invalid");
                    return false;
                } else {
                    $(".form-comment-text").removeClass("is-invalid");
                }
                if (is_recaptcha_enabled == true) {
                    if (recaptcha == "") {
                        $("#make_subcomment_" + comment_id + ' .g-recaptcha').addClass("is-recaptcha-invalid");
                        return false;
                    } else {
                        $("#make_subcomment_" + comment_id + ' .g-recaptcha').removeClass("is-recaptcha-invalid");
                    }
                }
            },
            type: "POST",
            url: base_url + "product_controller/make_comment",
            data: data,
            success: function (response) {
                if (is_recaptcha_enabled == true) {
                    grecaptcha.reset();
                }
                document.getElementById("comment-result").innerHTML = response;
            }
        })
    });

    //load more comment
    function load_more_comment(product_id) {
        var limit = parseInt($("#product_comment_limit").val());
        var data = {
            product_id: product_id,
            limit: limit
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $("#load_comment_spinner").show();
        $.ajax({
            method: "POST",
            url: base_url + "product_controller/load_more_comment",
            data: data
        })
            .done(function (response) {
                setTimeout(function () {
                    $("#load_comment_spinner").hide();
                    document.getElementById("comment-result").innerHTML = response;
                }, 1000)
            })
    }

    //delete comment
    function delete_comment(comment_id, product_id, message) {
        swal({
            text: message,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then(function (willDelete) {
            if (willDelete) {
                var limit = parseInt($("#product_comment_limit").val());
                var data = {
                    id: comment_id,
                    product_id: product_id,
                    limit: limit
                };
                data[csfr_token_name] = $.cookie(csfr_cookie_name);

                $.ajax({
                    method: "POST",
                    url: base_url + "product_controller/delete_comment",
                    data: data
                })
                    .done(function (response) {
                        document.getElementById("comment-result").innerHTML = response;
                    })

            }
        });
    }

    //show comment box
    function show_comment_box(comment_id) {
        $('.visible-sub-comment').empty();
        var limit = parseInt($("#product_comment_limit").val());
        var data = {
            comment_id: comment_id,
            limit: limit
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "product_controller/load_subcomment_box",
            data: data,
            success: function (response) {
                $('#sub_comment_form_' + comment_id).append(response);
            }
        });
    }


    /*
     *------------------------------------------------------------------------------------------
     * MESSAGE FUNCTIONS
     *------------------------------------------------------------------------------------------
     */

    //delete conversation
    function delete_conversation(conversation_id, message) {
        swal({
            text: message,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then(function (willDelete) {
                if (willDelete) {

                    var data = {
                        conversation_id: conversation_id
                    };
                    data[csfr_token_name] = $.cookie(csfr_cookie_name);
                    $.ajax({
                        method: "POST",
                        url: base_url + "message_controller/delete_conversation",
                        data: data
                    })
                        .done(function (response) {
                            window.location.href = base_url + "messages";
                        })

                }
            });
    }

    //delete selected conversations
    function delete_selected_conversations(message) {
        swal({
            text: message,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then(function (willDelete) {
                if (willDelete) {
                    var conversation_ids = [];
                    $("input[name='checkbox-table']:checked").each(function () {
                        conversation_ids.push(this.value);
                    });
                    var data = {
                        'conversation_ids': conversation_ids
                    };
                    data[csfr_token_name] = $.cookie(csfr_cookie_name);
                    $.ajax({
                        type: "POST",
                        url: base_url + "message_controller/delete_selected_conversations",
                        data: data,
                        success: function (response) {
                            location.reload();
                        }
                    });

                }
            });
    };


    /*
     *------------------------------------------------------------------------------------------
     * OTHER FUNCTIONS
     *------------------------------------------------------------------------------------------
     */

    //set site language
    function set_site_language(lang_id) {
        var data = {
            lang_id: lang_id,
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            method: "POST",
            url: base_url + "home_controller/set_site_language",
            data: data
        })
            .done(function (response) {
                location.reload();
            })
    }


    $(document).on('click', '#btn_load_more_promoted', function () {
        $("#load_promoted_spinner").show();
        var limit = $("#input_promoted_products_limit").val();
        var per_page = $("#input_promoted_products_per_page").val();
        var promoted_products_count = $("#input_promoted_products_count").val();
        var new_limit = parseInt(limit) + parseInt(per_page);
        var data = {
            "limit": limit
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "home_controller/load_more_promoted_products",
            data: data,
            success: function (response) {
                $("#input_promoted_products_limit").val(new_limit);
                setTimeout(function () {
                    $("#load_promoted_spinner").hide();
                    $("#row_promoted_products").append(response);
                    if (new_limit >= promoted_products_count) {
                        $("#btn_load_more_promoted").hide();
                    }
                }, 700)
            }
        });

    });

    //delete product
    function delete_product(product_id, message) {
        swal({
            text: message,
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then(function (willDelete) {
                if (willDelete) {
                    var data = {
                        id: product_id,
                    };
                    data[csfr_token_name] = $.cookie(csfr_cookie_name);
                    $.ajax({
                        method: "POST",
                        url: base_url + "product_controller/delete_product",
                        data: data
                    })
                        .done(function (response) {
                            location.reload();
                        })

                }
            });
    }

    //send message
    $("#form_send_message").submit(function (event) {
        event.preventDefault();
        var message_subject = $('#message_subject').val();
        var message_text = $('#message_text').val();

        if (message_subject.length < 1) {
            $('#message_subject').addClass("is-invalid");
            return false;
        } else {
            $('#message_subject').removeClass("is-invalid");
        }
        if (message_text.length < 1) {
            $('#message_text').addClass("is-invalid");
            return false;
        } else {
            $('#message_text').removeClass("is-invalid");
        }
        var $form = $(this);
        var $inputs = $form.find("input, select, button, textarea");
        var serializedData = $form.serializeArray();
        serializedData.push({name: csfr_token_name, value: $.cookie(csfr_cookie_name)});
        $inputs.prop("disabled", true);
        $.ajax({
            url: base_url + "message_controller/add_conversation",
            type: "post",
            data: serializedData,
            success: function (response) {
                $inputs.prop("disabled", false);
                document.getElementById("send-message-result").innerHTML = response;
                $("#form_send_message")[0].reset();
            }
        });
    });

    function get_subcategories(val) {
        var data = {
            "parent_id": val
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);

        $.ajax({
            type: "POST",
            url: base_url + "home_controller/get_subcategories",
            data: data,
            success: function (response) {
                document.getElementById("subcategories_container").innerHTML = response;
            }
        });
    }


    function get_third_categories(val) {
        var data = {
            "parent_id": val
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);

        $.ajax({
            type: "POST",
            url: base_url + "home_controller/get_third_categories",
            data: data,
            success: function (response) {
                document.getElementById("third_categories_container").innerHTML = response;
            }
        });
    }

    function get_states(val) {
        var data = {
            "country_id": val
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "product_controller/get_states",
            data: data,
            success: function (response) {
                $('#states').children('option:not(:first)').remove();
                $("#states").append(response);
                update_product_map();
            }
        });
    }

    function get_cities(val) {
        var data = {
            "state_id": val
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "product_controller/get_cities",
            data: data,
            success: function (response) {
                $('#cities').children('option:not(:first)').remove();
                $("#cities").append(response);
                update_product_map();
            }
        });
    }


    function update_product_map() {
        var country_text = $("#countries").text();
        var country_val = $("#countries").val();
        var state_text = $("#states").find('option:selected').text();
        var state_val = $("#states").find('option:selected').val();
        var city_text = $("#cities").find('option:selected').text();
        var address = $("#address_input").val() + "," + city_text;
        var zip_code = $("#zip_code_input").val();
        var data = {
            "country_text": country_text,
            "country_val": country_val,
            "state_text": state_text,
            "state_val": state_val,
            "address": address,
            "zip_code": zip_code
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "product_controller/show_address_on_map",
            data: data,
            success: function (response) {
                document.getElementById("map-result").innerHTML = response;
            }
        });
    }

    $(document).on('change', '#address_input', function () {
        update_product_map();
    });
    $(document).on('change', '#zip_code_input', function () {
        update_product_map();
    });

    $(document).on('click', '.item-favorite-button', function () {
        var product_id = $(this).attr("data-product-id");
        if ($(this).hasClass("item-favorite-enable")) {
            if ($(this).hasClass('item-favorited')) {
                $(this).removeClass('item-favorited');
            } else {
                $(this).addClass('item-favorited');
            }

            var data = {
                "product_id": product_id
            };
            data[csfr_token_name] = $.cookie(csfr_cookie_name);
            $.ajax({
                type: "POST",
                url: base_url + "product_controller/add_remove_favorite_ajax",
                data: data,
                success: function (response) {
                }
            });
        }
    });
    var img_uplaod_max_file_size = '<?php echo $this->img_uplaod_max_file_size; ?>';
    //upload product image
    $(document).on('change', '.img-file-input-session', function () {
        var order = $(this).attr("data-image-order");
        if (this.files[0].size > img_uplaod_max_file_size) {
            $(".error-message-img-upload").show();
            return false;
        }
        $('#progress-div-' + order).show();
        $('.btn-delete-product-img-session').prop('disabled', true);
        $('.img-file-input-session').hide();
        $("#product_image_form_" + order).ajaxSubmit({
            target: '#targetLayer-' + order,
            beforeSubmit: function () {
                $("#progress-bar-" + order).width('0%');
            },
            uploadProgress: function (event, position, total, percentComplete) {
                $("#progress-bar-" + order).width(percentComplete + '%');
                $("#progress-bar-" + order).html('<div id="progress-status-' + order + '">' + percentComplete + ' %</div>')
            },
            complete: function () {
                var data = {};
                data[csfr_token_name] = $.cookie(csfr_cookie_name);
                $.ajax({
                    type: "POST",
                    url: base_url + "file_controller/load_image_section",
                    data: data,
                    success: function (response) {
                        document.getElementById("product_image_response").innerHTML = response;
                    }
                });
            },
            resetForm: true
        });
    });

    //upload product image update page
    $(document).on('change', '.img-file-input', function () {
        var order = $(this).attr("data-image-order");
        var product_id = $(this).attr("data-product-id");
        if (this.files[0].size > img_uplaod_max_file_size) {
            $(".error-message-img-upload").show();
            return false;
        }
        $('#progress-div-' + order).show();
        $('.btn-delete-product-img').prop('disabled', true);
        $('.img-file-input').hide();
        $("#product_image_form_" + order).ajaxSubmit({
            target: '#targetLayer-' + order,
            beforeSubmit: function () {
                $("#progress-bar-" + order).width('0%');
            },
            uploadProgress: function (event, position, total, percentComplete) {
                $("#progress-bar-" + order).width(percentComplete + '%');
                $("#progress-bar-" + order).html('<div id="progress-status-' + order + '"></div>')
            },
            complete: function () {
                var data = {
                    'product_id': product_id
                };
                data[csfr_token_name] = $.cookie(csfr_cookie_name);
                $.ajax({
                    type: "POST",
                    url: base_url + "file_controller/load_image_update_section",
                    data: data,
                    success: function (response) {
                        document.getElementById("product_image_response").innerHTML = response;
                    }
                });
            },
            resetForm: true
        });
    });

    //delete product image session
    $(document).on('click', '.btn-delete-product-img-session', function () {
        var image_order = $(this).attr('data-image-order');
        var data = {
            "image_order": image_order,
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "file_controller/delete_image_session",
            data: data,
            success: function (response) {
                document.getElementById("product_image_response").innerHTML = response;
            }
        });
    });

    //delete product image
    $(document).on('click', '.btn-delete-product-img', function () {
        var product_id = $(this).attr('data-product-id');
        var image_id = $(this).attr('data-image-id');
        var data = {
            "product_id": product_id,
            "image_id": image_id
        };
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "file_controller/delete_image",
            data: data,
            success: function (response) {
                document.getElementById("product_image_response").innerHTML = response;
            }
        });
    });

    //hide cookies warning
    function hide_cookies_warning() {
        $(".cookies-warning").hide();
        var data = {};
        data[csfr_token_name] = $.cookie(csfr_cookie_name);
        $.ajax({
            type: "POST",
            url: base_url + "home_controller/cookies_warning",
            data: data,
            success: function (response) {
            }
        });
    }

    $("#form_validate").validate();
    $("#form_validate_s").validate();
    $("#form_validate_ms").validate();

    $(document).ready(function (b) {
        b(".image-popup").magnificPopup({
            type: "image", titleSrc: function (a) {
                return a.el.attr("title") + "<small></small>"
            }, image: {verticalFit: true,}, gallery: {enabled: true, navigateByImgClick: true, preload: [0, 1]}, removalDelay: 100, fixedContentPos: true,
        })
    });
</script>

<?php if (!auth_check()): ?>
    <?php if (!empty($general_settings->facebook_app_id) && !empty($general_settings->facebook_app_secret)): ?>
        <script>
            //facebook login
            $(document).on('click', '.btn-login-facebook', function () {
                FB.login(function (response) {
                    if (response.status === 'connected') {
                        FB.api('/me?fields=email,first_name,last_name', function (response) {
                            var data = {
                                "id": response.id,
                                "email": response.email,
                                "first_name": response.first_name,
                                "last_name": response.last_name,
                            };
                            data[csfr_token_name] = $.cookie(csfr_cookie_name);
                            $.ajax({
                                type: "POST",
                                url: base_url + "auth_controller/login_with_facebook",
                                data: data,
                                success: function (res) {
                                    location.reload();
                                }
                            });
                        });
                    } else {
                        // The person is not logged into this app or we are unable to tell.
                    }
                }, {scope: 'email'});
            });
            window.fbAsyncInit = function () {
                FB.init({
                    appId: fb_app_id,
                    cookie: true,  // enable cookies to allow the server to access
                    xfbml: true,  // parse social plugins on this page
                    version: 'v2.8' // use graph api version 2.8
                });
            };
            // Load the SDK asynchronously
            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) return;
                js = d.createElement(s);
                js.id = id;
                js.src = "https://connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        </script>
    <?php endif; ?>
    <?php if (!empty($general_settings->google_client_id) && !empty($general_settings->google_client_secret)): ?>
        <script src="https://apis.google.com/js/platform.js?onload=onLoadGoogleCallback" async defer></script>
        <script>
            function onLoadGoogleCallback() {
                sign_in = document.getElementById("googleSignIn");
                sign_up = document.getElementById("googleSignUp");
                gapi.load("auth2", function () {
                    auth2 = gapi.auth2.init({client_id: $("meta[name=google-signin-client_id]").attr("content"), cookiepolicy: "single_host_origin", scope: "profile"});
                    auth2.attachClickHandler(sign_in, {}, function (b) {
                        var c = b.getBasicProfile();
                        var a = {id: c.getId(), email: c.getEmail(), name: c.getName(), avatar: c.getImageUrl(),};
                        a[csfr_token_name] = $.cookie(csfr_cookie_name);
                        $.ajax({
                            type: "POST", url: base_url + "auth_controller/login_with_google", data: a, success: function (d) {
                                location.reload()
                            }
                        })
                    }, function (a) {
                    });
                    auth2.attachClickHandler(sign_up, {}, function (b) {
                        var c = b.getBasicProfile();
                        var a = {id: c.getId(), email: c.getEmail(), name: c.getName(), avatar: c.getImageUrl(),};
                        a[csfr_token_name] = $.cookie(csfr_cookie_name);
                        $.ajax({
                            type: "POST", url: base_url + "auth_controller/login_with_google", data: a, success: function (d) {
                                location.reload()
                            }
                        })
                    }, function (a) {
                    })
                })
            }
        </script>
    <?php endif; ?>
<?php endif; ?>
