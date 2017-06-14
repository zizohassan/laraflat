/**
 * Sweetalerts demo page
 */
(function($) {
  'use strict';

  $('.demo1').on('click', function() {
    swal('Here\'s a message!');
  });

  $('.demo2').on('click', function() {
    swal({
      title: 'Auto close alert!',
      text: 'I will close in 2 seconds.',
      timer: 2000
    });
  });

  $('.demo3').on('click', function() {
    swal('Here\'s a message!', 'It\'s pretty, isn\'t it?');
  });

  $('.demo4').on('click', function() {
    swal('Good job!', 'You clicked the button!', 'success');
  });

  $('.demo5').on('click', function() {
    swal({
      title: 'Are you sure?',
      text: 'You will not be able to recover this imaginary file!',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#DD6B55',
      confirmButtonText: 'Yes, delete it!',
      closeOnConfirm: false
    }, function() {
      swal('Deleted!', 'Your imaginary file has been deleted!', 'success');
    });
  });

  $('.demo6').on('click', function() {
    swal({
      title: 'Are you sure?',
      text: 'You will not be able to recover this imaginary file!',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#DD6B55',
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel plx!',
      closeOnConfirm: false,
      closeOnCancel: false
    }, function(isConfirm) {
      if (isConfirm) {
        swal('Deleted!', 'Your imaginary file has been deleted!', 'success');
      } else {
        swal('Cancelled', 'Your imaginary file is safe :)', 'error');
      }
    });
  });

  $('.demo7').on('click', function() {
    swal({
      title: 'Sweet!',
      text: 'Here\'s a custom image.',
      imageUrl: 'images/avatar.jpg'
    });
  });

  $('.demo8').on('click', function() {
    swal({
      title: 'HTML <small>Title</small>!',
      text: 'A custom <span style=\"color:#F8BB86\">html<span> message.',
      html: true
    });
  });

  $('.demo9').on('click', function() {
    swal({
      title: 'An input!',
      text: 'Write something interesting:',
      type: 'input',
      showCancelButton: true,
      closeOnConfirm: false,
      animation: 'slide-from-top',
      inputPlaceholder: 'Write something'
    }, function(inputValue) {
      if (inputValue === false) {
        return false;
      }
      if (inputValue === '') {
        swal.showInputError('You need to write something!');
        return false;
      }
      swal('Nice!', 'You wrote: ' + inputValue, 'success');
    });
  });

  $('.demo10').on('click', function() {
    swal({
      title: 'Ajax request example',
      text: 'Submit to run ajax request',
      type: 'info',
      showCancelButton: true,
      closeOnConfirm: false,
      showLoaderOnConfirm: true
    }, function() {
      setTimeout(function() {
        swal('Ajax request finished!');
      }, 2000);
    });
  });

})(jQuery);
