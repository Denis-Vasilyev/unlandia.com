// Слайдер баннеров
(function () {
    if ($('.SliderBanner').length > 0) {
        $(document).on('click', '.js-prev_slide_banner', function () {
            sliderNavNextItem(false);
        });
        $(document).on('click', '.js-next_slide_banner', function () {
            sliderNavNextItem(true);
        });
        $(document).on('click', '.SliderBannerNav__list .SliderBannerNav__item', function () {
            var nav_btn = $('.js-prev_slide_banner, .js-next_slide_banner, .SliderBannerNav__list .SliderBannerNav__item');
            nav_btn.css('pointer-events', 'none');

            $('.SliderBannerNav__list .SliderBannerNav__item--active').removeClass('SliderBannerNav__item--active');
            $(this).addClass('SliderBannerNav__item--active');

            var index_active_new = $(this).index();
            var index_active = $('.SliderBanner__list .SliderBanner__item--active').index();

            $('.SliderBanner__list .SliderBanner__item')
                .eq(index_active_new)
                .css('display', 'inline-block')
                .addClass('SliderBanner__item--active');

            if (index_active_new > index_active) {
                $('.SliderBanner__list .SliderBanner__item').eq(index_active).animate({
                    'margin-left': '-100%'
                }, 300, function () {
                    $('.SliderBanner__list .SliderBanner__item').eq(index_active).removeClass('SliderBanner__item--active').hide().css('margin-left', '0');
                    nav_btn.css('pointer-events', '');
                });
            } else if (index_active_new < index_active) {
                $('.SliderBanner__list .SliderBanner__item').eq(index_active_new).css('margin-left', '-100%').animate({
                    'margin-left': '0'
                }, 300, function () {
                    $('.SliderBanner__list .SliderBanner__item').eq(index_active).removeClass('SliderBanner__item--active').hide();
                    nav_btn.css('pointer-events', '');
                });
            }
        });

        function sliderNavNextItem(isGoNext) {
            var nav_items = $('.SliderBannerNav__list .SliderBannerNav__item');
            var index = $('.SliderBannerNav__list .SliderBannerNav__item--active').index();
            if (index === 0 && !isGoNext) {
                nav_items.eq(nav_items.length - 1).click();
            } else if (index === nav_items.length - 1 && isGoNext) {
                nav_items.eq(0).click();
            } else {
                if (isGoNext) {
                    index++;
                } else {
                    index--;
                }
                nav_items.eq(index).click();
            }
        }
    }
})();
// ~ Слайдер баннеров

// Слайдер товаров
(function () {
    if ($('.Showcase').length > 0) {
        $('.js-prev_slide_showcase').hide();
        $(document).on('click', '.js-next_slide_showcase', function () {
            Showcase_slide(true);
        });
        $(document).on('click', '.js-prev_slide_showcase', function () {
            Showcase_slide(false);
        });

        var leftVisible = 0;
        var leftIndent = 0;

        function Showcase_slide(isNavLeft) {
            var navBtn = $('.js-next_slide_showcase, .js-prev_slide_showcase');
            navBtn.css('pointer-events', 'none');

            var ShowcaseItems = $('.Showcase .Showcase__cont .Showcase__list .Showcase__item');
            var preparation = ShowcaseItems.first();
            var widthItem = preparation.outerWidth() + 4.5;
            var rightHidden = {};
            var leftHidden = {};

            if (isNavLeft) {
                rightHidden = ShowcaseItems.filter(':eq(' + (leftVisible + 3) + ')').nextAll();
                if (rightHidden.length >= 4) {
                    leftVisible += 4;
                    leftIndent -= (4 * widthItem);
                } else {
                    leftVisible += (4 - rightHidden.length);
                    leftIndent -= (4 - rightHidden.length) * widthItem;
                }
            } else {
                leftHidden = ShowcaseItems.filter(':eq(' + leftVisible + ')').prevAll();
                if (leftHidden.length >= 4) {
                    leftVisible -= 4;
                    leftIndent += 4 * widthItem;
                } else {
                    leftVisible = 0;
                    leftIndent = 0;
                }
            }

            preparation.animate({
                'margin-left': leftIndent
            }, 300, function () {
                if (isNavLeft) {
                    if (rightHidden.length <= 4) {
                        $('.js-next_slide_showcase').hide();
                        $('.js-prev_slide_showcase').show();
                    } else {
                        $('.js-prev_slide_showcase').show();
                    }
                } else {
                    if (leftHidden.length <= 4) {
                        $('.js-next_slide_showcase').show();
                        $('.js-prev_slide_showcase').hide();
                    } else {
                        $('.js-next_slide_showcase').show();
                    }
                }
                navBtn.css('pointer-events', '');
            });
        }
    }
})();
// ~ Слайдер товаров

// Кнопка копирования текста
(function () {
    if ($('.js-copy_text').length > 0) {
        $(document).on('click', '.js-copy_text', function () {
            copyText();
        });

        var elemCopyText = document.querySelector('.js-copy_text');

        function copyText() {
            try {
                var range = document.createRange();
                range.selectNode(elemCopyText);
                window.getSelection().addRange(range);

                var successful = document.execCommand('copy');
                if (successful) {
                    $(elemCopyText).addClass('rotate360');
                    setTimeout(function () {
                        $('.js-copy_text').removeClass('rotate360');
                    }, 1000);
                }
                window.getSelection().removeAllRanges();
            }
            catch (err) {
                selectText(elemCopyText);
            }
        }

        function selectText(elem) {
            var sel;
            var range;
            if (window.getSelection && document.createRange) { //Browser compatibility
                sel = window.getSelection();
                if (sel.toString() === '') { //no text selection
                    window.setTimeout(function () {
                        range = document.createRange(); //range object
                        range.selectNodeContents(elem); //sets Range
                        sel.removeAllRanges(); //remove all ranges from selection
                        sel.addRange(range); //add Range to a Selection.
                    }, 1);
                }
            }
            else if (document.selection) { //older ie
                sel = document.selection.createRange();
                if (sel.text === '') { //no text selection
                    range = document.body.createTextRange();//Creates TextRange object
                    range.moveToElementText(elem); //sets Range
                    range.select(); //make selection.
                }
            }
        }
    }
})();
// ~ Кнопка копирования текста

// Вертикальный слайдер в карточке товара и Fancybox
function movePhoto(e) {

    var container = $('.js-photoContainer');
    var photo = container.find('.js-switchFullImg');

    if (e && $(e.currentTarget).is('.js-photoContainer')) {
        var w = container.width();
        var h = container.height();
        var W = photo.width();
        var H = photo.height();
        var x = e.pageX - container.offset().left;
        var y = e.pageY - container.offset().top;
        photo.css({
            top: -y/h * (H-h),
            left: -x/w * (W-w)
        });
    } else {
        photo.css({
            top: '',
            left: ''
        });
    }
}

(function () {
    if($('.ProductCard').length > 0){
        var verticalSlider = $('.VerticalSlider');
        if (verticalSlider.length > 0) {
            initVerticalSlider('.ProductCard');
        }

        $(document).on('click', '.js-openProductCardFancybox', function (e) {
            e.preventDefault();

            var targetImg = $('.js-openProductCardFancybox .js-switchFullImg');
            var imgSrc = targetImg.attr('src');
            var activePhoto = verticalSlider.find('.js-switchPreviewImg.active');
            if (activePhoto.length && activePhoto.data('xl-src')) {
                imgSrc = activePhoto.data('xl-src');
            } else if (targetImg.data('xl-src')) {
                imgSrc = targetImg.data('xl-src');
            }
            var html = '' +
                '<div class="Viewer Viewer--product"><div class="Fancybox__wrapper Fancybox__wrapper--heightAuto js-verticalSlider">' +
                '	<div class="Fancybox__fullImgCont js-photoContainer">' +
                '		<img class="Fancybox__fullImg js-switchFullImg" src="' + imgSrc + '" alt="">' +
                '	</div>' +
                '</div></div>';
            $.fancybox({
                'content': html,
                'onComplete': function () {
                    if (verticalSlider.length > 0) {
                        $('.js-verticalSlider').prepend(verticalSlider.clone());
                        initVerticalSlider('.Fancybox__wrapper');
                    }
                }
            });
        });
        $(document).on('click', '.Viewer.Viewer--product .js-photoContainer', function (e) {
            var activePhoto = $('.Viewer.Viewer--product').find('.js-switchPreviewImg.active');
            var imgSrc = activePhoto.data('src');
            if (activePhoto.data('xl-src')) {
                imgSrc = activePhoto.data('xl-src');
            }
            $(this).toggleClass('Fancybox__fullImgCont--zoom');
            $(this).find('img').attr('src', imgSrc);
            if ($(this).hasClass('Fancybox__fullImgCont--zoom')) {
                movePhoto(e);
                $(this).on('mousemove', movePhoto);
            } else {
                movePhoto(false);
                $(this).off('mousemove', movePhoto)
            }
            var container = $(this);
            $(document).one('click', function(e) {
                if (!$(e.target).closest('.js-photoContainer').length) {
                    movePhoto(false);
                    container.off('mousemove', movePhoto)
                }
            });
        });
    }
})();

function initVerticalSlider(containerClass) {
    $(document).on('click', containerClass + ' .js-switchPreviewImg', function (e) {
        e.preventDefault();

        $('.js-photoContainer.Fancybox__fullImgCont--zoom').removeClass('Fancybox__fullImgCont--zoom');
        $(this).closest('.VerticalSlider__list').find('.VerticalSlider__item.active').removeClass('active');
        $(this).addClass('active');

        var imgSrc = $(this).data('src');
        var bigImgSrc = $(this).data('xl-src');
        if (containerClass != '.ProductCard') {
            $(containerClass + ' .js-switchFullImg').attr('src', bigImgSrc);
        } else {
            $(containerClass + ' .js-switchFullImg').attr('src', imgSrc);
        }
        if (containerClass != '.ProductCard') {
            var photoIndex = $(this).data('photo-index');
            $('.ProductCard .js-switchPreviewImg.active').removeClass('active');
            $('.ProductCard .js-switchPreviewImg').filter('[data-photo-index=' + photoIndex + ']').addClass('active');
            $('.ProductCard .js-switchFullImg').attr('src', imgSrc);
        }
    });

    var VerticalSliderItem = $(containerClass + ' .VerticalSlider .VerticalSlider__item');
    var navBtn = $(containerClass + ' .js-VerticalSlider__prev, ' + containerClass +' .js-VerticalSlider__next');

    // в переменную заносится количество видимых элементов, с учётом overflow: hidden у контейнера
    var itemsVisible = $(containerClass + ' .VerticalSlider').height() / (VerticalSliderItem.outerHeight() + parseInt(VerticalSliderItem.css('margin-bottom')));

    if (VerticalSliderItem.length <= itemsVisible) {
        if (VerticalSliderItem.length === VerticalSliderItem.filter(':visible').length) {
            navBtn.hide();
        } else {
            VerticalSliderItem.filter(':visible').first().prev().show();
            initVerticalSlider(containerClass);
        }
    } else if (VerticalSliderItem.length > itemsVisible) {
        if (VerticalSliderItem.filter(':visible').length < itemsVisible) {
            VerticalSliderItem.filter(':visible').first().prev().show();
            initVerticalSlider(containerClass);
        } else if (VerticalSliderItem.filter(':visible').length === itemsVisible) {
            $(containerClass + ' .js-VerticalSlider__next').hide();
        } else if (VerticalSliderItem.filter(':visible').length > itemsVisible) {
            navBtn.hide();
            $(containerClass + ' .js-VerticalSlider__next').show();
        }
    }

    $(document).on('click', containerClass + ' .js-VerticalSlider__prev', function () {
        Vertical_slide(false, 16);
    });
    $(document).on('click', containerClass + ' .js-VerticalSlider__next', function () {
        Vertical_slide(true, 16);
    });

    function Vertical_slide(isNavTop, verticalIndent) {
        navBtn.css('pointer-events', 'none');

        var preparation = VerticalSliderItem.filter(':visible').first();
        var heightItem = preparation.outerHeight();
        var topIndent = -(heightItem + verticalIndent);

        if (!isNavTop) {
            preparation = VerticalSliderItem.filter(':hidden').last().show().css('margin-top', topIndent);
            topIndent = 0;
        }

        preparation.animate({
            'margin-top': topIndent
        }, 300, function () {
            if (isNavTop) {
                preparation.hide().css('margin-top', '0');
                if (VerticalSliderItem.filter(':visible').length <= itemsVisible) {
                    if (VerticalSliderItem.filter(':visible').length === itemsVisible) {
                        navBtn.hide();
                        $(containerClass + ' .js-VerticalSlider__prev').show();
                    } else {
                        $(containerClass + ' .js-VerticalSlider__next').hide();
                    }
                } else {
                    $(containerClass + ' .js-VerticalSlider__prev').show();
                }
            } else {
                if (VerticalSliderItem.filter(':visible').length >= VerticalSliderItem.length) {

                    if (VerticalSliderItem.filter(':visible').length > itemsVisible) {
                        $(containerClass + ' .js-VerticalSlider__prev').hide();
                        $(containerClass + ' .js-VerticalSlider__next').show();
                    } else {
                        $(containerClass + ' .js-VerticalSlider__prev').hide();
                    }
                } else {
                    $(containerClass + ' .js-VerticalSlider__next').show();
                }
            }
            navBtn.css('pointer-events', '');
        });
    }
}
// ~ Вертикальный слайдер в карточке товара и Fancybox

// Пересчёт размера элементов при загрузке и resize страниц
(function () {
    $(window).on('load', function () {
        alignmentElements()
    });

    $(window).on('resize', function () {
        alignmentElements()
    });

    function alignmentElements() {
        if ($('.Header').length > 0) {
            $('.Header').removeClass('Header--smallViewport');
            if(document.documentElement.clientWidth < ($('.HeaderLogo').outerWidth() + $('.HeaderMenu').outerWidth() + 60)){
                $('.Header').addClass('Header--smallViewport');
            } else {
                $('.Header').removeClass('Header--smallViewport');
            }
        }
        if ($('.Catalog__imgCont').length > 0) {
            if ($('.Catalog__imgCont').length) {
                alignmentHeight($('.Catalog__imgCont'));
            }
        }
        if ($('.Catalog__title').length > 0) {
            if ($('.Catalog__title').length) {
                alignmentHeight($('.Catalog__title'));
            }
        }
        if ($('.PhotoList__title').length > 0) {
            if ($('.PhotoList__title').length) {
                alignmentHeight($('.PhotoList__title'));
            }
        }
        if ($('.MasterClassItem__title').length > 0) {
            if ($('.MasterClassItem__title').length) {
                alignmentHeight($('.MasterClassItem__title'));
            }
        }
        if ($('.MasterClassItem__imgCont').length > 0) {
            if ($('.MasterClassItem__imgCont').length) {
                alignmentHeight($('.MasterClassItem__imgCont'));
            }
        }
        if ($('.Section__title').length > 0) {
            if ($('.Section__title').length) {
                alignmentHeight($('.Section__title'));
            }
        }
        if ($('.Section__description').length > 0) {
            if ($('.Section__description').length) {
                alignmentHeight($('.Section__description'));
            }
        }
        if ($('.Showcase__title').length > 0) {
            if ($('.Showcase__title').length) {
                alignmentHeight($('.Showcase__title'));
            }
        }
    }

    // выравнивание высоты/ширины элементов
    /**
     * выравнивание высоты элементов
     * @param selector - $(selector)
     * @param isMax - Выравнивать по максимальному значению? или по минимальному? По-умолчанию == true
     */
    function alignmentHeight(selector, isMax) {
        if (isMax === undefined) {
            isMax = true;
        }

        selector.css('height', '');

        var arr_height_items = selector.map(function () {
            return parseInt($(this).height());
        }).get();

        var alignment_height;

        if (isMax) {
            alignment_height = Math.max.apply(Math, arr_height_items);
        } else {
            alignment_height = Math.min.apply(Math, arr_height_items);
        }

        selector.height(alignment_height);
    }

    /**
     * выравнивание ширины элементов
     * @param selector - $(selector)
     * @param isMax - Выравнивать по максимальному значению? или по минимальному? По-умолчанию == true
     */
    function alignmentWidth(selector, isMax) {
        if (isMax === undefined) {
            isMax = true;
        }

        selector.css('width', '');

        var arr_width_items = selector.map(function () {
            return parseInt($(this).width());
        }).get();

        var alignment_width;

        if (isMax) {
            alignment_width = Math.max.apply(Math, arr_width_items);
        } else {
            alignment_width = Math.min.apply(Math, arr_width_items);
        }

        selector.height(alignment_width);
    }
    // ~ выравнивание высоты/ширины элементов
})();
// ~ Пересчёт размера элементов при загрузке и resize страниц

// переключение табов
$('.Tab__list .Tab__item .Tab__text').unbind('click');

$(document).on('click', '.Tab__list .Tab__item .Tab__text', function(e) {
    e.preventDefault();

    var self = $(this);

    self.closest('.Tab__list').find('.Tab__item').removeClass('Tab__item--active');
    self.closest('.Tab__item').addClass('Tab__item--active');

    var tabIdContent = self.attr('href').replace('#', '');
    self.closest('.Tab__wrapper').find('.Tab__content').removeClass('Tab__content--active');
    $('#' + tabIdContent).addClass('Tab__content--active');
});
// ~ переключение табов

// Добавление антиспама
(function () {
    var form = $('form[name="feedback_ul"]');
    if (form.length > 0) {
        addAntispamAttr(form);
    }

    function addAntispamAttr (form) {
        var sessid = $(form).find('input[name="sessid"]').val().replace(/\D+/g,""),
            attrValue = 0;
        for (var index = 0; index < sessid.length; index++) {
            attrValue += Number(sessid[index]);
        }

        $(form).append('<input type="hidden" name="show_form_icon" value="' + attrValue + '" />');
    }
})();
// ~ Добавление антиспама

$('.js-personalDataAgree').on('click', function (e) {
    e.preventDefault();
    $.fancybox({
        content: $('.js-agreement').html(),
        padding: 30
    });
});

// управление селектом
// обратботчик должен быть универсальным, срабатывать для всех селектов, в том числе добавляющихся скриптами
// разметка должна генерироваться скриптом, чтобы при проблеме с ним селектом можно было пользоваться
// плейсхолдер должен выводиться
if ($('.Select').length) {
    $('.Select').each(function () {
        var B = $(this);
        var label = B.find('.Select__label');
        var select = B.find('.Select__select');
        var option = B.find('option');
        var text = B.find('.Select__text');

        // при загрузке
        // если есть выбранное значение
        if (B.find('option:selected').attr('selected') == 'selected') {
            text.html(B.find('option:selected').text()).removeClass('placeholder');

            // если есть текстовая заглушка
        } else if (select.data('placeholder')) {
            text.html(select.data('placeholder')).addClass('placeholder');

            // если ничего не оказалось
        } else {
            text.html(B.find('option:selected').text()).removeClass('placeholder');
        };

        // по клавиатурным нажатиям
        select.on('keyup.select', function() {
            text.html(B.find('option:selected').text()).removeClass('placeholder');
        });

        // по изменению надо также срабатывать
        select.bind('change', function () {
            var placeholder = B.find('.js-selectPlaceholder'); /* ^ Нет во всём проекте */
            if (placeholder != null) {
                placeholder.remove();
            };
            text.html($(this).find('option:selected').text()).removeClass('placeholder');
        });
    });
};
// ~ управление селектом

// мастер-классы и раскраски показать еще
$(function () {
    $(document).on('click', '.js-loadMore', function(){

        var targetContainer = $('.js-more'),          //  Контейнер, в котором хранятся элементы
            url =  $('.js-loadMore').attr('data-url');    //  URL, из которого будем брать элементы

        if (url !== undefined) {
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'html',
                beforeSend: function() {
                    $('.js-loadMore').addClass('Btn--wait');
                },
                success: function(data){

                    //  Удаляем старую навигацию
                    $('.js-loadMore').remove();

                    var elements = $(data).find('.js-moreElements'),  //  Ищем элементы
                        pagination = $(data).find('.js-loadMore');//  Ищем навигацию

                    targetContainer.append(elements);   //  Добавляем посты в конец контейнера
                    targetContainer.append(pagination); //  добавляем навигацию следом

                }
            })
        }
    });
})
// ~ мастер-классы и раскраски показать еще

$(function () {
    if ($('.js-formResultOk').length) {
        $.fancybox({
            'content': $('.js-formResultOk').html(),
            'onComplete': function () {
                if ($('.js-fancyboxClose').length > 0) {
                    $('.js-fancyboxClose').click(function () {
                        $.fancybox.close();
                    });
                }
            }
        });
    }
    if ($('.js-formResultError').length) {
        $.fancybox({
            'content': $('.js-formResultError').html(),
            'onComplete': function () {
                if ($('.js-fancyboxClose').length > 0) {
                    $('.js-fancyboxClose').click(function () {
                        $.fancybox.close();
                    });
                }
            }
        });
    }
});


$(document).on('click', '.js-openFancyboxColoring', function (e) {
    e.preventDefault();

    imgSrc = $(this).attr('href');
    titleName = $(this).find(".PhotoList__title").text();

    var html = '' +
        '<div class="Fancybox__wrapper Fancybox__wrapper--heightAuto Fancybox__wrapper--imageViewer">' +
        '<div class="FancyboxSlider">' +
        '<ul class="FancyboxSlider__list">' +
        '<li class="FancyboxSlider__item ">' +
        '<div class="FancyboxSlider__imgCont printableArea">' +
        '<img class="FancyboxSlider__img "  src="' + imgSrc + '" alt="">' +
        '</div>' +
        '<span class="Btn Btn--print"></span>' +
        '<div class="FancyboxSlider__title">' + titleName + '</div>' +
        '</li>' +
        '</ul>' +
        '</div>' +
        '</div>';
    $.fancybox({
        'content': html,
    });

});

// анимирование персонажа
if (
	window.CSS
	&& CSS.supports
	&& CSS.supports('transform', 'translateZ(0)')
	&& $('.Anime').length
) {
	$.getScript('/assets/js/lottie.min.js', function () {
		initAnime('.Anime--main', {
			name: 'banner'
		});

		initAnime('.Anime--welcome', {
			name: 'welcome'
		});

		initAnime('.Anime--about', {
			name: 'about'
		});


		function initAnime (item, opts) {
			if (!$(item).length) { return };

			if (typeof opts === 'undefined') {
				opts = {};
			};

			opts.name = opts.name || 'welcome';
			
			var isSVG = typeof SVGRect !== 'undefined';
			
			var anime = bodymovin.loadAnimation({
				container: $(item).find('.Anime__content')[0],
				path: '/assets/js/animations/'+ opts.name +'.json',
				renderer: isSVG ? 'svg' : 'svg/canvas/html',
				loop: opts.loop || true,
				autoplay: opts.autoplay || false,
				name: opts.name
			});

			anime.addEventListener('DOMLoaded', function () {
				$(item).addClass('Anime--loaded');
				anime.play();
			});

			window.onresize = anime.resize.bind(anime);
		};
	});
};
// ~ анимирование персонажа

// прокрутка к баннеру
if (
    $('.Anime--welcome').length
    && $('.Page__main--mainPage').length
) {
    $('.Anime--welcome').on('click', function () {
        $('html, body').animate({
            scrollTop : $('.Page__main--mainPage').offset().top
        }, 500);
    });
};
// ~ прокрутка к баннеру

// печать раскрасок
$(document).on('click', '.Btn--print', function(e) {
    e.preventDefault();

    var $this = $(this);
    $this.hide();
    $this.siblings('.FancyboxSlider__title').hide();
    var originalContent = $('body').html();
    var printArea = $this.parents('.FancyboxSlider').html();
    $('body').html('<div class=" Fancybox__wrapper--imageViewer">' + printArea + '</div>');
    window.print();
    window.location.href = "";
});
// ~ печать раскрасок