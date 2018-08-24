<?php
/*setting iso msg spec here
  for fix len : bit=>N    (N = len of VAR)
  for var len : bit=>'vX' (X = leading digit for VAR len)*/
  
$spec = array(
1=>16,2=>'v2',3=>6,4=>18,5=>12,6=>12,7=>10,8=>8,
9=>8,10=>8,11=>6,12=>6,13=>6,14=>6,15=>6,16=>6,
17=>6,18=>4,19=>3,20=>3,21=>3,22=>3,23=>3,24=>3,
25=>2,26=>2,27=>1,28=>9,29=>9,30=>9,31=>9,32=>'v2',
33=>'v2',34=>'v2',35=>'v2',36=>'v3',37=>12,38=>6,39=>2,40=>3,
41=>16,42=>15,43=>40,44=>'v2',45=>'v2',46=>'v3',47=>'v3',48=>'v3',
49=>3,50=>3,51=>3,52=>16,53=>16,54=>'v3',55=>'v3',56=>'v3',
57=>'v3',58=>'v3',59=>'v3',60=>'v3',61=>'v3',62=>'v3',63=>'v3',64=>16,
65=>1,66=>1,67=>2,68=>3,69=>3,70=>3,71=>4,72=>4,
73=>6,74=>10,75=>10,76=>10,77=>10,78=>10,79=>10,80=>10,
81=>10,82=>12,83=>12,84=>12,85=>12,86=>12,87=>16,88=>16,
89=>16,90=>42,91=>1,92=>2,93=>5,94=>7,95=>42,96=>16,
97=>18,98=>25,99=>'v2',100=>'v2',101=>'v2',102=>'v2',103=>'v2',104=>'v3',
105=>'v3',106=>'v3',107=>'v3',108=>'v3',109=>'v3',110=>'v3',111=>'v3',112=>'v3',
113=>'v3',114=>'v3',115=>'v3',116=>'v3',117=>'v3',118=>'v3',
119=>'v3',120=>'v3',121=>'v3',122=>'v3',123=>'v3',124=>'v3',
125=>'v3',126=>'v3',127=>'v3',128=>16);

/* ISO8583 Function */

function iso2str($arr){
  global $spec;
  $bitmap1 = crtbit($arr,1);
  $str = $arr['pfx'].$arr['mti'].$bitmap1;
  if(max(array_keys($arr))>64) $str.=crtbit($arr,2);
  for($i=2;$i<=128;$i++){
    if(isset($arr[$i]))
      if(substr($spec[$i],0,1)!='v') $str.=str_pad($arr[$i],$spec[$i],' ');
      else $str.= str_pad(strlen($arr[$i]),substr($spec[$i],1),0,STR_PAD_LEFT).$arr[$i];
  }
  return $str;
}

function crtbit($arr,$n=1){
  if(max(array_keys($arr))>64) $bit = '1'; else $bit = '0';
  for($i=2;$i<=128;$i++)
    if(isset($arr[$i])) $bit .= '1';
    else $bit .= '0';
  $hex = '';
  for($i=0;$i<32;$i++)
    $hex .= strtoupper(base_convert(substr($bit,$i*4,4),2,16));
  if($n==1) return substr($hex,0,16);
  else return substr($hex,16,16);
}

function iso2arr($iso,$prefix){
  global $spec;
  $data = array();
  $data['string'] = $iso;
  $data['header'] = substr($data['string'],0,$prefix);
  $data['mti'] = substr($data['string'],$prefix,4);
  $data['bitmap'] = substr($data['string'],$prefix+4,16);
  $data['bit'] = onbit($data['bitmap']);
  $val = substr($data['string'],$prefix+20);
  for($i=0;isset($data['bit'][$i]);$i++){
    $len = $spec[$data['bit'][$i]];
    if (substr($len,0,1)!='v'){
      $data['val'][$i] = substr($val,0,$len);
    } else {
      $len = substr($len,1);
      $data['val'][$i] = substr($val,$len,substr($val,0,$len));
      $len += substr($val,0,$len);
    }
    if($data['bit'][$i]==1 && $i==0)
      $data['bit']=onbit($data['val'][$i],$data['bit'],65);
    $val = substr($val,$len);
  }
  return $data;
}

function onbit($bitmap,$bit=array(),$j=1){
  $bin = '';
  for($i=0;$i<strlen($bitmap);$i++) 
    $bin .= str_pad(base_convert(substr($bitmap,$i,1),16,2),4,0,STR_PAD_LEFT);
  for($i=0;$i<strlen($bin);$i++)
    if (substr($bin,$i,1)==1) $bit[] = $i+$j;
  return $bit;
}
?>