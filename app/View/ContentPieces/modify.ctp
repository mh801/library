<?php
//Content Piece index and search
$title = (isset($search_criteria))?'Content Library Modify - "'.$search_criteria.'"':'Content Library - Most Recent Content';
$this->assign('title', $title); ?>

<div style="clear:both;"></div>
<h2 class="search-criteria">Remove Content Pieces</h2>
<table cellpadding="0" cellspacing="0" id="pieces">
    <thead>
    <tr class="thead">
        
        <th>Name</th>
        <th>Type</th>
        <th>Links</th>
        
        <th>Partner</th>
        <th>Date</th>        
        <th class="download">Download</th>
        <th class="download">Delete</th>
    </tr>
    </thead>
    <tbody>
<?php
foreach($pieces as $piece){ 
   // $links = $this->ContentPiece->getLinks($piece['cp']['id']);
  //  var_dump($links);
    $keywords = $this->requestAction('keywords/keywords/'.$piece['cp']['id']);
    $links = $this->requestAction('links/links/'.$piece['cp']['id']);
    //var_dump($keywords);
    ?>
        <tr>
            
            <td class="piece-name" rel="<?php echo $piece['cp']['id'] ?>">
                <?php echo $piece['cp']['name'] ?>
                <div class="piece-desc" id="<?php echo $piece['cp']['id'] ?>">Description:<br/><?php echo $piece['cp']['description'] ?></div>
            </td>
            
            <!--<td><?php echo $piece['cp']['description'] ?></td> -->
           
            <td><!--<a href="/types/view/<?php echo $piece['t']['type_id'] ?>">--><?php echo $piece['t']['type'] ?><!--</a>--></td>
            <td>
                <?php foreach($links as $link){
                    //var_dump($keyword);
                    
                    echo '<a href="'.$link['l']['url'].'" target="_blank">'. $link['l']['url'] . '</a><br/>';
                   
                }?>
            </td>
            <!--
            <td>
                <?php foreach($keywords as $keyword){
                    //var_dump($keyword);
                    echo $keyword['k']['keyword'] . '<br/>';
                }?>
            </td>
            -->
            <td><?php echo ($piece['p']['partner']!=null)?$piece['p']['partner']:'N/A' ?></td>
            <?php
                $date = date("m/d/Y", strtotime($piece['cp']['modified_at']));
            ?>
            <td style="position:relative;width:100px;"><?php echo $date ?></td>        
            <td class="dl-btn">
               <?php if(!$links){ ?>
                <a href="<?php echo $piece['f']['path'] ?>" target="_blank"><img src="https://8a14a4cdc153845f32b5-8250b0a3feea020289d5768bda2f75a1.ssl.cf1.rackcdn.com/contentlibrary/download.png"/></a>
                <?php } ?>
            </td>
            <td> <a href="/content_pieces/delete/?id=<?php echo $piece['cp']['id'] ?>">Delete</a></td>
        </tr>
<?php } ?>
        </tbody>
</table>
<?php $weight = 105; ?>
<script>
var words = [
<?php 
    
     foreach($cloudwords as $keyword){
         $weight -= 5;
         echo '{text:"'.$keyword['keywords']['keyword'].'",weight:'.$weight.',link:"/?searchwords='.$keyword['keywords']['keyword'].'"},';
     }
?>  
    /*
  {text: "Lorem", weight: 13, link: 'http://github.com/mistic100/jQCloud'},
  {text: "Ipsum", weight: 10.5, link: 'http://www.strangeplanet.fr'},
  {text: "Dolor", weight: 9.4, link: 'http://piwigo.org'},
  /* ... */
];
    
var visible = 0    
$(document).ready(function(){
    
    //$( "#partners" ).combobox();
    
    $('#advanced-search').hide();
    //$('.search-btn').css({'left':'0px'});
     $('.adv-search').click(function(){
        visible = (visible ==0)?1:0;
        if(visible == 1){
            $('.adv-search').text('- Advanced Search');
        }else{
             $('.adv-search').text('+ Advanced Search');
        }
          $('#advanced-search').slideToggle();
         //$('.search-btn').css({'left':'-81px'});
     });
    $('#pieces').DataTable(
        {
           'aoColumnDefs': [{
                'bSortable': false,
                'aTargets': [-1] /* 1st one, start by the right */
            }]
        }
    );
    $('.download').removeClass('sorting');
    
    $( ".date-input" ).datepicker();
    
    $('.search-words').click(function()
    {
    $this = $(this);
        if($this.val()=='Search for content by name or keyword'){
            $this.val('');
        }                     
    });
    $('.search-words').blur(function()
    {
    $this = $(this);
        if($this.val()==''){
            $this.val('Search for content by name or keyword');
        }                     
    });
    
    $('.phone-input').click(function()
    {
    $phone = $(this);
        if($phone.val()=='Enter a phone number'){
            $phone.val('');
        }                     
    });
    $('.phone-input').blur(function()
    {
    $this = $(this);
        if($phone.val()==''){
            $phone.val('Enter a phone number');
        }                     
    });  
    //$('#pieces_filter').hide();
   // $( ".end-date" ).datepicker();
    //$('.dataTables_filter label').html('Filter Table <br/><input type="search" class="" placeholder="" aria-controls="pieces">');
    

    //keyword cloud
    $('#key-words').jQCloud(words);
    
    // clear search bar val on no fill submit
     $('.search-btn').click(function(e)
    {    
        // e.preventDefault();
        if($('.search-words').val()=='Search for content by name or keyword'){
            $('.search-words').val('');
        }                     
    });
    
    
    $('.dataTables_empty').html('<span style="font-weight:bold">Sorry, there are no results.</span> Try another search.');
    
        $('#audience').on('change',function(){
        $.post( "/categories/filterbyaudience/?id="+$('#audience').val(),function(data){
            if(data){
             $('#category').html(data);
            }
        });
    });
        $('#category').on('change',function(){
        $.post( "/types/filterbycategory/?id="+$('#category').val(),function(data){
           
            if(data){
             $('#type').html(data);
            }
        });
    });  
    
    $('.piece-desc').hide();
    $('.piece-name').hover(
        function(){
            $('#'+$(this).attr('rel')).show();
        },
        function(){
            $('#'+$(this).attr('rel')).hide();    
    });
});
    
    
</script>
    
  <script>
      /*
  (function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.autocomplete( "instance" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );
 
*/
  </script>    