<?
//$DEF_ALLOWD_SIZE=$SITE[storage];
$DEF_ALLOWD_SIZE=24;
$WARNING_SIZE=$DEF_ALLOWD_SIZE-($DEF_ALLOWD_SIZE*0.1);
$ERROR_SIZE=$DEF_ALLOWD_SIZE;
$BLOCK_SIZE=$DEF_ALLOWD_SIZE+($DEF_ALLOWD_SIZE*0.2);
function CalculateDirSize() {
    $CALCULATED_DIRS=array("../gallery","../video","../userfiles");
    $d_size=0;
    foreach($CALCULATED_DIRS as $path) {
        $DIR_S=getDirectorySize($path);
        $d_size=$d_size+sizeFormat($DIR_S['size']);
    }
    return $d_size;
}
function getDirectorySize($path) 
{ 
  $totalsize = 0; 
  $totalcount = 0; 
  $dircount = 0; 
  if ($handle = opendir ($path)) 
  { 
    while (false !== ($file = readdir($handle))) 
    { 
      $nextpath = $path . '/' . $file; 
      if ($file != '.' && $file != '..' && !is_link ($nextpath)) 
      { 
        if (is_dir ($nextpath)) 
        { 
          $dircount++; 
          $result = getDirectorySize($nextpath); 
          $totalsize += $result['size']; 
          $totalcount += $result['count']; 
          $dircount += $result['dircount']; 
        } 
        elseif (is_file ($nextpath)) 
        { 
          $totalsize += filesize ($nextpath); 
          $totalcount++; 
        } 
      } 
    } 
  } 
  closedir ($handle); 
  $total['size'] = $totalsize; 
  $total['count'] = $totalcount; 
  $total['dircount'] = $dircount; 
  return $total; 
} 

function sizeFormat($size) 
{ 
    if($size<1024) 
    { 
        return $size." bytes"; 
    } 
    else if($size<(1024*1024)) 
    { 
        $size=round($size/1024,1); 
        return $size." KB"; 
    } 
    else if($size<(1024*1024*1024)) 
    { 
        $size=round($size/(1024*1024),1); 
        return $size; 
    } 
    else 
    { 
        $size=round($size/(1024*1024*1024),1); 
        return $size." GB"; 
    } 

}
$existingStorage=CalculateDirSize();
