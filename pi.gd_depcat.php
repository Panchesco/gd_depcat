<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	
Copyright (C) YYYY  

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
ELLISLAB, INC. BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.


*/

/**
 * Gd_depcat Class
 *
 * @package		ExpressionEngine
 * @category		Plugin
 * @author		  Richard Whitmer/Godat Design
 * @copyright		Copyright (c) YYYY
 * @link			https://github.com/Panchesco/Gd_depcat
 */

class Gd_depcat {

    public $return_data;
    
     /**
      * Constructor
      *
      * @access	public
      * @return	void
      */
    
    function __construct(){}
    
    public function categories() {
      
      $data = array();
      $dependents = array();
      $rows = array();
      
      $explodables = array(
        'channel' => ee()->TMPL->fetch_param('channel',0),
        'parent_category' => ee()->TMPL->fetch_param('parent',FALSE),
        'depcat_group_id' => ee()->TMPL->fetch_param('depcat_group_id','0'),
        'status' => ee()->TMPL->fetch_param('status','open'),
        'depcat_id' => ee()->TMPL->fetch_param('depcat_group_id',0)
      );
      
      $orderby = ee()->TMPL->fetch_param('orderby','category_order');
      $sort = ee()->TMPL->fetch_param('sort','ASC');
      
      foreach($explodables as $key => $row) {

        if($row !== FALSE) 
        {
          ${$key} = explode("|",$row);
          } else {
            ${$key} = $row;
          } 
      }
      
      $sel[] = "channel_titles.entry_id";
      $sel[] = "categories.group_id AS category_group_id";
      $sel[] = "channels.channel_title";
      $sel[] = "categories.cat_url_title AS category_url_title";
      $sel[] = "categories.cat_name AS category_name";
      $sel[] = "categories.cat_order AS category_order";
      $sel[] = "category_posts.cat_id AS category_id";
      
      $parents = ($parent_category !== FALSE ) ? $this->category_posts($parent_category) : FALSE;
      
      ee()->db->select($sel);
      ee()->db->from("category_posts");
      ee()->db->join("categories", "categories.cat_id = category_posts.cat_id","left");
      ee()->db->join("channel_titles", "channel_titles.entry_id = category_posts.entry_id","left");
      ee()->db->join("channels", "channels.channel_id = channel_titles.channel_id","left");
      ee()->db->where_in("channels.channel_name",$channel);
      ee()->db->where_in("categories.group_id",$depcat_group_id);
      ee()->db->where_in('channel_titles.status',$status);
      ee()->db->order_by($orderby);
      
      $query = ee()->db->get();
      $result = $query->result();
      
      foreach($result as $key => $row) 
      {
          
          if( $parents !== FALSE)
          {
            if( in_array($row->entry_id,$parents)) 
            {
              
              if( ! in_array($row->category_id,$dependents)) 
              {
                $data[] = (array) $row;
              }
              
              $dependents[$row->category_id] = $row->category_id;
            } 
          
          } else {
            
            if( ! in_array($row->category_id,$dependents)) 
              {
                $data[] = (array) $row;
              }
              
              $dependents[$row->category_id] = $row->category_id;
          }
      }

      if( count($data) == 0) 
      {
        return ee()->TMPL->no_results();
        } else {
        return ee()->TMPL->parse_variables(ee()->TMPL->tagdata,$data);
      }

    }
    
    /**
     * Return an array of entry_ids for a given category_id.
     * @param $cat_ids array
     * @return array
     */
    private function category_posts($cat_ids) {

      $data = array();
      
      ee()->db->select('entry_id,cat_id');
      ee()->db->where_in('cat_id',$cat_ids);
      
      $query = ee()->db->get('category_posts');
      $results = $query->result();
      
      foreach($results as $key => $row ) {
        $data[] = $row->entry_id;
      }
    
      return $data;
    }

}
// END CLASS
// EOF
