$( document ).ready(function() {
    $('.toggle').click(function(e) {
      e.preventDefault();
    
      var $this = $(this);
      $('.toggle').removeClass('active');
    
      if ($this.next().hasClass('show')) {
          $this.removeClass('active');
          $this.next().removeClass('show');
          $this.next().slideUp(350);
      } else {
          $this.parent().parent().find('li .inner').removeClass('show');
          $this.parent().parent().find('li .inner').slideUp(350);
          $this.toggleClass('active');
          $this.next().toggleClass('show');
          $this.next().slideToggle(350);
      }
  });
});