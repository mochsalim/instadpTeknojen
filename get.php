<?php
	require_once("fonksiyonlar.php");
	header("Access-Control-Allow-Origin: *");
	$ne = $_GET["ne"];
	$id = ayristir($_GET["id"]);
	$ufak = $_GET["ufak"];
	if (!$id == false){
		if ($ne == "html"){
			$d = getData($id);
			if ($d != false){
				if ($d["img"]){
					$w = $d["w"];
					$h = $d["h"];
					if ($w >= 500 and $h >= 500){
						$w = $w-($w/7);
						$h = $h-($h/7);
					}
					lo("get.php: ".$id." kullanıcı adı için sorgulama yapılıyor.");
					echo '<div class="container text-center" float="left" style="margin-top: 1%"><h2 style="margin-left:%3" id="dl">Instagram Full Size Profile Picture of '.$d["name"].'</h2></div>
					<img class="img-thumbnail rounded" src="'.$d["img"].'" width="'.$w.'" height="'.$h.'" alt="'.$d["name"].'\'s Full Size Profile Picture" title="To download right click/long press and select Save As">
					<div class="row-md"><a style="margin-top:2%;margin-bottom:2%" class="btn btn-primary btn-md" href="'.$d["img"].'" target="_blank"><i class="fas fa-search"></i>&nbsp;See Full Size Profile Image</a>
					<a style="margin-top:2%;margin-bottom:2%" class="btn btn-danger btn-md" href="https://www.instagram.com/'.$id.'/" target="_blank"><i class="fab fa-instagram"></i>&nbsp;Go to Profile</a>
					<a style="margin-top:2%;margin-bottom:2%" class="btn btn-info btn-md" href="https://twitter.com/share?url=https://teknojen.net/instagramdp/&text=Instagram%20Profile%20Picture%20Downloader" target="_blank"><i class="fab fa-twitter"></i></a>
					<a style="margin-top:2%;margin-bottom:2%" class="btn btn-primary btn-md" href="https://www.facebook.com/sharer/sharer.php?u=https://teknojen.net/instagramdp/" target="_blank"><i class="fab fa-facebook"></i></a>
					</div>';
					$q = 0;
					if ($d["fotolar"] != false){
						echo '<h2 style="margin-left:%3" id="dl">Other Instagram Pictures of '.$d["name"].'</h2>';
						foreach($d["fotolar"] as $f){
							$w = $f["w"];
							$h = $f["h"];
							if ($w >= 500 and $h >= 500){
								$w = $w-($w/7);
								$h = $h-($h/7);
							}
							echo '<img class="img-thumbnail rounded" src="'.$f["url"].'" width="'.$w.'" height="'.$h.'" alt="'.$d["name"].'\'s Full Size Instagram Picture" title="To download right click/long press and select Save As">
								<div class="row-md">
								<a style="margin-top:2%;margin-bottom:2%" class="btn btn-primary btn-md" href="'.$f["url"].'" target="_blank"><i class="fas fa-search"></i>&nbsp;See Full Image</a>
								<a style="margin-top:2%;margin-bottom:2%" class="btn btn-danger btn-md" href="https://www.instagram.com/p/'.$f["kisaKodu"].'/" target="_blank"><i class="fab fa-instagram"></i>&nbsp;Go to Instagram Post</a>
								</div>';
							if ($q == 4){
								echo '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
								<ins class="adsbygoogle"
									 style="display:block"
									 data-ad-client="ca-pub-4805334974393671"
									 data-ad-slot="2381584510"
									 data-ad-format="auto"
									 data-full-width-responsive="true"></ins>
								<script>
								(adsbygoogle = window.adsbygoogle || []).push({});
								</script>';
							}
							$q++;
						}
					}
				}else{
					echo '<div class="alert alert-danger" role="alert">Sorry! We have f*ckd up.</div>';
				}
			}else{
				echo '<div class="alert alert-danger" role="alert">Instagram username or URL not found!</div>';
			}
		}elseif ($ne == "img"){
			log("get.php: Direkt resim erişimi istendi. ".$id);
			$d = getData($id);
			if ($d != false){
				header("Content-type: image/jpeg");
				$img = getir($d["img"]);
				if ($_GET["ufak"] == 1){
					$img = getir($d["ufakResim"]);
				}
				echo $img;
			}
		}elseif ($ne == "json"){
			$d = getData($id);
			if ($d != false){
				print_r(json_encode($d));
			}else{
				print_r(json_encode(array("hata" => "napıyon amk bozuldum")));
			}
		}
	}elseif ($ne == "slayt"){
		slaytYap();
	}else{
		echo '<div class="alert alert-danger" role="alert">Profile URL or username is incorrect!</div>';
	}
	function slaytYap(){
		//lo("Kullanıcı için slayt oluşturuluyor");
		$kimler = array(
			"210746792", #realbarbarapalvin
			"301763305", #adrianalima
			"8224518", #alexinagraham
			"1901206", #minetugay
			"591940460", #estherabrami
			"367938251", #dubkovapo
			"380850774", #devinbrugman
			"2040216573", #hakanz774
			"5589904" #bensusoral
		);
		shuffle($kimler);
		echo '<div id="recommendedSlayt" class="carousel slide w-100" data-ride="carousel"><div class="carousel-inner w-100" role="listbox">';
		$ilkTur = true;
		$ind = 1;
		foreach($kimler as $kim){
			if ($ilkTur and $ind == 1){
				echo '<div class="carousel-item row no-gutters active">';
				$ilkTur = false;
			}elseif(!$ilkTur and $ind == 1){
				echo '<div class="carousel-item row no-gutters">';
			}
			if ($ind <= 4){
				$src = idNumarasiylaGetir($kim);
				if ($src != false){
					echo '<div class="col-3 float-left"><a href="https://teknojen.net/instagramdp/?id='.$src["kullaniciAdi"].'"><img class="img-fluid" width="320" height="320" alt="'.$src["name"].'\'s Profile Image" src="'.$src["ufakResim"].'"></a></div>';
				}else{
					if (!isset($src["username"])){
						echo '<div class="col-3 float-left"><a href="https://teknojen.net/instagramdp/?id=realbarbarapalvin"><img class="img-fluid" width="320" height="320" alt="Barbara Palvin\'s Profile Image" src="https://teknojen.net/instagramdp/get.php?id=realbarbarapalvin&ufak=1&ne=img"></a></div>';
					}else{
						echo '<div class="col-3 float-left"><a href="https://teknojen.net/instagramdp/?id='.$src["username"].'"><img class="img-fluid" width="320" height="320" alt="'.$src["name"].'\'s Profile Image" src="https://teknojen.net/instagramdp/get.php?id='.$src["username"].'?ufak=1&ne=img"></a></div>';
					}
				}
			}
			if ($ind == 4 or $ind == count($kimler)){
				echo "</div>";
				$ind = 1;
			}else{
				$ind++;
			}
		}
		echo '</div>
				</div>
				<a class="carousel-control-prev" href="#recommendedSlayt" role="button" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</a>
				<a class="carousel-control-next" href="#recommendedSlayt" role="button" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>';
	}
?>
