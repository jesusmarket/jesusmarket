var sbfp_countdown  = sbfp_script_data.countdown;
var sbfp_timeout    = sbfp_script_data.timeout;

(function( $ ) {
  'use strict';

  $(document).ready(function($) {

      var popup = $(".state-fb-pop-up");
      var now = (new Date()).getTime();
      var lastTime = 0;
      var lastTimeStr = localStorage['lastTime'];
      
      if (lastTimeStr) lastTime = parseInt(lastTimeStr, 10);
      
      if (now - lastTime >  sbfp_timeout * 60 * 1000) {
        popup.delay( sbfp_countdown * 1000 ).animate({
          left: '0px', bottom: '0px'
        }, {
          duration: 2000
        });

        localStorage['lastTime'] = "" + now;

        $(".state-fb-pop-up-close").click(function() {
          popup.animate({
            left: '-2000px'
          }, "slow");
        });
      }
  });


})( jQuery );