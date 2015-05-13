var $j = jQuery.noConflict();

$j(window).load(function(){
  
  // isotope container
  var $container = $j(".downloads-list.grid");

  $container.isotope({
    // layout
    layoutMode: "sloppyMasonry",
    itemSelector: ".type-download",
    animationEngine: "best-available",
    // sorting data
    getSortData: {
      title : function ( $elem ) {
        return $elem.find(".title").text();
    }
    }
  });

  // sort items on button click
  $j('#isotope-sort a').click(function() {
    $j('#isotope-sort a').removeClass('active');
    $j(this).addClass('active'); 
    
    var sortByValue = $j(this).attr('data-sort-by');
    
    if (sortByValue == 'title-asc') {
      $container.isotope({ sortBy: 'title', sortAscending: true }); 

    }
    if (sortByValue == 'title-dsc') {
      $container.isotope({ sortBy: 'title', sortAscending: false });  
    }
    if (sortByValue == 'title-def') {
      $container.isotope({ sortBy : "original-order" });
    }
  });

  // filter items when filter link is clicked
  $j('#isotope-categories a, #isotope-tags a').click(function(){
    $j('#isotope-categories a, #isotope-tags a').removeClass('active');
    $j(this).addClass('active'); 

    var selector = $j(this).attr('data-filter');
    $container.isotope({ filter: selector });
    return false;
  });

});