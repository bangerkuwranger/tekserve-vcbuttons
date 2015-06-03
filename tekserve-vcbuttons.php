<?php

/**
 * Plugin Name: Tekserve VCButtons
 * Plugin URI: https://github.com/bangerkuwranger
 * Description: Custom shortcodes for interface elements and Visual Composer button mappings
 * Version: 1.2.4
 * Author: Chad A. Carino
 * Author URI: http://www.chadacarino.com
 * License: MIT
 */
/*
The MIT License (MIT)
Copyright (c) 2013-2015 Chad A. Carino
 
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

/**  Shortcodes for VC Buttons  **/



//e.g.[repairstatus] 
//shortcode for tekserve repair status checker, if not loaded by helper
//code is in helper for actual output
if( !( function_exists( 'repair_status_checker' ) ) ) {

	function repair_status_checker( $atts ) {
	
		return '<h2>Status Checker is currently offline.</h2><p>Please call our service department directly at 212.929.3645.</p>'; 
	
	}	//end repair_status_checker( $atts )
	
	add_shortcode( 'repairstatus', 'repair_status_checker' );

}	//end if( !( function_exists( 'repair_status_checker' ) ) )



//e.g.[drawer title='title' swaptitle='alternate title for open drawer' alt='hover tag' notitle='"true" if no hover element desired' id='unique-id' tag='<div>' trigclass='trigger-class' targtag='<span>' targclass='target-content-class' rel='group-for-elements-only-one-open-at-a-time' expanded='"true" to expand on page load' startwrap='<div class="extra-class-wrapper"><h1>' endwrap='</h1></div>' color='orange' alignment='left']
//custom shortcode for collapsomatic elements, requires collapseomatic plugin. This modifies shortcode to pass correct elements and content to Visual Composer
function drawer( $atts, $content = null ) { // New function parameter $content is added!

   extract( shortcode_atts( array(
		'title' => 'Click Here',
		'swaptitle' => 'Click Here to Hide',
		'alt' => '',
		'notitle' => '',
		'id' => 'id'.$ran,
		'tag' => $options['tag'],
		'trigclass' => '',
		'trigpos' => $options['trigpos'],
		'targtag' => $options['targtag'],
		'targclass' => '',
		'targpos' => $options['targpos'],
		'rel' => '',
		'expanded' => '',
		'excerpt' => '',
		'excerptpos' => 'below-trigger',
		'excerpttag' => 'div',
		'excerptclass' => '',
		'swapexcerpt' => false,
		'findme' => '',
		'offset' => $options['offset'],
		'scrollonclose' => '',
		'startwrap' => '',
		'endwrap' => '',
		'elwraptag' => $options['wraptag'],
		'elwrapclass' => $options['wrapclass'],
		'cookiename' => '',
		'color' => 'none',
		'alignment' => 'left',
		'findme' => 'auto'
   ), $atts ) );
 
   $content = wpb_js_remove_wpautop( $content ); // fix unclosed/unwanted paragraph tags in $content
   $showonload = "none";
   if( $expanded == "true" ) {
   
			$trigclass .= ' colomat-close';
			$showonload = "block";
	
	}	//end if( $expanded == "true" )
   return "
   <div class='section ${color} dsection'>
   		<div class='drawer'>
   			<a id='find-${id}' name='' alt='0'> </a>
   			<span id='${id}' class='collapseomatic find-me ${alignment} " . $trigclass . "' title='${title}'>${title}</span>
   			<span id='swap-${id}' style='display:none;'>${swaptitle}</span>
   			<div id='target-${id}' class='collapseomatic_content' style='display:".$showonload.";'>
   				${content}
   			</div>
   		</div>
   	</div>";

}	//end drawer( $atts, $content = null )

add_shortcode( 'drawer', 'drawer' );




//e.g.[detailbox detailtitle[n]='title' detailcontent[n]='This is the info.']
//where [n] is the integer (1-10) corresponding to the number of the title & content pair in the detailbox
//shortcode for detailbox
function detail_box( $atts, $content = null ) { // New function parameter $content is added!

   extract( shortcode_atts( array(
		'detailtitle1' => 'Click Here',
		'detailcontent1' => 'This is the information',
		'detailtitle2' => '',
		'detailcontent2' => '',
		'detailtitle3' => '',
		'detailcontent3' => '',
		'detailtitle4' => '',
		'detailcontent4' => '',
		'detailtitle5' => '',
		'detailcontent5' => '',
		'detailtitle6' => '',
		'detailcontent6' => '',
		'detailtitle7' => '',
		'detailcontent7' => '',
		'detailtitle8' => '',
		'detailcontent8' => '',
		'detailtitle9' => '',
		'detailcontent9' => '',
		'detailtitle10' => '',
		'detailcontent10' => ''
   ), $atts ) );
 
	$content = wpb_js_remove_wpautop( $content ); // fix unclosed/unwanted paragraph tags in $content
	//create opening containers
	$finaloutput = "
	<div class='detailBox'>
		<div class='detailBox-left'>";
	//loop creates triggers on left side of detailbox
	$i = 1;
	while( $i <= 10 ) {
	
		$currenttitle = 'detailtitle' . $i;
		$currenttitle = $atts[$currenttitle];
		$currentid = strtolower( preg_replace( "/[^A-Za-z0-9]/", "", $currenttitle ) );
		if( $currenttitle != '' ) {
		
			$finaloutput = $finaloutput . "
				<div class='detailBoxTrigger-container'>
					<div class='detailBoxTrigger' id='" . $currentid . "_trigger'>" . $currenttitle . "
					</div>
				</div>";
		
		}	//end if( $currenttitle != '' )
		$i++;
	
	}	//end while( $i <= 10 )
	//close left side and open right side divs; also add mobile interface elements
	$finaloutput = $finaloutput . "
		</div>
			<div class='detailBox-right'>
				<div class='detailBox-mobile'>
					<span class='detailBox-mobile-back'>back</span>
					<span class='detailBox-mobile-title'>Title</span>
				</div>";
	//loop creates content panels
	$i = 1;
	while( $i <= 10 ) {
	
		$currentid = 'detailtitle' . $i;
		$currentid = $atts[$currentid];
		$currentid = strtolower( preg_replace( "/[^A-Za-z0-9]/", "", $currentid ) );
		$currentcontent = 'detailcontent' . $i;
		$currentcontent = rawurldecode( base64_decode( strip_tags( $atts[$currentcontent] ) ) );
		if( $currentcontent != '' ) {
		
			$finaloutput = $finaloutput . "
				<div class='detailBox-detail' id='" . $currentid . "'>
					" . $currentcontent . "
				</div>";
		
		}	//end if( $currentcontent != '' )
		$i++;
	
	}	//end while( $i <= 10 )
	//close right and container divs
	$finaloutput = $finaloutput."
		</div>
	</div>";
	return $finaloutput;

}	//end detail_box( $atts, $content = null )

add_shortcode( 'detailbox', 'detail_box' );




/*** Custom Visual Composer Mappings ***/
if( function_exists( 'vc_map' ) ) { //check for vc_map function before mapping buttons

	vc_map( array(
	   "name" => __("Repair Status Checker"),
	   "base" => "repairstatus",
	   "class" => "",
	   "show_settings_on_create" => false,
	   "icon" => "icon-wpb-repairstatus",
	   "category" => __('Content'),
	) );
	//end vc_map Repair Status Checker

	vc_map( array(
	   "name" => __("Sortable Table"),
	   "base" => "sorttablepost",
	   "class" => "",
	   "icon" => "icon-wpb-sorttablepost",
	   "category" => __('Content'),
	   "params" => array(
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Unique ID"),
			 "param_name" => "id",
			 "value" => __(""),
			 "description" => __("Enter a unique id (no spaces) for this table."),
			 "admin_label" => true
		  ),
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Custom Post Type"),
			 "param_name" => "type",
			 "value" => __(""),
			 "description" => __("Enter the slug for the post type you would like to display"),
			 "admin_label" => true
		  ),
		 array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Custom Hierarchical Taxononomy"),
			 "param_name" => "cat",
			 "value" => __(""),
			 "description" => __("Enter the slug for the custom taxonomy you would like to display"),
			 "admin_label" => true
		  ),
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Custom Non-Hierarchical Taxononomy"),
			 "param_name" => "cat",
			 "value" => __(""),
			 "description" => __("Enter the slug for the custom taxonomy you would like to display"),
			 "admin_label" => true
		  ),
		  array( // need to troubleshoot this feature for vc
			 "type" => "exploded_textarea",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Additional Columns"),
			 "param_name" => "meta",
			 "value" => __(""),
			 "description" => __("Enter the slugs for any additional fields you'd like to display as a column. Separate slugs with line breaks by pressing return key."),
			 "admin_label" => True
		  ),
		 array(
			 "type" => "checkbox",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Hide Featured Image"),
			 "param_name" => "nothumb",
			 "value" => "",
			 "description" => __("Check to hide the featured image column"),
			 "admin_label" => False
		  ),
		 array(
			 "type" => "checkbox",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Hide Title"),
			 "param_name" => "notitle",
			 "value" => "",
			 "description" => __("Check to hide the title column"),
			 "admin_label" => False
		  ),
		 array(
			 "type" => "checkbox",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Hide Post Date"),
			 "param_name" => "nodate",
			 "value" => "",
			 "description" => __("Check to hide the column for the post's date"),
			 "admin_label" => False
		  ),
		 array(
			 "type" => "checkbox",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Hide Categories"),
			 "param_name" => "nocats",
			 "value" => "",
			 "description" => __("Check to hide the categories column"),
			 "admin_label" => False
		  ),
		 array(
			 "type" => "checkbox",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Hide Tags"),
			 "param_name" => "notags",
			 "value" => "",
			 "description" => __("Check to hide the tags column"),
			 "admin_label" => False
		  )
		)
	)	);
	//end vc_map Sortable Table
	

	vc_map( array(
	   "name" => __("Drawer"),
	   "base" => "drawer",
	   "class" => "",
	   "icon" => "icon-wpb-drawer",
	   "category" => __('Content'),
	   "admin_enqueue_css" => array(plugins_url().'/tekserve-vcbuttons/vc_extend/icons.css'),
	   "params" => array(
		 array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Unique ID"),
			 "param_name" => "id",
			 "value" => __("click-here"),
			 "description" => __("Required; Unique ID to identify drawer on this page. Use all lowercase, no special characters or spaces."),
			 "admin_label" => True
		  ),
		  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title"),
			 "param_name" => "title",
			 "value" => __("Click Here"),
			 "description" => __("Required; Text that user clicks on to expand drawer"),
			 "admin_label" => True
		  ),
		  array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Background Color"),
			 "param_name" => "color",
			 "value" => array("white", "orange", "darkblue", "lightblue"),
			 "description" => __("Choose the background color for this drawer."),
			 "admin_label" => True
		  ),
		  array(
			 "type" => "textarea_html",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Content"),
			 "param_name" => "content",
			 "value" => __("<p>I am test text block. Click edit button to change this text.</p>"),
			 "description" => __("Required; Enter the drop-down content of the drawer."),
			 "admin_label" => False
	   ),
	   array(
			 "type" => "dropdown",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Open on Page Load"),
			 "param_name" => "expanded",
			 "value" => array("false", "true"),
			 "description" => __("Select whether this drawer will be opened or closed when the page loads. False (closed) is default."),
			 "admin_label" => True
		  ),
	) 
		)
	);
	//end vc_map Drawer

	vc_map( array(
	   "name" => __("Detail Box"),
	   "base" => "detailbox",
	   "class" => "",
	   "icon" => "icon-wpb-detailBox",
	   "category" => __('Content'),
	   "params" => array(
		 array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title 1"),
			 "param_name" => "detailtitle1",
			 "value" => __("Click Here"),
			 "description" => __("Enter the title for the first item."),
			 "admin_label" => True
		  ),
		  array(
			 "type" => "textarea_raw_html",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Content 1"),
			 "param_name" => "detailcontent1",
			 "value" => __("<p>I am test text block. Click edit button to change this text.</p>"),
			 "description" => __("Enter the content for the first item."),
			 "admin_label" => False
		  ),
	   	  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title 2"),
			 "param_name" => "detailtitle2",
			 "value" => __(""),
			 "description" => __("Enter the title for the second item."),
			 "admin_label" => True
		  ),
		  array(
			 "type" => "textarea_raw_html",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Content 2"),
			 "param_name" => "detailcontent2",
			 "value" => __(""),
			 "description" => __("Enter the content for the second item."),
			 "admin_label" => False
	      ),
	   	  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title 3"),
			 "param_name" => "detailtitle3",
			 "value" => __(""),
			 "description" => __("Enter the title for the third item."),
			 "admin_label" => True
		  ),
		  array(
			 "type" => "textarea_raw_html",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Content 3"),
			 "param_name" => "detailcontent3",
			 "value" => __(""),
			 "description" => __("Enter the content for the third item."),
			 "admin_label" => False
	      ),
	   	  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title 4"),
			 "param_name" => "detailtitle4",
			 "value" => __(""),
			 "description" => __("Enter the title for the fourth item."),
			 "admin_label" => True
		  ),
		  array(
			 "type" => "textarea_raw_html",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Content 4"),
			 "param_name" => "detailcontent4",
			 "value" => __(""),
			 "description" => __("Enter the content for the fourth item."),
			 "admin_label" => False
	      ),
	   	  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title 5"),
			 "param_name" => "detailtitle5",
			 "value" => __(""),
			 "description" => __("Enter the title for the fifth item."),
			 "admin_label" => True
		  ),
		  array(
			 "type" => "textarea_raw_html",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Content 5"),
			 "param_name" => "detailcontent5",
			 "value" => __(""),
			 "description" => __("Enter the content for the fifth item."),
			 "admin_label" => False
	      ),
	   	  array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title 6"),
			 "param_name" => "detailtitle6",
			 "value" => __(""),
			 "description" => __("Enter the title for the sixth item."),
			 "admin_label" => True
		  ),
		  array(
			 "type" => "textarea_raw_html",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Content 6"),
			 "param_name" => "detailcontent6",
			 "value" => __(""),
			 "description" => __("Enter the content for the sixth item."),
			 "admin_label" => False
	      ),
	      array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title 7"),
			 "param_name" => "detailtitle7",
			 "value" => __(""),
			 "description" => __("Enter the title for the seventh item."),
			 "admin_label" => True
		  ),
		  array(
			 "type" => "textarea_raw_html",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Content 7"),
			 "param_name" => "detailcontent7",
			 "value" => __(""),
			 "description" => __("Enter the content for the seventh item."),
			 "admin_label" => False
	      ),
	      array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title 8"),
			 "param_name" => "detailtitle8",
			 "value" => __(""),
			 "description" => __("Enter the title for the eighth item."),
			 "admin_label" => True
		  ),
		  array(
			 "type" => "textarea_raw_html",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Content 8"),
			 "param_name" => "detailcontent8",
			 "value" => __(""),
			 "description" => __("Enter the content for the eighth item."),
			 "admin_label" => False
	      ),
	      array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title 9"),
			 "param_name" => "detailtitle9",
			 "value" => __(""),
			 "description" => __("Enter the title for the ninth item."),
			 "admin_label" => True
		  ),
		  array(
			 "type" => "textarea_raw_html",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Content 9"),
			 "param_name" => "detailcontent9",
			 "value" => __(""),
			 "description" => __("Enter the content for the ninth item."),
			 "admin_label" => False
	      ),
	      array(
			 "type" => "textfield",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Title 10"),
			 "param_name" => "detailtitle10",
			 "value" => __(""),
			 "description" => __("Enter the title for the tenth item."),
			 "admin_label" => True
		  ),
		  array(
			 "type" => "textarea_raw_html",
			 "holder" => "div",
			 "class" => "",
			 "heading" => __("Content 10"),
			 "param_name" => "detailcontent10",
			 "value" => __(""),
			 "description" => __("Enter the content for the tenth item."),
			 "admin_label" => False
	      )
	) 
		)
	);
	//end vc_map Detail Box
	
	
	vc_map( array(
	   "name" => __("Testimonial"),
	   "base" => "tekserve-testimonial",
	   "class" => "",
	   "icon" => "icon-wpb-testimonial",
	   "category" => __('Content'),
	   "params" => array(
		   array(
				 "type" => "textfield",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Testimonial ID"),
				 "param_name" => "id",
				 "value" => __(""),
				 "description" => __("Enter the ID number of the single Testimonial to display. Leave blank to display a group."),
				 "admin_label" => True
			  ),
			  array(
				 "type" => "textfield",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Testimonial Type"),
				 "param_name" => "type",
				 "value" => __(""),
				 "description" => __("To display a group of Testimonials, enter the Type here instead of an ID. All testimonials of that type will be displayed."),
				 "admin_label" => True
			  )
		)
	)	);
	//end vc_map Testimonial
	
	
	
	vc_map( array(
	   "name" => __("Case Study"),
	   "base" => "tekserve-case-study",
	   "class" => "",
	   "icon" => "icon-wpb-case-study",
	   "category" => __('Content'),
	   "params" => array(
		   array(
				 "type" => "textfield",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Case Study ID"),
				 "param_name" => "id",
				 "value" => __(""),
				 "description" => __("Enter the ID number of the single Case Study to display. Leave blank to display a group."),
				 "admin_label" => True
			  ),
			  array(
				 "type" => "textfield",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Case Study Type"),
				 "param_name" => "type",
				 "value" => __(""),
				 "description" => __("To display a group of Case Studies, enter the Type here and leave ID blank. All case studies of that type will be displayed."),
				 "admin_label" => True
			  )
		)
	)	);
	//end vc_map Case Study
	

	vc_map( array(
	   "name" => __("Single Post"),
	   "base" => "single_post",
	   "class" => "",
	   "icon" => "icon-wpb-single-post",
	   "category" => __('Content'),
	   "params" => array(
			array(
				 "type" => "textfield",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Post ID"),
				 "param_name" => "id",
				 "value" => __(""),
				 "description" => __("Enter the ID number of the single Post to display."),
				 "admin_label" => True
			),
			array(
				 "type" => "dropdown",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Show Image?"),
				 "param_name" => "showimage",
				 "value" => array( "show", "hide" ),
				 "description" => __("Select to show or hide image."),
				 "admin_label" => True
			),
			array(
				 "type" => "textfield",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Text for Button"),
				 "param_name" => "buttontext",
				 "value" => __(""),
				 "description" => __("Enter the text for the button below the excerpt. If you don't want a button, leave this field blank."),
				 "admin_label" => True
			)
		)
	)	);
	//end vc_map Single Post
	

	vc_map( array(
	   "name" => __("Widget"),
	   "base" => "widgets_on_pages",
	   "class" => "",
	   "icon" => "icon-wpb-widget",
	   "category" => __('Content'),
	   "params" => array(
			array(
				 "type" => "textfield",
				 "holder" => "div",
				 "class" => "",
				 "heading" => __("Widget ID"),
				 "param_name" => "id",
				 "value" => __(""),
				 "description" => __("Enter the ID of the widget to display."),
				 "admin_label" => True
			),
		)
	)	);
	//end vc_map Widget
	
	

	vc_map( array(
	   "name" => __("Directions To Tekserve"),
	   "base" => "get_to_tekserve",
	   "class" => "",
	   "show_settings_on_create" => false,
	   "icon" => "icon-wpb-map",
	   "category" => __('Content'),
	) );
	//end vc_map Directions To Tekserve
	
	
	vc_map( array(
	   "name" => __("Drawer with Directions to Tekserve"),
	   "base" => "get_to_tekserve_drawer",
	   "class" => "",
	   "show_settings_on_create" => false,
	   "icon" => "icon-wpb-map-drawer",
	   "category" => __('Content')
	) );
	//end vc_map Drawer with Directions to Tekserve

}	//end if( function_exists( 'vc_map' ) )





/*** Remove unneccesary default buttons from visual editor ***/

if( function_exists( 'vc_remove_element' ) ) {
	vc_remove_element( "vc_facebook" );
	vc_remove_element( "vc_tweetmeme" );
	vc_remove_element( "vc_googleplus" );
	vc_remove_element( "vc_pinterest" );
	vc_remove_element( "vc_toggle" );
	vc_remove_element( "vc_tour" );
	vc_remove_element( "vc_posts_slider" );
	vc_remove_element( "vc_widget_sidebar" );
	vc_remove_element( "vc_button" );
	vc_remove_element( "vc_cta_button" );
	vc_remove_element( "vc_flickr" );
	vc_remove_element( "vc_pie" );
	vc_remove_element( "vc_wp_recentcomments" );
	vc_remove_element( "vc_wp_pages" );
	vc_remove_element( "vc_wp_custommenu" );
	vc_remove_element( "vc_wp_text" );
	vc_remove_element( "vc_wp_links" );
	vc_remove_element( "vc_wp_rss" );
	vc_remove_element( "vc_progress_bar" );
	vc_remove_element( "vc_wp_search" );
	vc_remove_element( "vc_wp_meta" );
	vc_remove_element( "vc_wp_calendar" );
	vc_remove_element( "vc_wp_posts" );

}	//end if( function_exists( 'vc_remove_element' ) )
