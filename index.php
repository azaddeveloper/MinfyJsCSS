 function minifyCss(){

        $defaultPathArray=array('public'=>FCPATH.'public/css','dist'=>FCPATH.'public/dist/css');
        $cssArray=array();
        foreach ($defaultPathArray as $key => $value) {
            $directories = glob($value. '/*' , GLOB_ONLYDIR);
            if(!empty($directories)){
                $cssArray=array_merge($defaultPathArray,$directories);
            }
        }
        foreach ($cssArray as $key => $value) {
          foreach(glob($value.'/*.*') as $file) {
                $css=file_get_contents($file);
                $css = preg_replace('/\/\*((?!\*\/).)*\*\//', '', $css); // negative look ahead
                $css = preg_replace('/\s{2,}/', ' ', $css);
                $css = preg_replace('/\s*([:;{}])\s*/', '$1', $css);
                $css = preg_replace('/;}/', '}', $css);
                file_put_contents($file, $css);
            }
        }
    }
    function minifyJs(){

        $defaultPathArray=array('public'=>FCPATH.'public/js','dist'=>FCPATH.'public/dist/js');
        $cssArray=array();
        foreach ($defaultPathArray as $key => $value) {
            $directories = glob($value. '/*' , GLOB_ONLYDIR);
            if(!empty($directories)){
                $cssArray=array_merge($defaultPathArray,$directories);
            }
        }
        foreach ($cssArray as $key => $value) {
          foreach(glob($value.'/*.*') as $file) {
                $direcotry=$file;
                // echo $direcotry."<br>";
                $url = 'https://javascript-minifier.com/raw';
                $js = file_get_contents($direcotry);
                $ch = curl_init();
                curl_setopt_array($ch, [
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_POST => true,
                    CURLOPT_HTTPHEADER => ["Content-Type: application/x-www-form-urlencoded"],
                    CURLOPT_POSTFIELDS => http_build_query([ "input" => $js ])
                ]);
                $minified = curl_exec($ch);

                // finally, close the request
                curl_close($ch);

                // output the $minified JavaScript
                // echo $minified;

                file_put_contents($file, $minified);
            }
        }
    }
