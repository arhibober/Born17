<?php $index = 0;
	/**
	* The sidebar containing the main widget area
	*
	* If no active widgets are in the sidebar, hide it completely.
	*
	* @package WordPress
	* @subpackage Twenty_Twelve
	* @since Twenty Twelve 1.0
	*/ 

	function subCat3 ($id, &$sql, $root, $blog)
	{
		global $wpdb;
		if ($id != $root)
			$sql .= "or ";
		$sql .= "p.id in(select object_id from wp_".$blog."_term_relationships where term_taxonomy_id=".$id.") ";	
		$sqlstr = "select term_id from wp_".$blog."_term_taxonomy where parent=".$id;
		$children = $wpdb->get_results ($sqlstr, ARRAY_A);
		foreach ($children as $child)
			subCat3 ($child ["term_id"], $sql, $root, $blog);
	}
?>
<div id="secondary" class="widget-area" role="complementary">
<?php $index = 0;
	global $blog_id;		
	global $wpdb;
	if ($blog_id == 1)
	{
		$blog_list = get_blog_list (0, "all"); 		
		$output = ""; 		
		$sqlstr = "";
		$i = 0;		
		$j = 0;		
		$sqlstr = "select blog_id from wp_blogs";
		$blogs = $wpdb->get_results ($sqlstr, ARRAY_A);
		$sqlstr = "";
		foreach ($blogs as $blog)
			if ($blog ["blog_id"] != 1)
			{
				$sqlstr1 = "select term_id from wp_".$blog ["blog_id"]."_terms where name='Поезія'";
				$terms_id = $wpdb->get_results ($sqlstr1, ARRAY_A);
				if ($j > 0)
					$sqlstr .= " union ";
				$sqlstr .= "SELECT b.blog_id, b.path as path, p.id, p.post_date, p.post_modified, p.comment_count as comment_count, o.option_value as value from wp_".$blog ["blog_id"]."_posts as p, wp_".$blog ["blog_id"]."_options as o, wp_blogs as b where p.post_status = 'publish' and b.blog_id=".$blog ["blog_id"]." and (";
				subCat3 ($terms_id [0]["term_id"], $sqlstr, $terms_id [0]["term_id"], $blog ["blog_id"]);
				$sqlstr .= ") and o.option_name='blogname' and b.blog_id!=14 and b.blog_id<18";
				$j++;
			}
		$sqlstr.= " ORDER BY post_date desc";
		$post_list = $wpdb->get_results ($sqlstr, ARRAY_A);
		foreach ($post_list as $post1) 
		{
			$txt = "{title}";
			$p = get_blog_post ($post1 ["blog_id"], $post1["id"]);
			$content = preg_replace ("/<img.+?>/", "", $p->post_content);
			$content = preg_replace ("/<a.+?><\/a>(\n)*/s", "", $content);
			$content = preg_replace ("/(\n)+?/", "<br/>", $content);
			$content = preg_replace ("/(\s)*<br\/>(\s)*((\s)*<br\/>(\s)*)+/", "<br/>", $content);
			$content = preg_replace ("/\[youtube\]http(s)?:\/\/(www\.)?youtube\.com\/watch\?v=(.*?)\[\/youtube\]/", "", $content);
			$content = preg_replace ("/\[embed\]http(s)?:\/\/(www\.)?vimeo\.com\/(.*?)\[\/embed\]/", "", $content);
			$content = preg_replace ("/\[vimeo\]http(s)?:\/\/(www\.)?vimeo\.com\/(.*?)\[\/vimeo\]/", "", $content);
			$content = preg_replace ("/\[embed\]http(s)?:\/\/(www\.)?youtube\.com\/watch\?v=(.*?)\[\/embed\]/", "", $content);
            $content = trim ($content);
			if ((substr ($content, 0, 5) == "<div>") && (substr ($content, strlen ($content) - 6, 6) == "</div>"))
				$content = substr ($content, 5, strlen ($content) - 11);
			$content = trim ($content);
			if (strstr ($content, "<!--more-->"))
				$content = strstr ($content, "<!--more-->", true);
			if (strstr ($content, "<p></p>"))
				$content = strstr ($content, "<p></p>", true);
			if (strstr ($content, "
&nbsp;
"))
			$content = strstr ($content, "
&nbsp;
", true);
			if (strstr ($content, "<br/><br/>"))
				$content = strstr ($content, "<br/><br/>", true);
			if (strstr ($content, "<br/>
<br/>"))
				$content = strstr ($content, "<br/>
<br/>", true);
			if (strstr ($content, "<br></br>
<br></br>"))
				$content = strstr ($content, "<br><br/>
<br><br/>", true);
			if (strstr ($content, "<br></br><br></br>"))
				$content = strstr ($content, "<br><br/><br><br/>", true);
			$preview = preg_split ("/(<br\/>|<br><\/br>)".wp_spaces_regexp ()."(<br\/>|<br><\/br>)/", $content);
			$content = $preview [0];
			$content = closetags ($content);
			if ($post1 ["comment_count"] > 0)
				$txt = str_replace ("{title}", '<div class="poetryname"><a href="'.$post1 ["path"].'">'.$post1 ["value"].'</a></div><h3><a href="' .get_blog_permalink ($post1 ["blog_id"], $post1 ["id"]).'">'.$p->post_title.'</a></h3><div class="poetry">'.$content.'</div><div class="readmore"><a href="' .get_blog_permalink ($post1 ["blog_id"], $post1 ["id"]).'">Читати далі...</a></div><div class="poetrydata">'.mysqli2date ("F j, Y, G:i", $p->post_date).'</div><div class="map-comments"><a href="'.get_blog_permalink ($post1 ["blog_id"], $post1["id"]).'#comments">Коментарі ('.$post1 ["comment_count"].')</a></div>', $txt);
			else
				$txt = str_replace ("{title}", '<div class="poetryname"><a href="'.$post1 ["path"].'">'.$post1 ["value"].'</a></div><h3><a href="' .get_blog_permalink ($post1 ["blog_id"], $post1 ["id"]).'">'.$p->post_title.'</a></h3><div class="poetry">'.$content.'</div><div class="readmore"><a href="' .get_blog_permalink ($post1 ["blog_id"], $post1 ["id"]).'">Читати далі...</a></div><div class="poetrydata">'.mysqli2date ("F j, Y, G:i", $p->post_date)."</div>", $txt);
			$output .=  $txt."<br/>";
			$i++;
			if ($i > 4)
				break;
		}		
		$output .=  $wpdb->print_error();
		echo "<h3 class='widget-title'>Нові твори на рівноденні</h3>".$output."<br/>
		<a href='/zagalna-strichka-postiv/' id='lbl'>Стрічка віршів</a>";
	}
	else
	{
		$sqlstr = "select term_id from wp_".$blog_id."_terms where slug='obrazotvorche-mystetstvo' and term_id in(select term_taxonomy_id from wp_".$blog_id."_term_relationships where object_id in(select id from wp_".$blog_id."_posts where post_name='".substr (strrchr (substr ($_SERVER ["REQUEST_URI"], 0, strlen ($_SERVER ["REQUEST_URI"]) - 1), "/"), 1, strlen (strrchr (substr ($_SERVER ["REQUEST_URI"], 0, strlen ($_SERVER ["REQUEST_URI"]) - 1), "/")) - 1)."'))";
		$term_id = $wpdb->get_results ($sqlstr, ARRAY_A);
		if ($blog_id != 14)
		{
			$sqlstr = "select path from wp_blogs where blog_id=".$blog_id;
			$paths = $wpdb->get_results ($sqlstr, ARRAY_A);
			if (((strstr ($_SERVER ["REQUEST_URI"], "/category/obrazotvorche-mystetstvo/"))) || (count ($term_id) > 0))
			{
				$sqlstr = "select path from wp_blogs where blog_id=".$blog_id;
				$paths = $wpdb->get_results ($sqlstr, ARRAY_A);
				echo "<a href='".$paths [0]["path"]."category/obrazotvorche-mystetstvo'><h2>Альбоми</h2></a>";
				$sqlstr = "select id, post_name, post_content, post_title from wp_".$blog_id."_posts where id in(select object_id from wp_".$blog_id."_term_relationships where term_taxonomy_id in(select term_id from wp_".$blog_id."_terms where slug='obrazotvorche-mystetstvo')) and post_status='publish'";
				$posts = $wpdb->get_results ($sqlstr, ARRAY_A);
				foreach ($posts as $post)
				{
					if (strstr ($post ["post_content"], ","))
						$first_image = strstr (substr (strstr ($post ["post_content"], "ids=\""), 5, strlen (strstr ($post ["post_content"], "ids=\"")) - 5), ",", true);
					else
						$first_image = strstr (substr (strstr ($post ["post_content"], "ids=\""), 5, strlen (strstr ($post ["post_content"], "ids=\"")) - 5), "\"", true);
					$sqlstr = "select guid from wp_".$blog_id."_posts where id=".$first_image;
					$guids = $wpdb->get_results ($sqlstr, ARRAY_A);
					if (strstr ($guids [0]["guid"], "?attachment_id="))
					{
						$sqlstr = "select meta_value from wp_".$blog_id."_postmeta where post_id=".$first_image." and meta_key='_wp_attached_file'";
						$iae = $wpdb->get_results ($sqlstr, ARRAY_A);
						$ia = $paths [0]["path"]."wp-content/uploads/sites/".$blog_id."/".$iae [0]["meta_value"];
					}
					else
						if (strstr ($guids [0]["guid"], "http://rivnodennya"))
							$ia = substr ($guids [0]["guid"], 25, strlen ($guids [0]["guid"]) - 25);
						else
							$ia = $guids [0]["guid"];
						if (file_exists (substr ($ia, strlen ($paths [0]["path"]), strlen ($ia) - strlen (strrchr ($ia, ".")) - strlen ($paths [0]["path"]))."-150x150".strrchr ($ia, ".")))
							echo "<div class='album_avatars'>
								<a href='".$paths [0]["path"].$post ["post_name"]."'>
									<img src='".substr ($ia, 0, strlen ($ia) - strlen (strrchr ($ia, ".")))."-150x150".strrchr ($ia, ".")."'/>
									<div id='album-title'>
										".$post ["post_title"]."
									</div>
								</a>
								</div>";
						else
						{
							$dir = opendir (substr ($ia, strlen ($paths [0]["path"]), strlen ($ia) - strlen (strrchr ($ia, "/")) - strlen ($paths [0]["path"])));
							while ($file = readdir ($dir))
							{
								if ((substr ($file, 0, strlen ($file) - strlen (strrchr ($file, "-"))) == substr (strrchr ($ia, "/"), 1, strlen (strrchr ($ia, "/")) - strlen (strrchr ($ia, ".")) - 1)) && ((strstr (strrchr ($file, "-"), "x", true) == "-150") || (strstr (strrchr ($file, "x"), ".", true) == "x150") || ((strstr (substr (strrchr ($file, "-"), 1, strlen (strrchr ($file, "-")) - 1), "x", true) < 150) && (strstr (substr (strrchr ($file, "x"), 1, strlen (strrchr ($file, "x")) - 1), ".", true) < 150))))
									echo "<div class='album_avatars'>
										<a href='".$paths [0]["path"].$post ["post_name"]."'>
											<img src='".substr ($ia, strlen ($paths [0]["path"]) - 1, strlen ($ia) - strlen (strrchr ($ia, "/")) - strlen ($paths [0]["path"]) + 2).$file."'/>
											<div id='album-title'>
												".$post ["post_title"]."
											</div>
										</a>
									</div>";
							}
						}
				}
			}
			else
			{
				$sqlstr = "select term_id from wp_".$blog_id."_terms where slug='moyi-svitlyny' and term_id in(select term_taxonomy_id from wp_".$blog_id."_term_relationships where object_id in(select id from wp_".$blog_id."_posts where post_name='".substr (strrchr (substr ($_SERVER["REQUEST_URI"], 0, strlen ($_SERVER["REQUEST_URI"]) - 1), "/"), 1, strlen (strrchr (substr ($_SERVER["REQUEST_URI"], 0, strlen ($_SERVER["REQUEST_URI"]) - 1), "/")) - 1)."'))";
				$term_id = $wpdb->get_results($sqlstr, ARRAY_A);
				if ((strstr ($_SERVER ["REQUEST_URI"], "/category/moyi-svitlyny/")) || (count ($term_id) > 0))
				{
					echo "<a href='".$paths [0]["path"]."category/moyi-svitlyny'><h2>Альбоми</h2></a>";
					$sqlstr = "select id, post_name, post_content, post_title from wp_".$blog_id."_posts where id in(select object_id from wp_".$blog_id."_term_relationships where term_taxonomy_id in(select term_id from wp_".$blog_id."_terms where slug='moyi-svitlyny')) and post_status='publish'";
					$posts = $wpdb->get_results ($sqlstr, ARRAY_A);
					foreach ($posts as $post)
					{
						if (strstr ($post ["post_content"], ","))
							$first_image = strstr (substr (strstr ($post ["post_content"], "ids=\""), 5, strlen (strstr ($post ["post_content"], "ids=\"")) - 5), ",", true);
						else
							$first_image = strstr (substr (strstr ($post ["post_content"], "ids=\""), 5, strlen (strstr ($post ["post_content"], "ids=\"")) - 5), "\"", true);
						$sqlstr = "select guid from wp_".$blog_id."_posts where id=".$first_image;
						$guids = $wpdb->get_results ($sqlstr, ARRAY_A);
						$sqlstr = "select guid from wp_".$blog_id."_posts where id=".$first_image;
						$guids = $wpdb->get_results ($sqlstr, ARRAY_A);
						if (strstr ($guids [0]["guid"], "?attachment_id="))
						{
							$sqlstr = "select meta_value from wp_".$blog_id."_postmeta where post_id=".$first_image." and meta_key='_wp_attached_file'";
							$iae = $wpdb->get_results ($sqlstr, ARRAY_A);
							$ia = $paths [0]["path"]."wp-content/uploads/sites/".$blog_id."/".$iae [0]["meta_value"];
						}
						else
							if (strstr ($guids [0]["guid"], "http://rivnodennya"))
								$ia = substr ($guids [0]["guid"], 25, strlen ($guids [0]["guid"]) - 25);
							else
								$ia = $guids [0]["guid"];
						if (file_exists (substr ($ia, strlen ($paths [0]["path"]), strlen ($ia) - strlen (strrchr ($ia, ".")) - strlen ($paths [0]["path"]))."-150x150".strrchr ($ia, ".")))
							echo "<div class='album_avatars'>
								<a href='".$paths [0]["path"].$post ["post_name"]."'>
									<img src='".substr ($ia, 0, strlen ($ia) - strlen (strrchr ($ia, ".")))."-150x150".strrchr ($ia, ".")."'/>
									<div id='album-title'>
										".$post ["post_title"]."
									</div>
								</a>
							</div>";
						else
						{
							$dir = opendir (substr ($ia, strlen ($paths [0]["path"]), strlen ($ia) - strlen (strrchr ($ia, "/")) - strlen ($paths [0]["path"])));
							while ($file = readdir ($dir))
							{
								if ((substr ($file, 0, strlen ($file) - strlen (strrchr ($file, "-"))) == substr (strrchr ($ia, "/"), 1, strlen (strrchr ($ia, "/")) - strlen (strrchr ($ia, ".")) - 1)) && ((strstr (strrchr ($file, "-"), "x", true) == "-150") || (strstr (strrchr ($file, "x"), ".", true) == "x150") || ((strstr (substr (strrchr ($file, "-"), 1, strlen (strrchr ($file, "-")) - 1), "x", true) < 150) && (strstr (substr (strrchr ($file, "x"), 1, strlen (strrchr ($file, "x")) - 1), ".", true) < 150))))
									echo "<div class='album_avatars'>
										<a href='".$paths [0]["path"].$post ["post_name"]."'>
											<img src='".substr ($ia, strlen ($paths [0]["path"]) - 1, strlen ($ia) - strlen (strrchr ($ia, "/")) - strlen ($paths [0]["path"]) + 2).$file."'/>
											<div id='album-title'>
												".$post ["post_title"]."
											</div>
										</a>
									</div>";
							}
						}
					}
				}
				else
				{
					if (((substr_count ($_SERVER ["REQUEST_URI"], "/") == 4) || (substr_count ($_SERVER ["REQUEST_URI"], "/") == 7)) && ((!strstr ($_SERVER ["REQUEST_URI"], $paths [0]["path"]."category/")) || (strstr ($_SERVER ["REQUEST_URI"], $paths [0]["path"].substr ($paths [0]["path"], 1, strlen ($paths [0]["path"]) - 1)."category/"))) && ((!strstr ($_SERVER ["REQUEST_URI"], $paths [0]["path"]."page/")) || (strstr ($_SERVER ["REQUEST_URI"], $paths [0]["path"].substr ($paths [0]["path"], 1, strlen ($paths [0]["path"]) - 1)."page/"))))
					{
						$sqlstr = "select id, post_name, post_title, post_content from wp_".$blog_id."_posts where post_name='".substr (strrchr (substr ($_SERVER["REQUEST_URI"], 0, strlen ($_SERVER ["REQUEST_URI"]) - strlen (strrchr (substr ($_SERVER ["REQUEST_URI"], 0, strlen ($_SERVER ["REQUEST_URI"]) - 1), "/")) - 1), "/"), 1, strlen (strrchr (substr ($_SERVER ["REQUEST_URI"], 0, strlen ($_SERVER ["REQUEST_URI"]) - strlen (strrchr (substr ($_SERVER ["REQUEST_URI"], 0, strlen ($_SERVER ["REQUEST_URI"]) - 1), "/")) - 1), "/")) - 1)."'";
						$posts = $wpdb->get_results ($sqlstr, ARRAY_A);
						foreach ($posts as $post)
						{
							echo "<h2><a href='".$paths [0]["path"].$post ["post_name"]."'>".$post ["post_title"]."</a></h2><br/>";
							$images = explode (",", substr (strstr (strstr ($post ["post_content"], "\"]", true), "[gallery ids="), 14, strlen (strstr (strstr ($post ["post_content"], "\"]", true), "[gallery ids=")) - 14));
							foreach ($images as $image)
							{	
								$sqlstr = "select id, guid, post_excerpt, post_name from wp_".$blog_id."_posts where id=".$image;
								$image_data = $wpdb->get_results ($sqlstr, ARRAY_A);
								if (strstr ($image_data [0]["guid"], "?attachment_id="))
								{
									$sqlstr = "select meta_value from wp_".$blog_id."_postmeta where post_id=".$image." and meta_key='_wp_attached_file'";
									$iae = $wpdb->get_results ($sqlstr, ARRAY_A);
									$ia = $paths [0]["path"]."wp-content/uploads/sites/".$blog_id."/".$iae [0]["meta_value"];
								}
								else
									if (strstr ($image_data [0]["guid"], "http://rivnodennya"))
										$ia = substr ($image_data [0]["guid"], 25, strlen ($image_data [0]["guid"]) - 25);
									else
										$ia = $image_data [0]["guid"];
								if (file_exists (substr ($ia, strlen ($paths [0]["path"]), strlen ($ia) - strlen (strrchr ($ia, ".")) - strlen ($paths [0]["path"]))."-150x150".strrchr ($ia, ".")))
									echo "<div class='album_avatars'>
										<a href='".$paths [0]["path"].$post ["post_name"]."/".$image_data [0]["post_name"]."#begin-".$image_data [0]["id"]."'>
											<img src='".substr ($ia, 0, strlen ($ia) - strlen (strrchr ($ia, ".")))."-150x150".strrchr ($ia, ".")."'/>
											<div id='album-title'>
												".$image_data [0]["post_excerpt"]."
											</div>
										</a>
									</div>";
								else
								{
									$dir = opendir (substr ($ia, strlen ($paths [0]["path"]), strlen ($ia) - strlen (strrchr ($ia, "/")) - strlen ($paths [0]["path"])));
									while ($file = readdir ($dir))
									{
										if ((substr ($file, 0, strlen ($file) - strlen (strrchr ($file, "-"))) == substr (strrchr ($ia, "/"), 1, strlen (strrchr ($ia, "/")) - strlen (strrchr ($ia, ".")) - 1)) && ((strstr (strrchr ($file, "-"), "x", true) == "-150") || (strstr (strrchr ($file, "x"), ".", true) == "x150") || ((strstr (substr (strrchr ($file, "-"), 1, strlen (strrchr ($file, "-")) - 1), "x", true) < 150) && (strstr (substr (strrchr ($file, "x"), 1, strlen (strrchr ($file, "x")) - 1), ".", true) < 150))))
											echo "<div class='album_avatars'>
												<a href='".$paths [0]["path"].$post ["post_name"]."/".$image_data [0]["post_name"]."#begin-".$image_data [0]["id"]."'>
													<img src='".substr ($ia, strlen ($paths [0]["path"]) - 1, strlen ($ia) - strlen (strrchr ($ia, "/")) - strlen ($paths [0]["path"]) + 2).$file."'/>
													<div id='album-title'>
														".$image_data [0]["post_excerpt"]."
													</div>
												</a>
											</div>";
									}
								}
							}
						}
					}
					else
						if (strstr ($_SERVER ["REQUEST_URI"], "/attachment_id="))
						{
							$sqlstr = "select id, post_name, post_title, post_content from wp_".$blog_id."_posts where post_content like '%[gallery%' and post_status='publish'";
							$posts2 = $wpdb->get_results ($sqlstr, ARRAY_A);
							foreach ($posts2 as $post2)
								if ((strstr ($post2 ["post_content"], ",".substr (strstr ($_SERVER ["REQUEST_URI"], "/attachment_id="), 15, strlen (strstr ($_SERVER ["REQUEST_URI"], "/attachment_id=")) - 15).",")) || (strstr ($post2 ["post_content"], "\"".substr (strstr ($_SERVER ["REQUEST_URI"], "/attachment_id="), 15, strlen (strstr ($_SERVER ["REQUEST_URI"], "/attachment_id=")) - 15).",")) || (strstr ($post2 ["post_content"], ",".substr (strstr ($_SERVER ["REQUEST_URI"], "/attachment_id="), 15, strlen (strstr ($_SERVER ["REQUEST_URI"], "/attachment_id=")) - 15)."\"")) || (strstr ($post2 ["post_content"], "\"".substr (strstr ($_SERVER ["REQUEST_URI"], "/attachment_id="), 15, strlen (strstr ($_SERVER ["REQUEST_URI"], "/attachment_id=")) - 15)."\"")))
								{
									echo "<h2><a href='".$paths [0]["path"].$post2 ["post_name"]."'>".$post2 ["post_title"]."</a></h2><br/>";
									$images = explode (",", substr (strstr (strstr ($post2 ["post_content"], "\"]", true), "[gallery ids="), 14, strlen (strstr (strstr ($post ["post_content"], "\"]", true), "[gallery ids=")) - 14));
									foreach ($images as $image)
									{
										$sqlstr = "select id, guid, post_excerpt, post_name from wp_".$blog_id."_posts where id=".$image;
										$image_data = $wpdb->get_results($sqlstr, ARRAY_A);
										$sqlstr = "select guid from wp_".$blog_id."_posts where id=".$image;
										$guids = $wpdb->get_results ($sqlstr, ARRAY_A);
										if (strstr ($guids [0]["guid"], "?attachment_id="))
										{
											$sqlstr = "select meta_value from wp_".$blog_id."_postmeta where post_id=".$image." and meta_key='_wp_attached_file'";
											$iae = $wpdb->get_results ($sqlstr, ARRAY_A);
											$ia = $paths [0]["path"]."wp-content/uploads/sites/".$blog_id."/".$iae [0]["meta_value"];
										}
										else
											if (strstr ($image_data [0]["guid"], "http://rivnodennya"))
												$ia = substr ($image_data [0]["guid"], 25, strlen ($image_data [0]["guid"]) - 25);
											else
												$ia = $image_data [0]["guid"];
										if (file_exists (substr ($ia, strlen ($paths [0]["path"]), strlen ($ia) - strlen (strrchr ($ia, ".")) - strlen ($paths [0]["path"]))."-150x150".strrchr ($ia, ".")))
											echo "<div class='album_avatars'>
												<a href='".$paths [0]["path"]."/attachment_id=".$image."#begin-".$image."'>
													<img src='".substr ($ia, 0, strlen ($ia) - strlen (strrchr ($ia, ".")))."-150x150".strrchr ($ia, ".")."'/>
													<div id='album-title'>
														".$image_data [0]["post_excerpt"]."
													</div>
												</a>
											</div>";
										else
										{
											$dir = opendir (substr ($ia, strlen ($paths [0]["path"]), strlen ($ia) - strlen (strrchr ($ia, "/")) - strlen ($paths [0]["path"])));
											while ($file = readdir ($dir))
											{
												if ((substr ($file, 0, strlen ($file) - strlen (strrchr ($file, "-"))) == substr (strrchr ($ia, "/"), 1, strlen (strrchr ($ia, "/")) - strlen (strrchr ($ia, ".")) - 1)) && ((strstr (strrchr ($file, "-"), "x", true) == "-150") || (strstr (strrchr ($file, "x"), ".", true) == "x150") || ((strstr (substr (strrchr ($file, "-"), 1, strlen (strrchr ($file, "-")) - 1), "x", true) < 150) && (strstr (substr (strrchr ($file, "x"), 1, strlen (strrchr ($file, "x")) - 1), ".", true) < 150))))
													echo "<div class='album_avatars'>
														<a href='".$paths [0]["paths"]."/attachment_id=".$image."#begin-".$image."'>
															<img src='".substr ($ia, strlen ($path [0]["path"]) - 1, strlen ($ia) - strlen (strrchr ($ia, "/")) - strlen ($path [0]["path"]) + 2).$file."'/>
															<div id='album-title'>
																".$image_data [0]["post_excerpt"]."
															</div>
														</a>
													</div>";
											}
										}
									}
									echo "</div>";
								}
						}
						else
							if ((substr_count ($_SERVER ["REQUEST_URI"], "/") == 2) || ((substr_count ($_SERVER ["REQUEST_URI"], "/") == 4) && (strstr ($_SERVER ["REQUEST_URI"], "/page/") && (!strstr ($_SERVER ["REQUEST_URI"], "/category/page/")))))
							{
								echo "<h4><a href='".$paths [0]["path"]."'>Переглянути всі вірші автора (за датою)</a></h4><br/>
								<h4><a href='".$paths [0]["path"]."?sort=abc'>Переглянути всі вірші автора (за абеткою)</a></h4>";
								$sqlstr = "select term_id from wp_".$blog_id."_terms where slug='poeziya'";
								$cat = $wpdb->get_results($sqlstr, ARRAY_A);
								bypassCategory ($cat [0]["term_id"]);
							}
							else
								if (substr_count ($_SERVER ["REQUEST_URI"], "/") == 3)
								{
									$sqlstr = "select term_taxonomy_id from wp_".$blog_id."_term_relationships where object_id in(select id from wp_".$blog_id."_posts where post_name='".substr (strrchr (substr ($_SERVER ["REQUEST_URI"], 0, strlen ($_SERVER ["REQUEST_URI"]) - strlen (strrchr ($_SERVER ["REQUEST_URI"], "/"))), "/"), 1, strlen (strrchr (substr ($_SERVER ["REQUEST_URI"], 0, strlen ($_SERVER ["REQUEST_URI"]) - strlen (strrchr ($_SERVER ["REQUEST_URI"], "/"))), "/")) - 1)."')";
									$cats = $wpdb->get_results($sqlstr, ARRAY_A);
									if (count ($cats) > 0)
									{
										$sqlstr = "select parent from wp_".$blog_id."_term_taxonomy where term_taxonomy_id=".$cats [0]["term_taxonomy_id"];
										$parents = $wpdb->get_results($sqlstr, ARRAY_A);
										if ($parents [0]["parent"] == 0)
											$root_cat = $cats [0]["term_taxonomy_id"];
										else
											while ($parents [0]["parent"] > 0)
											{
												$root_cat = $parents [0]["parent"];
												$sqlstr = "select parent from wp_".$blog_id."_term_taxonomy where term_taxonomy_id=".$parents [0]["parent"];
												$parents = $wpdb->get_results($sqlstr, ARRAY_A);
											}
										$sqlstr = "select slug from wp_".$blog_id."_terms where term_id=".$root_cat;
										$slugs = $wpdb->get_results($sqlstr, ARRAY_A);
										if ($slugs [0]["slug"] == "poeziya")			
											echo "<h4><a href='".$paths [0]["path"]."'>Переглянути всі вірші автора (за датою)</a></h4><br/>
											<h4><a href='".$paths [0]["path"]."?sort=abc'>Переглянути всі вірші автора (за абеткою)</a></h4>";
										bypassCategory ($root_cat);
									}
								}
								else
									if (strstr ($_SERVER ["REQUEST_URI"], "/category/"))
									{
										$sqlstr = "select term_id from wp_".$blog_id."_terms where slug='".strstr (substr (strstr ($_SERVER ["REQUEST_URI"], "/category/"), 10, strlen (strstr ($_SERVER ["REQUEST_URI"], "/category/")) - 10), "/", true)."'";
										$cats = $wpdb->get_results ($sqlstr, ARRAY_A);
										if (count ($cats) > 0)
										{
											echo "<style>";
											$sqlstr = "select parent from wp_".$blog_id."_term_taxonomy where term_id=".$cats [0]["term_id"];
											$parents = $wpdb->get_results ($sqlstr, ARRAY_A);
											if ($parents [0]["parent"] == 0)
												$root_cat = $cats [0]["term_id"];
											else
												while ($parents [0]["parent"] > 0)
												{
													$sqlstr = "select slug from wp_".$blog_id."_terms where term_id=".$parents [0]["parent"];
													$slugs = $wpdb->get_results ($sqlstr, ARRAY_A);
													echo "#secondary h3 a[href=\"".$paths [0]["path"]."category/".$slugs [0]["slug"]."\"]
														{
															color: #FFFDDC;
														}";
													$root_cat = $parents [0]["parent"];
													$sqlstr = "select parent from wp_".$blog_id."_term_taxonomy where term_id=".$parents [0]["parent"];
													$parents = $wpdb->get_results ($sqlstr, ARRAY_A);
												}
											$sqlstr = "select slug from wp_".$blog_id."_terms where term_id=".$root_cat;
											$slugs = $wpdb->get_results ($sqlstr, ARRAY_A);					
											echo "#top_sidebar a[href=\"http://rivnodennya.esy.es".$paths [0]["path"]."category/".$slugs [0]["slug"]."/\"]
												{	
													background: #D9B66D;
													transition: all 1s linear;
												}
												#top_sidebar a[href=\"".$paths [0]["path"]."category/".$slugs [0]["slug"]."/\"]
												{	
													background: #D9B66D;
													transition: all 1s linear;
												}
												@media screen and (max-width: 600px)
												{
													#top_sidebar a[href=\"http://rivnodennya.esy.es".$paths [0]["path"]."category/".$slugs [0]["slug"]."/\"]
													{
														background: none;
														color: #84469F !important;
														transition: all 1s linear;
													}
													#top_sidebar a[href=\"".$paths [0]["path"]."category/".$slugs [0]["slug"]."/\"]
													{
														background: none;
														color: #84469F !important;
														transition: all 1s linear;
													}
												}
												</style>";
											if ($slugs [0]["slug"] == "poeziya")			
												echo "<h4><a href='".$paths [0]["path"]."'>Переглянути всі вірші автора (за датою)</a></h4><br/>
												<h4><a href='".$paths [0]["path"]."?sort=abc'>Переглянути всі вірші автора (за абеткою)</a></h4>";
											bypassCategory ($root_cat);
										}
									}
				}
			}
		}
		else
		{
			$poet = 0;
			if ($_GET ["autor"] != "")
				$poet = $_GET ["autor"];
			else
			{
				if ((substr_count ($_SERVER ["REQUEST_URI"], "/") == 3) && (!strstr ($_SERVER ["REQUEST_URI"], "/attachment_id=")))
				{
					$sqlstr2 = "select term_id from wp_14_term_taxonomy where parent=4 and term_id in(select term_taxonomy_id from wp_14_term_relationships id where object_id in(select id from wp_14_posts where post_name='".substr (strrchr (substr ($_SERVER["REQUEST_URI"], 0, strlen ($_SERVER["REQUEST_URI"]) - 1), "/"), 1, strlen (strrchr (substr ($_SERVER["REQUEST_URI"], 0, strlen ($_SERVER["REQUEST_URI"]) - 1), "/")) - 1)."'))";
					$poets = $wpdb->get_results($sqlstr2, ARRAY_A);
				}
				else
					if ((substr_count ($_SERVER ["REQUEST_URI"], "/") == 4) || (substr_count ($_SERVER ["REQUEST_URI"], "/") == 7))
					{					
						$sqlstr2 = "select term_id from wp_14_term_taxonomy where parent=4 and term_id in(select term_taxonomy_id from wp_14_term_relationships id where object_id in(select id from wp_14_posts where post_name='".substr (strrchr (substr ($_SERVER ["REQUEST_URI"], 0, strlen ($_SERVER ["REQUEST_URI"]) - strlen (strrchr (substr ($_SERVER ["REQUEST_URI"], 0, strlen ($_SERVER ["REQUEST_URI"]) - 1), "/")) - 1), "/"), 1, strlen (strrchr (substr ($_SERVER ["REQUEST_URI"], 0, strlen ($_SERVER["REQUEST_URI"]) - strlen (strrchr (substr ($_SERVER ["REQUEST_URI"], 0, strlen ($_SERVER ["REQUEST_URI"]) - 1), "/")) - 1), "/")) - 1)."'))";
						$poets = $wpdb->get_results ($sqlstr2, ARRAY_A);
					}
					else
						if (strstr ($_SERVER ["REQUEST_URI"], "/attachment_id="))
						{
							$sqlstr = "select id, post_content from wp_14_posts where post_content like '%[gallery%' and post_status='publish'";
							$posts2 = $wpdb->get_results ($sqlstr, ARRAY_A);
							foreach ($posts2 as $post2)
								if ((strstr ($post2 ["post_content"], ",".substr (strstr ($_SERVER ["REQUEST_URI"], "/attachment_id="), 15, strlen (strstr ($_SERVER ["REQUEST_URI"], "/attachment_id=")) - 15).",")) || (strstr ($post2 ["post_content"], "\"".substr (strstr ($_SERVER ["REQUEST_URI"], "/attachment_id="), 15, strlen (strstr ($_SERVER ["REQUEST_URI"], "attachment_id")) - 15).",")) || (strstr ($post2 ["post_content"], ",".substr (strstr ($_SERVER ["REQUEST_URI"], "/attachment_id="), 15, strlen (strstr ($_SERVER ["REQUEST_URI"], "/attachment_id=")) - 15)."\"")) || (strstr ($post2 ["post_content"], "\"".substr (strstr ($_SERVER ["REQUEST_URI"], "/attachment_id="), 15, strlen (strstr ($_SERVER ["REQUEST_URI"], "/=attachment_id")) - 15)."\"")))
								{
									$sqlstr2 = "select term_id from wp_14_term_taxonomy where parent=4 and term_id in(select term_taxonomy_id from wp_14_term_relationships id where object_id='".$post2 ["id"]."')";
									$poets = $wpdb->get_results ($sqlstr2, ARRAY_A);
								}
						}					
				$poet = $poets [0]["term_id"];
			}
			if ($poet > 0)
			{
				global $wpdb;
				$sqlstr = "select term_id from wp_14_terms where slug='obrazotvorche-mystetstvo' and term_id in(select term_taxonomy_id from wp_14_term_relationships where object_id in(select id from wp_14_posts where post_name='".substr (strrchr (substr ($_SERVER ["REQUEST_URI"], 0, strlen ($_SERVER["REQUEST_URI"]) - 1), "/"), 1, strlen (strrchr (substr ($_SERVER ["REQUEST_URI"], 0, strlen ($_SERVER ["REQUEST_URI"]) - 1), "/")) - 1)."'))";
				$term_id = $wpdb->get_results ($sqlstr, ARRAY_A);
				if ((strstr ($_SERVER ["REQUEST_URI"], "/category/obrazotvorche-mystetstvo/")) || (count ($term_id) > 0))
				{
					echo "<a href='/teachers/category/obrazotvorche-mystetstvo/?autor=".$poet."'><h2>Альбоми</h2>";
					$sqlstr = "select path from wp_blogs where blog_id=".$blog_id;
					$paths = $wpdb->get_results ($sqlstr, ARRAY_A);
					$sqlstr = "select id, post_name, post_content, post_title from wp_14_posts where id in(select object_id from wp_14_term_relationships where term_taxonomy_id in(select term_id from wp_14_terms where slug='obrazotvorche-mystetstvo')) and id in(select object_id from wp_14_term_relationships where term_taxonomy_id=".$poet.") and post_status='publish'";
					$posts = $wpdb->get_results ($sqlstr, ARRAY_A);
					foreach ($posts as $post)
					{
						if (strstr ($post ["post_content"], ","))
							$first_image = strstr (substr (strstr ($post ["post_content"], "ids=\""), 5, strlen (strstr ($post ["post_content"], "ids=\"")) - 5), ",", true);
						else
							$first_image = strstr (substr (strstr ($post ["post_content"], "ids=\""), 5, strlen (strstr ($post ["post_content"], "ids=\"")) - 5), "\"", true);
						$sqlstr = "select guid from wp_14_posts where id=".$first_image;
						$guids = $wpdb->get_results ($sqlstr, ARRAY_A);
						if (strstr ($guids [0]["guid"], "?attachment_id="))
						{
							$sqlstr = "select meta_value from wp_14_postmeta where post_id=".$first_image." and meta_key='_wp_attached_file'";
							$iae = $wpdb->get_results ($sqlstr, ARRAY_A);
							$ia = "/teachers/wp-content/uploads/sites/14/".$iae [0]["meta_value"];
						}
						else
							if (strstr ($guids [0]["guid"], "http://rivnodennya"))
								$ia = substr ($guids [0]["guid"], 25, strlen ($guids [0]["guid"]) - 25);
							else
								$ia = $guids [0]["guid"];
						if (file_exists (substr ($ia, 10, strlen ($ia) - strlen 
							(strrchr ($ia, ".")) - 10)."-150x150".strrchr ($ia, ".")))
							echo "<div class='album_avatars'>
								<a href='/teachers/".$post ["post_name"]."'>
									<img src='".substr ($ia, 0, strlen ($ia) - strlen (strrchr ($ia, ".")))."-150x150".strrchr ($ia, ".")."'/>
									<div id='album-title'>
										".$post ["post_title"]."
									</div>
								</a>
								</div>";
						else
						{
							$dir = opendir (substr ($ia, 10, strlen ($ia) - strlen (strrchr ($ia, "/")) - 10));
							while ($file = readdir ($dir))
							{
								if ((substr ($file, 0, strlen ($file) - strlen (strrchr ($file, "-"))) == substr (strrchr ($ia, "/"), 1, strlen (strrchr ($ia, "/")) - strlen (strrchr ($ia, ".")) - 1)) && ((strstr (strrchr ($file, "-"), "x", true) == "-150") || (strstr (strrchr ($file, "x"), ".", true) == "x150") || ((strstr (substr (strrchr ($file, "-"), 1, strlen (strrchr ($file, "-")) - 1), "x", true) < 150) && (strstr (substr (strrchr ($file, "x"), 1, strlen (strrchr ($file, "x")) - 1), ".", true) < 150))))
									echo "<div class='album_avatars'>
										<a href='/teachers/".$post ["post_name"]."'>
											<img src='".substr ($ia, 9, strlen ($ia) - strlen (strrchr ($ia, "/")) - 8).$file."'/>
											<div id='album-title'>
												".$post ["post_title"]."
											</div>
										</a>
										</div>";
							}
						}
					}
				}
				else
				{
					$sqlstr = "select term_id from wp_14_terms where slug='moyi-svitlyny' and term_id in(select term_taxonomy_id from wp_14_term_relationships where object_id in(select id from wp_14_posts where post_name='".substr (strrchr (substr ($_SERVER["REQUEST_URI"], 0, strlen ($_SERVER["REQUEST_URI"]) - 1), "/"), 1, strlen (strrchr (substr ($_SERVER["REQUEST_URI"], 0, strlen ($_SERVER["REQUEST_URI"]) - 1), "/")) - 1)."'))";
					$term_id = $wpdb->get_results ($sqlstr, ARRAY_A);
					if ((strstr ($_SERVER ["REQUEST_URI"], "/category/moyi-svitlyny/")) || (count ($term_id) > 0))
					{
						echo "<a href='/teachers/category/moyi-svitlyny/?autor=".$poet."'><h2>Альбоми</h2>";
						$sqlstr = "select path from wp_blogs where blog_id=".$blog_id;
						$paths = $wpdb->get_results ($sqlstr, ARRAY_A);
						$sqlstr = "select id, post_name, post_content, post_title from wp_14_posts where id in(select object_id from wp_14_term_relationships where term_taxonomy_id in(select term_id from wp_14_terms where slug='moyi-svitlyny')) and id in(select object_id from wp_14_term_relationships where term_taxonomy_id=".$poet.") and post_status='publish'";
						$posts = $wpdb->get_results ($sqlstr, ARRAY_A);
						foreach ($posts as $post)
						{
							if (strstr ($post ["post_content"], ","))
								$first_image = strstr (substr (strstr ($post ["post_content"], "ids=\""), 5, strlen (strstr ($post ["post_content"], "ids=\"")) - 5), ",", true);
							else
								$first_image = strstr (substr (strstr ($post ["post_content"], "ids=\""), 5, strlen (strstr ($post ["post_content"], "ids=\"")) - 5), "\"", true);
							$sqlstr = "select guid from wp_14_posts where id=".$first_image;
							$guids = $wpdb->get_results ($sqlstr, ARRAY_A);
							if (strstr ($guids [0]["guid"], "?attachment_id="))
							{
								$sqlstr = "select meta_value from wp_14_postmeta where post_id=".$first_image." and meta_key='_wp_attached_file'";
								$iae = $wpdb->get_results ($sqlstr, ARRAY_A);
								$ia = "/teachers/wp-content/uploads/sites/14/".$iae [0]["meta_value"];
							}
							else
								if (strstr ($guids [0]["guid"], "http://rivnodennya"))
									$ia = substr ($guids [0]["guid"], 25, strlen ($guids [0]["guid"]) - 25);
								else
									$ia = $guids [0]["guid"];							
							if (file_exists (substr ($ia, 10, strlen ($ia) - strlen 
								(strrchr ($ia, ".")) - 10)."-150x150".strrchr ($ia, ".")))
								echo "<div class='album_avatars'>
									<a href='/teachers/".$post ["post_name"]."'>
										<img src='".substr ($ia, 0, strlen ($ia) - strlen (strrchr ($ia, ".")))."-150x150".strrchr ($ia, ".")."'/>
										<div id='album-title'>
											".$post ["post_title"]."
										</div>
									</a>
									</div>";
							else
							{
								$dir = opendir (substr ($ia, 10, strlen ($ia) - strlen (strrchr ($ia, "/")) - 10));
								while ($file = readdir ($dir))
								{
									if ((substr ($file, 0, strlen ($file) - strlen (strrchr ($file, "-"))) == substr (strrchr ($ia, "/"), 1, strlen (strrchr ($ia, "/")) - strlen (strrchr ($ia, ".")) - 1)) && ((strstr (strrchr ($file, "-"), "x", true) == "-150") || (strstr (strrchr ($file, "x"), ".", true) == "x150") || ((strstr (substr (strrchr ($file, "-"), 1, strlen (strrchr ($file, "-")) - 1), "x", true) < 150) && (strstr (substr (strrchr ($file, "x"), 1, strlen (strrchr ($file, "x")) - 1), ".", true) < 150))))
										echo "<div class='album_avatars'>
											<a href='/teachers/".$post ["post_name"]."'>
												<img src='".substr ($ia, 9, strlen ($ia) - strlen (strrchr ($ia, "/")) - 8).$file."'/>
												<div id='album-title'>
													".$post ["post_title"]."
												</div>
											</a>
											</div>";
								}
							}
						}
					}
					else
					{
						if (((substr_count ($_SERVER ["REQUEST_URI"], "/") == 4) || (substr_count ($_SERVER ["REQUEST_URI"], "/") == 7)) && ($_GET ["autor"] == ""))
						{
							$sqlstr = "select path from wp_blogs where blog_id=".$blog_id;
							$paths = $wpdb->get_results($sqlstr, ARRAY_A);  
							$sqlstr = "select id, post_name, post_title, post_content from wp_14_posts where post_name='".substr (strrchr (substr ($_SERVER["REQUEST_URI"], 0, strlen ($_SERVER ["REQUEST_URI"]) - strlen (strrchr (substr ($_SERVER ["REQUEST_URI"], 0, strlen ($_SERVER ["REQUEST_URI"]) - 1), "/")) - 1), "/"), 1, strlen (strrchr (substr ($_SERVER ["REQUEST_URI"], 0, strlen ($_SERVER ["REQUEST_URI"]) - strlen (strrchr (substr ($_SERVER ["REQUEST_URI"], 0, strlen ($_SERVER ["REQUEST_URI"]) - 1), "/")) - 1), "/")) - 1)."'";
							$posts = $wpdb->get_results ($sqlstr, ARRAY_A);
							foreach ($posts as $post)
							{
								echo "<h2><a href='/teachers/".$post ["post_name"]."'>".$post ["post_title"]."</a></h2><br/>";
								$images = explode (",", substr (strstr (strstr ($post ["post_content"], "\"]", true), "[gallery ids="), 14, strlen (strstr (strstr ($post ["post_content"], "\"]", true), "[gallery ids=")) - 14));
								foreach ($images as $image)
								{
									$sqlstr = "select id, guid, post_excerpt, post_name from wp_".$blog_id."_posts where id=".$image;
									$image_data = $wpdb->get_results ($sqlstr, ARRAY_A);
									if (strstr ($guids [0]["guid"], "?attachment_id="))
									{
										$sqlstr = "select meta_value from wp_14_postmeta where post_id=".$image." and meta_key='_wp_attached_file'";
										$iae = $wpdb->get_results ($sqlstr, ARRAY_A);
										$ia = "/teachers/wp-content/uploads/sites/14/".$iae [0]["meta_value"];
									}
									else
										if (strstr ($image_data [0]["guid"], "http://rivnodennya"))
											$ia = substr ($image_data [0]["guid"], 25, strlen ($image_data [0]["guid"]) - 25);
										else
											$ia = $image_data [0]["guid"];							
									if (file_exists (substr ($ia, 10, strlen ($ia) - strlen 
										(strrchr ($ia, ".")) - 10)."-150x150".strrchr ($ia, ".")))
										echo "<div class='album_avatars'>
											<a href='/teachers/".$post ["post_name"]."/".$image_data [0]["post_name"]."#begin-".$image_data [0]["id"]."'>
												<img src='".substr ($ia, 0, strlen ($ia) - strlen (strrchr ($ia, ".")))."-150x150".strrchr ($ia, ".")."'/>
												<div id='album-title'>
													".$image_data [0]["post_excerpt"]."
												</div>
											</a>
											</div>";
									else
									{
										$dir = opendir (substr ($ia, 10, strlen ($ia) - strlen (strrchr ($ia, "/")) - 10));
										while ($file = readdir ($dir))
										{
											if ((substr ($file, 0, strlen ($file) - strlen (strrchr ($file, "-"))) == substr (strrchr ($ia, "/"), 1, strlen (strrchr ($ia, "/")) - strlen (strrchr ($ia, ".")) - 1)) && ((strstr (strrchr ($file, "-"), "x", true) == "-150") || (strstr (strrchr ($file, "x"), ".", true) == "x150") || ((strstr (substr (strrchr ($file, "-"), 1, strlen (strrchr ($file, "-")) - 1), "x", true) < 150) && (strstr (substr (strrchr ($file, "x"), 1, strlen (strrchr ($file, "x")) - 1), ".", true) < 150))))
												echo "<div class='album_avatars'>
													<a href='/teachers/".$post ["post_name"]."/".$image_data [0]["post_name"]."#begin-".$image_data [0]["id"]."'>
														<img src='".substr ($ia, 9, strlen ($ia) - strlen (strrchr ($ia, "/")) - 8).$file."'/>
														<div id='album-title'>
															".$image_data [0]["post_excerpt"]."
														</div>
													</a>
													</div>";
										}
									}
								}
							}
						}
						else
							if (strstr ($_SERVER ["REQUEST_URI"], "/attachment_id="))
							{
								$sqlstr = "select id, post_name, post_title, post_content from wp_14_posts where post_content like '%[gallery%' and post_status='publish'";
								$posts2 = $wpdb->get_results ($sqlstr, ARRAY_A);
								foreach ($posts2 as $post2)
									if ((strstr ($post2 ["post_content"], ",".substr (strstr ($_SERVER ["REQUEST_URI"], "/attachment_id="), 15, strlen (strstr ($_SERVER ["REQUEST_URI"], "/attachment_id")) - 15).",")) || (strstr ($post2 ["post_content"], "\"".substr (strstr ($_SERVER ["REQUEST_URI"], "/attachment_id="), 15, strlen (strstr ($_SERVER ["REQUEST_URI"], "/attachment_id=")) - 15).",")) || (strstr ($post2 ["post_content"], ",".substr (strstr ($_SERVER ["REQUEST_URI"], "/attachment_id="), 15, strlen (strstr ($_SERVER ["REQUEST_URI"], "/attachment_id=")) - 15)."\"")) || (strstr ($post2 ["post_content"], "\"".substr (strstr ($_SERVER ["REQUEST_URI"], "/attachment_id="), 15, strlen (strstr ($_SERVER ["REQUEST_URI"], "/attachment_id=")) - 15)."\"")))		
									{			
										echo "<h2><a href='/teachers/".$post2 ["post_name"]."'>".$post2 ["post_title"]."</a></h2><br/>";
										$images = explode (",", substr (strstr (strstr ($post2 ["post_content"], "\"]", true), "[gallery ids="), 14, strlen (strstr (strstr ($post ["post_content"], "\"]", true), "[gallery ids=")) - 14));
										foreach ($images as $image)
										{
											$sqlstr = "select guid, post_excerpt from wp_14_posts where id=".$image;
											$image_data = $wpdb->get_results ($sqlstr, ARRAY_A);
											if (strstr ($image_data [0]["guid"], "?attachment_id="))
											{
												$sqlstr = "select meta_value from wp_14_postmeta where post_id=".$image." and meta_key='_wp_attached_file'";
												$iae = $wpdb->get_results ($sqlstr, ARRAY_A);
												$ia = "/teachers/wp-content/uploads/sites/14/".$iae [0]["meta_value"];
											}
											else						
												if (strstr ($image_data [0]["guid"], "http://rivnodennya"))
													$ia = substr ($image_data [0]["guid"], 25, strlen ($image_data [0]["guid"]) - 25);
												else
													$ia = $image_data [0]["guid"];						
											if (file_exists (substr ($ia, 10, strlen ($ia) - strlen 
												(strrchr ($ia, ".")) - 10)."-150x150".strrchr ($ia, ".")))
												echo "<div class='album_avatars'>
													<a href='/teachers/attachment_id=".$image."#begin-".$image."'>
														<img src='".substr ($ia, 0, strlen ($ia) - strlen (strrchr ($ia, ".")))."-150x150".strrchr ($ia, ".")."'/>
														<div id='album-title'>
															".$image_data [0]["post_excerpt"]."
														</div>
													</a>	
													</div>";
											else	
											{
												$dir = opendir (substr ($ia, 10, strlen ($ia) - strlen (strrchr ($ia, "/")) - 10));
												while ($file = readdir ($dir))
												{
													if ((substr ($file, 0, strlen ($file) - strlen (strrchr ($file, "-"))) == substr (strrchr ($ia, "/"), 1, strlen (strrchr ($ia, "/")) - strlen (strrchr ($ia, ".")) - 1)) && ((strstr (strrchr ($file, "-"), "x", true) == "-150") || (strstr (strrchr ($file, "x"), ".", true) == "x150") || ((strstr (substr (strrchr ($file, "-"), 1, strlen (strrchr ($file, "-")) - 1), "x", true) < 150) && (strstr (substr (strrchr ($file, "x"), 1, strlen (strrchr ($file, "x")) - 1), ".", true) < 150))))
														echo "<div class='album_avatars'>
															<a href='/teachers/attachment_id=".$image."#begin-".$image."'>
																<img src='".substr ($ia, 9, strlen ($ia) - strlen (strrchr ($ia, "/")) - 8).$file."'/>
																<div id='album-title'>
																	".$image_data [0]["post_excerpt"]."
																</div>
															</a>
															</div>";
												}
											}
										}
										echo "</div>";
									}
							}
							else
								if ((substr_count ($_SERVER ["REQUEST_URI"], "/") == 2) || ((substr_count ($_SERVER ["REQUEST_URI"], "/") == 4) && (strstr ($_SERVER ["REQUEST_URI"], "/page/") && (!strstr ($_SERVER ["REQUEST_URI"], "/category/page/")))))
								{		
									echo "<h4><a href='/teachers/?autor=".$poet."'>Переглянути всі вірші автора (за датою)</a></h4><br/>
										<h4><a href='/teachers/?autor=".$poet."&sort=abc'>Переглянути всі вірші автора (за абеткою)</a></h4>";
									bpca (15, $poet);
								}
								else
								if (substr_count ($_SERVER ["REQUEST_URI"], "/") == 3)
								{
									$sqlstr = "select term_taxonomy_id from wp_14_term_relationships where object_id in(select id from wp_14_posts where post_name='".substr (strrchr (substr ($_SERVER ["REQUEST_URI"], 0, strlen ($_SERVER ["REQUEST_URI"]) - strlen (strrchr ($_SERVER ["REQUEST_URI"], "/"))), "/"), 1, strlen (strrchr (substr ($_SERVER ["REQUEST_URI"], 0, strlen ($_SERVER ["REQUEST_URI"]) - strlen (strrchr ($_SERVER ["REQUEST_URI"], "/"))), "/")) - 1)."') and term_taxonomy_id!=5 and term_taxonomy_id!=4 and term_taxonomy_id not in(select term_taxonomy_id from wp_14_term_taxonomy where parent=4)";
									$cats = $wpdb->get_results($sqlstr, ARRAY_A);
									if (count ($cats) > 0)
									{
										$sqlstr = "select parent from wp_14_term_taxonomy where term_taxonomy_id=".$cats [0]["term_taxonomy_id"];
										$parents = $wpdb->get_results($sqlstr, ARRAY_A);
										if ($parents [0]["parent"] == 5)
											$root_cat = $cats [0]["term_taxonomy_id"];
										else
											while ($parents [0]["parent"] != 5)
											{
												$root_cat = $parents [0]["parent"];
												$sqlstr = "select parent from wp_14_term_taxonomy where term_taxonomy_id=".$parents [0]["parent"];
												$parents = $wpdb->get_results ($sqlstr, ARRAY_A);
											}
										if ($root_cat == 15)
											echo "<h4><a href='/teachers/?autor=".$poet."'>Переглянути всі вірші автора (за датою)</a></h4><br/>
											<h4><a href='/teachers/?autor=".$poet."&sort=abc'>Переглянути всі вірші автора (за абеткою)</a></h4>";
										bpca ($root_cat, $poet);
									}
								}
								else
									if (strstr ($_SERVER ["REQUEST_URI"], "/category/") && ($_GET ["autor"] != ""))
									{
										$sqlstr = "select term_id from wp_14_terms where slug='".strstr (substr (strstr ($_SERVER ["REQUEST_URI"], "/category/"), 10, strlen (strstr ($_SERVER ["REQUEST_URI"], "/category/")) - 10), "/", true)."'";
										$cats = $wpdb->get_results ($sqlstr, ARRAY_A);
										if (count ($cats) > 0)
										{
											$sqlstr = "select parent from wp_14_term_taxonomy where term_taxonomy_id=".$cats [0]["term_id"];
											$parents = $wpdb->get_results($sqlstr, ARRAY_A);
											echo "<style>";
											if ($parents [0]["parent"] == 5)
												$root_cat = $cats [0]["term_id"];
											else
												while ($parents [0]["parent"] != 5)
												{
													$sqlstr = "select slug from wp_14_terms where term_id=".$parents [0]["parent"];
													$slugs = $wpdb->get_results ($sqlstr, ARRAY_A);
													echo "#secondary h3 a[href=\"/teachers/category/".$slugs [0]["slug"]."/?autor=".$parent [0]["parent"]."\"]
														{
															color: #FFFDDC;
														}";
													$root_cat = $parents [0]["parent"];
													$sqlstr = "select parent from wp_14_term_taxonomy where term_taxonomy_id=".$parents [0]["parent"];
													$parents = $wpdb->get_results ($sqlstr, ARRAY_A);
												}
											echo "</style>";
											if ($root_cat == 15)
												echo "<h4><a href='/teachers/?autor=".$poet."'>Переглянути всі вірші автора (за датою)</a></h4><br/>
												<h4><a href='/teachers/?autor=".$poet."&sort=abc'>Переглянути всі вірші автора (за абеткою)</a></h4>";
											bpca ($root_cat, $poet);
											$sqlstr = "select slug from wp_14_terms where term_id=".$root_cat;
											$slugs = $wpdb->get_results ($sqlstr, ARRAY_A);					
											echo "<style>
											#top_sidebar a[href=\"/teachers/category/".$slugs [0]["slug"]."/?autor=".$poet."\"]
											{
												background: #D9B66D;
												transition: all 1s linear;
											}
											@media screen and (max-width: 600px)
											{
												#top_sidebar a[href=\"/teachers/category/".$slugs [0]["slug"]."/?autor=".$poet."\"]
												{
													background: none;
													color: #84469F !important;
													transition: all 1s linear;
												}
											}
											</style>";
										}
									}
					}
				}
			}
		}	
	}

function bypassCategory ($cat)
{
	global $wpdb;
	global $blog_id;
	$sqlstr = "select parent from wp_".$blog_id."_term_taxonomy where term_taxonomy_id=".$cat;
	$parents1 = $wpdb->get_results ($sqlstr, ARRAY_A);
	$sqlstr = "select path from wp_blogs where blog_id=".$blog_id;
	$paths = $wpdb->get_results ($sqlstr, ARRAY_A);  
	$sqlstr = "select id, post_title, post_name, post_date, comment_count from wp_".$blog_id."_posts where id in(select object_id from wp_".$blog_id."_term_relationships where term_taxonomy_id=".$cat.") and post_type='post' and post_status='publish'";
	if ($_GET ["sort"] == "abc")
		$sqlstr .= " order by post_title asc";
	else
		$sqlstr .= " order by post_date desc";
	$posts = $wpdb->get_results ($sqlstr, ARRAY_A);
	$is_posts = false;
	if (count ($posts) > 0)
	{
		$is_posts = true;
		$sqlstr = "select name, slug from wp_".$blog_id."_terms where term_id=".$cat;
		$terms = $wpdb->get_results ($sqlstr, ARRAY_A);
		echo "<h3";
		if ($parents1 [0]["parent"] == 0)
			echo " class='cat-root'";
		if ($terms [0]["slug"] == "poeziya")
			echo "><a href='".$paths [0]["path"]."category/".$terms [0]["slug"]."'/>ВІРШІ</a></h3>
			<div class='sitemap_list'>";
		else
			echo "><a href='".$paths [0]["path"]."category/".$terms [0]["slug"]."'/>".$terms [0]["name"]."</a></h3>
			<div class='sitemap_list'>";
	}
	else
	{
		$sqlstr = "select id from wp_".$blog_id."_posts where post_type='post' and post_status='publish'";
		$posts1 = $wpdb->get_results ($sqlstr, ARRAY_A);
		foreach ($posts1 as $post1)
		{				
			$sqlstr = "select term_taxonomy_id from wp_".$blog_id."_term_relationships where object_id=".$post1 ["id"];
			$terms1 = $wpdb->get_results ($sqlstr, ARRAY_A);
			foreach ($terms1 as $term1)
			{
				$sqlstr = "select parent from wp_".$blog_id."_term_taxonomy where term_taxonomy_id=".$term1 ["term_taxonomy_id"];
				$parents = $wpdb->get_results ($sqlstr, ARRAY_A);
				do
				{					
					if ($parents [0]["parent"] == $cat)
					{
						$is_posts = true;
						$sqlstr = "select name, slug from wp_".$blog_id."_terms where term_id=".$cat;
						$terms = $wpdb->get_results ($sqlstr, ARRAY_A);
						echo "<h3";
						if ($parents1 [0]["parent"] == 0)
							echo " class='cat-root'";
						if ($terms [0]["slug"] == "poeziya")
							echo "><a href='".$paths [0]["path"]."category/".$terms [0]["slug"]."'/>ВІРШІ</a></h3>
							<div class='sitemap_list'>";
						else
							echo "><a href='".$paths [0]["path"]."category/".$terms [0]["slug"]."'/>".$terms [0]["name"]."</a></h3>
							<div class='sitemap_list'>";
						break;
					}					 
					$sqlstr = "select parent from wp_".$blog_id."_term_taxonomy where term_taxonomy_id=".$parents [0]["parent"];
					$parents = $wpdb->get_results ($sqlstr, ARRAY_A);
				}
				while (count ($parents) > 0);
			}
		}
	}
	foreach ($posts as $post)
	{
		$is_child = false;
		$sqlstr = "select term_taxonomy_id from wp_".$blog_id."_term_relationships where object_id=".$post ["id"]." and term_taxonomy_id!=".$cat;
		$cats_other = $wpdb->get_results ($sqlstr, ARRAY_A);
		foreach ($cats_other as $co)
		{
			$sqlstr = "select parent from wp_".$blog_id."_term_taxonomy where term_taxonomy_id=".$co ["term_taxonomy_id"];
			$parents = $wpdb->get_results ($sqlstr, ARRAY_A);
			if (count ($parents) > 0)
			{
				if ($parents [0]["parent"] == $cat)
					$is_child = true;
				else
					do
					{					
						$sqlstr = "select parent from wp_".$blog_id."_term_taxonomy where term_taxonomy_id=".$parents [0]["parent"];
						$parents = $wpdb->get_results($sqlstr, ARRAY_A);
						if (count ($parents) > 0)
							if ($parents [0]["parent"] == $cat)
							{
								$is_child = true;
								break;
							}
					}
					while (count ($parents) > 0);
			}
		}
		if (!$is_child)
		{
			echo "<div class='amc'>
				<a href='".$paths [0]["path"].$post ["post_name"]."/' class='article-map'>".$post ["post_title"]."</a>";
			if ($post ["comment_count"] >  0)
				echo "&nbsp;<a href='".$paths [0]["path"].$post ["post_name"]."/#comments' class='map-comments'>Коментарі (".$post ["comment_count"].")</a>";
			echo "</div>";
		}		
	}
	$sqlstr = "select term_taxonomy_id from wp_".$blog_id."_term_taxonomy where parent=".$cat;
	$childs = $wpdb->get_results($sqlstr, ARRAY_A);
	foreach ($childs as $child)
		bypassCategory ($child ["term_taxonomy_id"]);
	if ($is_posts)
		echo "</div>";
}

function bpca ($cat, $autor)
{
	global $wpdb;
	$sqlstr = "select parent from wp_14_term_taxonomy where term_taxonomy_id=".$cat;
	$parents1 = $wpdb->get_results ($sqlstr, ARRAY_A);
	$sqlstr = "select path from wp_blogs where blog_id=".$blog_id;
	$paths = $wpdb->get_results ($sqlstr, ARRAY_A);  
	$sqlstr = "select id, post_title, post_name, post_date, comment_count from wp_14_posts where id in(select object_id from wp_14_term_relationships where term_taxonomy_id=".$cat.") and id in(select object_id from wp_14_term_relationships where term_taxonomy_id=".$autor.") and post_type='post' and post_status='publish'";
	if ($_GET ["sort"] == "abc")
		$sqlstr .= " order by post_title asc";
	else
		$sqlstr .= " order by post_date desc";
	$posts = $wpdb->get_results ($sqlstr, ARRAY_A);
	$is_posts = false;
	if (count ($posts) > 0)
	{
		$is_posts = true;
		$sqlstr = "select name, slug from wp_14_terms where term_id=".$cat;
		$terms = $wpdb->get_results ($sqlstr, ARRAY_A);
		echo "<h3";
		if ($parents1 [0]["parent"] == 5)
			echo " class='cat-root'";
		if ($terms [0]["slug"] == "poeziya")
			echo "><a href='/teachers/category/".$terms [0]["slug"]."/?autor=".$autor."'/>ВІРШІ</a></h3>
			<div class='sitemap_list'>";
		else
		{
			echo "><a href='/teachers/category/".$terms [0]["slug"]."/?autor=".$autor."'/>".$terms [0]["name"]."</a></h3>
			<div class='sitemap_list'>";
		}
	}
	else
	{
		$sqlstr = "select id from wp_14_posts where post_type='post' and post_status='publish' and id in(select object_id from wp_14_term_relationships where term_taxonomy_id=".$autor.")";
		$posts1 = $wpdb->get_results ($sqlstr, ARRAY_A);
		foreach ($posts1 as $post1)
		{				
			$sqlstr = "select term_taxonomy_id from wp_14_term_relationships where object_id=".$post1 ["id"];
			$terms1 = $wpdb->get_results ($sqlstr, ARRAY_A);
			foreach ($terms1 as $term1)
			{
				$sqlstr = "select parent from wp_14_term_taxonomy where term_taxonomy_id=".$term1 ["term_taxonomy_id"];
				$parents = $wpdb->get_results ($sqlstr, ARRAY_A);
				do
				{					
					if ($parents [0]["parent"] == $cat)
					{
						$is_posts = true;
						$sqlstr = "select name, slug from wp_14_terms where term_id=".$cat;
						$terms = $wpdb->get_results ($sqlstr, ARRAY_A);
						echo "<h3";
						if ($parents1 [0]["parent"] == 0)
							echo " class='cat-root'";
						if ($terms [0]["slug"] == "poeziya")
							echo "><a href='/teachers/category/".$terms [0]["slug"]."/?autor=".$autor."'/>ВІРШІ</a></h3>
							<div class='sitemap_list'>";
						else
							echo "><a href='/teachers/category/".$terms [0]["slug"]."'/?autor=".$autor."/>".$terms [0]["name"]."</a></h3>
							<div class='sitemap_list'>";
						break;
					}					 
					$sqlstr = "select parent from wp_14_term_taxonomy where term_taxonomy_id=".$parents [0]["parent"];
					$parents = $wpdb->get_results ($sqlstr, ARRAY_A);
				}
				while (count ($parents) > 0);
			}
		}
	}
	foreach ($posts as $post)
	{
		$is_child = false;
		$sqlstr = "select term_taxonomy_id from wp_14_term_relationships where object_id=".$post ["id"]." and term_taxonomy_id!=".$cat." and term_taxonomy_id!=".$autor;
		$cats_other = $wpdb->get_results ($sqlstr, ARRAY_A);
		foreach ($cats_other as $co)
		{
			$sqlstr = "select parent from wp_14_term_taxonomy where term_taxonomy_id=".$co ["term_taxonomy_id"];
			$parents = $wpdb->get_results ($sqlstr, ARRAY_A);
			if (count ($parents) > 0)
			{
				if ($parents [0]["parent"] == $cat)
					$is_child = true;
				else
					do
					{					
						$sqlstr = "select parent from wp_14_term_taxonomy where term_taxonomy_id=".$parents [0]["parent"];
						$parents = $wpdb->get_results($sqlstr, ARRAY_A);
						if (count ($parents) > 0)
							if ($parents [0]["parent"] == $cat)
							{
								$is_child = true;
								break;
							}
					}
					while (count ($parents) > 0);
			}
		}
		if (!$is_child)
		{
			echo "<div class='amc'>
				<a href='/teachers/".$post ["post_name"]."/' class='article-map'>".$post ["post_title"]."</a>";
			if ($post ["comment_count"] > 0)
				echo "&nbsp;<a href='/teachers/".$post ["post_name"]."/#comments' class='map-comments'>Коментарі (".$post ["comment_count"].")</a>";
			echo "</div>";
		}		
	}
	$sqlstr = "select term_taxonomy_id from wp_14_term_taxonomy where parent=".$cat;
	$childs = $wpdb->get_results($sqlstr, ARRAY_A);
	foreach ($childs as $child)
		bpca ($child ["term_taxonomy_id"], $autor);
	if ($is_posts)
		echo "</div>";
}
	if (($blog_id == 14) && (($_SERVER ["REQUEST_URI"] == "/teachers/") || ((substr_count ($_SERVER ["REQUEST_URI"], "/") == 4) && ($_GET ["autor"] == "") && ($_GET ["s"] == "") && (strstr ($_SERVER ["REQUEST_URI"], "/teachers/page/")) && (!strstr ($_SERVER ["REQUEST_URI"], "/teachers/teachers/page/")))))
	{
		$output = "";
		$i = 0;	
		$sqlstr = "SELECT id, post_date, post_modified, comment_count from wp_14_posts p where post_status='publish' and (";
		subCat3 (15, $sqlstr, 15, 14);
		$sqlstr .= ") ORDER BY post_date desc";
		$post_list = $wpdb->get_results ($sqlstr, ARRAY_A);
		foreach ($post_list as $post1) 
		{
			$sqlstr = "select name, term_id from wp_14_terms where term_id in(select term_taxonomy_id from wp_14_term_relationships where object_id=".$post1 ["id"].") and term_id in(select term_id from wp_14_term_taxonomy where parent=4)";
			$autors = $wpdb->get_results ($sqlstr, ARRAY_A);
			$txt = "{title}";
			$p = get_blog_post (14, $post1 ["id"]);	
			$content = preg_replace ("/<img.+?>/", "", $p->post_content);
			$content = preg_replace ("/<a.+?><\/a>(\n)*/s", "", $content);
			$content = preg_replace ("/(\n)+?/", "<br/>", $content);
			$content = preg_replace ("/(\s)*<br\/>(\s)*((\s)*<br\/>(\s)*)+/", "<br/>", $content);
			$content = preg_replace ("/\[youtube\]http(s)?:\/\/(www\.)?youtube\.com\/watch\?v=(.*?)\[\/youtube\]/", "", $content);
			$content = preg_replace ("/\[embed\]http(s)?:\/\/(www\.)?vimeo\.com\/(.*?)\[\/embed\]/", "", $content);
			$content = preg_replace ("/\[vimeo\]http(s)?:\/\/(www\.)?vimeo\.com\/(.*?)\[\/vimeo\]/", "", $content);
			$content = preg_replace ("/\[embed\]http(s)?:\/\/(www\.)?youtube\.com\/watch\?v=(.*?)\[\/embed\]/", "", $content);
            $content = trim ($content);
			if ((substr ($content, 0, 5) == "<div>") && (substr ($content, strlen ($content) - 6, 6) == "</div>"))
				$content = substr ($content, 5, strlen ($content) - 11);
			$content = trim ($content);
			if (strstr ($content, "<!--more-->"))
				$content = strstr ($content, "<!--more-->", true);
			if (strstr ($content, "<p></p>"))
				$content = strstr ($content, "<p></p>", true);
			if (strstr ($content, "
&nbsp;
"))
			$content = strstr ($content, "
&nbsp;
", true);
			if (strstr ($content, "<br/><br/>"))
				$content = strstr ($content, "<br/><br/>", true);
			if (strstr ($content, "<br/>
<br/>"))
				$content = strstr ($content, "<br/>
<br/>", true);
			if (strstr ($content, "<br></br>
<br></br>"))
				$content = strstr ($content, "<br><br/>
<br><br/>", true);
			if (strstr ($content, "<br></br><br></br>"))
				$content = strstr ($content, "<br><br/><br><br/>", true);
			$preview = preg_split ("/(<br\/>|<br><\/br>)".wp_spaces_regexp ()."(<br\/>|<br><\/br>)/", $content);
			$content = $preview [0];
			$content = closetags ($content);
			if ($post1 ["comment_count"] > 0)
				$txt = str_replace ("{title}", '<div class="poetryname"><a href="/teachers/?autor='.$autors [0]["term_id"].'">'.$autors [0]["name"].'</a></div><h3><a href="'.get_blog_permalink (14, $post1 ["id"]).'">'.$p->post_title.'</a></h3><div class="poetry">'.$content.'</div><div class="readmore"><a href="'.get_blog_permalink (14, $post1 ["id"]).'">Читати далі...</a></div><div class="poetrydata">'.mysqli2date ("l, F j, Y, G:i", $p->post_date).'</div><div class="map-comments"><a href="'.get_blog_permalink (14, $post1 ["id"]).'#comments">Коментарі ('.$post1 ["comment_count"].')</a></div>', $txt);
			else			
				$txt = str_replace ("{title}", '<div class="poetryname"><a href="/teachers/?autor='.$autors [0]["term_id"].'">'.$autors [0]["name"].'</a></div><h3><a href="'.get_blog_permalink (14, $post1 ["id"]).'">'.$p->post_title.'</a></h3><div class="poetry">'.$content.'</div><div class="readmore"><a href="'.get_blog_permalink (14, $post1 ["id"]).'">Читати далі...</a></div><div class="poetrydata">'.mysqli2date ("l, F j, Y, G:i", $p->post_date)."</div>", $txt);
			$output .=  $txt."<br/>";
			$i++;
			if ($i > 4)
				break;
		}		
		$output .=  $wpdb->print_error();
		echo "<h3 class='widget-title'>Свіжі доповненя до блогу улюблених поетів</h3>".$output;
	}
?>
</div><!-- #secondary -->