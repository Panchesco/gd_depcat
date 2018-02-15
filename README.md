# Dependent Category

EE3 plugin for displaying categories assigned to entries also assigned to another category

For example: When entries with a category of "Photograph" are displayed, we also want to list categories from another category group assigned to the current list eg. Black & White, Digital, Framed. 


**


## Tag Pairs


### `{exp:gd_depcat:categories}`


#### Parameters

| Parameter | Required? |	Description | Default | Options
| --- | --- | --- | --- | --- |
|	channel |  Yes | Pipe delimited list of channel short names | 	| 	|
|	depcat_group_id |  Yes | Pipe delimited list of dependent category group ids | 	| 	|
|	parent |  No | Pipe delimited list of category_ids | 	| 	|
| status | No | Pipe delimeted list of entry statuses | open |
|	orderby |  No | Display order of results | category_order	| category_order, category_name	|
|	sort |  No | Sort order for results | DESC	| DESC, ASC	|


#### Template Variables

{category_group_id}<br>
{channel_title}<br>
{category_url_title}<br>
{category_name}<br>
{category_order}<br>
{category_id}<br>

#### Example Usage

```
{exp:gd_depcat:categories
  channel="gallery|archive"
  parent="42"
  depcat_group_id="2"
  status="open|archived"}
  {if count=="1}
  <nav>
    <ul>
  {/if}
  <li><a href="/photgraphs/category/42/dependent/{category_id}">{category_name}</a></li>
  {if count==total_results}
    </ul>
  </nav>
  {/if}
{/exp:gd_depcat:categories}
```

## License

Copyright (C) YYYY.

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL ELLISLAB, INC. BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.