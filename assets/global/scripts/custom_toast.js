var NotifikasiToast = function (data) {
    if(!data)
      return;
    var type,msg,title;
    if(!data.type){type = 'success';}else{type = data.type;}
    if(!data.msg){msg = '';}else{msg = data.msg;}
    if(!data.title){title = '';}else{title = data.title;}

    toastr.options = {
      closeButton: true,
      debug: false,
      positionClass: "toast-top-full-width",
      onclick: null,
      showDuration: "1000",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut"
    }

    var $toast = toastr[type](msg, title);
  }