<?php 

namespace App\Helpers;
use Illuminate\Support\Facades\DB;
use App\Provider;
use App\Service;

class DepositBCA {
        public static function fix_angka($string)
        {
            $string = str_replace(',', '', $string);
            $string = strtok($string, '.');
            return $string;
        }
        public static function grab() {
            $user_ip = '202.62.16.186';
            $ua = "Mozilla/5.0 (Windows NT 6.2) AppleWebKit/537.36 (KHTML, like Gecko) '.
            Chrome/44.0.2403.89 Safari/537.36";
            $cookie = APP_PATH . 'bca-cookie.txt';

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie);
            curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
            curl_setopt($ch, CURLOPT_USERAGENT, $ua);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, 'https://ibank.klikbca.com');
            $info = curl_exec($ch);

            $a = strstr($info, 'var s = document.createElement(\'script\'), attrs = { src: (window.location.protocol ==',
                1);
            $a = strstr($a, 'function getCurNum(){');

            $b = array(
                'return "',
                'function getCurNum(){',
                '";',
                '}',
                '{',
                '(function()',
                );

            $b = str_replace($b, '', $a);
            $curnum = trim($b);
            $params = 'value%28actions%29=login&value%28user_id%29=' . $user .
                '&value%28CurNum%29=' . $curnum . '&value%28user_ip%29=' . $user_ip .
                '&value%28browser_info%29=' . $ua . '&value%28mobile%29=false&value%28pswd%29=' .
                $pass . '&value%28Submit%29=LOGIN';
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL, 'https://ibank.klikbca.com/authentication.do');
            curl_setopt($ch, CURLOPT_REFERER, 'https://ibank.klikbca.com');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_POST, 1);
            $info = curl_exec($ch);

            // Buka menu
            curl_setopt($ch, CURLOPT_URL,
                'https://ibank.klikbca.com/nav_bar_indo/menu_bar.htm');
            curl_setopt($ch, CURLOPT_REFERER, 'https://ibank.klikbca.com/authentication.do');
            $info = curl_exec($ch);

            // Buka Informasi Rekening
            curl_setopt($ch, CURLOPT_URL,
                'https://ibank.klikbca.com/nav_bar_indo/account_information_menu.htm');
            curl_setopt($ch, CURLOPT_REFERER, 'https://ibank.klikbca.com/authentication.do');
            $info = curl_exec($ch);

            // Buka Mutasi Rekening
            curl_setopt($ch, CURLOPT_URL,
                'https://ibank.klikbca.com/accountstmt.do?value(actions)=acct_stmt');
            curl_setopt($ch, CURLOPT_REFERER,
                'https://ibank.klikbca.com/nav_bar_indo/account_information_menu.htm');
            curl_setopt($ch, CURLOPT_POST, 1);
            $info = curl_exec($ch);

            // Parameter untuk Lihat Mutasi Rekening
            $params = array();

            $jkt_time = time() + (3600 * 7);
            $t1 = explode('-', date('Y-m-d', $jkt_time));
            $t0 = explode('-', date('Y-m-d', $jkt_time - (3600 * 24)));

            $params[] = 'value%28startDt%29=' . $t0[2];
            $params[] = 'value%28startMt%29=' . $t0[1];
            $params[] = 'value%28startYr%29=' . $t0[0];
            $params[] = 'value%28endDt%29=' . $t1[2];
            $params[] = 'value%28endMt%29=' . $t1[1];
            $params[] = 'value%28endYr%29=' . $t1[0];
            $params[] = 'value%28D1%29=0';
            $params[] = 'value%28r1%29=1';
            $params[] = 'value%28fDt%29=';
            $params[] = 'value%28tDt%29=';
            $params[] = 'value%28submit1%29=Lihat+Mutasi+Rekening';

            $params = implode('&', $params);

            // Buka Lihat Mutasi Rekening & simpan hasilnya di $source
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_URL,
                'https://ibank.klikbca.com/accountstmt.do?value(actions)=acctstmtview');
            curl_setopt($ch, CURLOPT_REFERER,
                'https://ibank.klikbca.com/nav_bar_indo/account_information_menu.htm');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_POST, 1);

            $source = curl_exec($ch);

            // Logout, cURL close, hapus cookies
            curl_setopt($ch, CURLOPT_URL,
                'https://ibank.klikbca.com/authentication.do?value(actions)=logout');
            curl_setopt($ch, CURLOPT_REFERER,
                'https://ibank.klikbca.com/nav_bar_indo/account_information_menu.htm');
            $info = curl_exec($ch);
            curl_close($ch);
            @unlink($cookie);
            return $source;
        }

        public static function check($user, $pass, $jumlah) {
            global $pdo;
            $source = $this->grab_bca($user, $pass);
            //  exit($source);
            $exp = explode('<b>Saldo</b></font></div></td>', $source);
            $invoices = array();
            $lunas = array();
            $jkt_time = time() + (3600 * 7);
            $tahun = date('Y', $jkt_time);
            if (isset($exp[1]))
            {
                $table = explode("</table>", $exp[1]);
                $tr = explode("<tr>", $table[0]);
                for ($i = 1; $i < count($tr); $i++)
                {
                    $str = str_ireplace('</font>', '#~#~#</font>', $tr[$i]);
                    $str = str_ireplace('<br>', '<br> ', $str);
                    $str = preg_replace('!\s+!', ' ', trim(strip_tags($str)));
                    $arr = array_map('trim', explode("#~#~#", $str));
                    $tgl = $arr[0] . '/' . $tahun;
                    $keterangan = $arr[1];
                    $kredit = $this->fix_angka($arr[3]);
                    $status = $arr[4];
                    if($kredit == $jumlah){
                    $result = true;
                    }
                }
                return $result;
            }
        }
}


 ?>