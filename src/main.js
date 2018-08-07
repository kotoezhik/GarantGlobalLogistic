$(document).ready(function () {
  // customization of file uploading field
  $('.upload').click(function () {
    $('.upload-input').trigger('click');

  });
  $('#buttobottom').click(function () {
    $("html, body").animate({
      scrollTop: $('#form-get-info').first().offset().top - 60
    }, 1000)
  });
  // trigger to open pop up windows
  $('[data-popup]').on('click', function (e) {
    e.preventDefault();

    var id = $(this).attr('data-popup');
    $('#' + id).removeClass('hidden');
  });


  // close pop up after click on page
  $(document).on('click', function (event) {
    var target = $(event.target).closest('[data-popup-window]').attr('data-popup-window') || $(event.target).attr('href');
    if (!target) {
      $('[data-popup-window]').addClass('hidden');
    }
  })

  $("#form-cost, #application, #application2, #application5, #application8, #application9, #application10, #application13").submit(function () {
    var route = "application.php";
    var data = $(this).serialize();
    if ($(this).hasClass("registration-form")) {
      route = "/ap_s/send.php";
    }
    if (!$(this).find("input:checkbox").is(":checked")) {
      $(this).find(".box-change").css('color', '#c60606');
      return false;
    }
    $(this).find(".text-change").hide();
    $(this).children().hide();
    $(this).find(".label_sndok").show();
    $(this).find(".label_indent").css("margin", 10 + "px");
    $(this).find(".label-change").css("margin-top", 65 + "px");
    $.ajax({
      method: "POST",
      url: route,
      data: data
    });
    return false;
  });

  $(".mask-phone").mask("+7(999)999-9999");

});

$(document).ready(function () {

  $(".btn-box").on("click", "a", function (event) {
    event.preventDefault();
    var id = $(this).attr('href'),
      top = $(id).offset().top;
    $('body,html').animate({
      scrollTop: top
    }, 300);
  });

  /* Yandex maps */
  var myMap;
  
  // Дождёмся загрузки API и готовности DOM.
  ymaps.ready(init);

  function init() {

    //    var myPlacemark;
    myMap = new ymaps.Map(
      'yamap', {
        center: [43.0975, 131.8650],
        zoom: 16,
        scroll: false
      }
    );

    var myPlacemark = new ymaps.Placemark([43.0975, 131.8650], {
      iconCaption: 'улица Стрельникова, 7',
      iconLayout: 'default#image',
      iconImageHref: '/img/icon-map-pointer.png',
      iconImageSize: [39, 40],
      iconImageOffset: [-20, -20],
      hideIconOnBalloonOpen: false,
    });
    
    /* убрать поле поиска на карте */
    myMap.controls.remove('searchControl');

    myMap.events.add('click', function () {
      myMap.balloon.close();
    });

    myMap.behaviors.disable('scrollZoom');
    myMap.geoObjects.add(myPlacemark);
  }

  
  /* end Yandex maps */
});