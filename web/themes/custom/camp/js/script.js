(function ($, Drupal) {
    Drupal.behaviors.headerScroll = {
      attach: function (context, settings) {
        $(document).ready(function() {
          $(context).find('.profile-name').on('click', function() {
            console.log('Clicked on .profile-name');
            $(this).toggleClass('open');
            console.log($(this).next('.profile-dropdown-menu')); // Check if the element is selected
            $(this).next('.profile-dropdown-menu').toggleClass('open');
          });
          // Appending the Register now Button and Profile name ot Hamburger menu.
          $(context).find('.profile-name').length?$(context).find('.profile-name').clone().appendTo($(context).find('.cheeseburger-menu__mainmenu')):'';
          $(context).find('.register-now').length? $(context).find('.register-now').clone().appendTo($(context).find('.cheeseburger-menu__mainmenu')): '';   
        });
        
        $(window, context).on('scroll', function () {
          var header = $('.page-header');
          var scrollPosition = $(window).scrollTop();
          var scrollThreshold = 80; // Scroll threshold set to 60 pixels
    
          if (scrollPosition > scrollThreshold) {
            if (!header.hasClass('fixed')) {
              header.addClass('fixed');
              header.hide().fadeIn('fast');
            }
          } else {
            header.removeClass('fixed');
          }
        });

        
        
      }
    };
  })(jQuery, Drupal);
  
  