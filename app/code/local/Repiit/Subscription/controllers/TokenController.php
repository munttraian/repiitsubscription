<?php
/**
 * Created by PhpStorm.
 * User: Traian
 * Date: 12/4/2016
 * Time: 4:56 PM
 */

class Repiit_Subscription_TokenController extends Mage_Core_Controller_Front_Action
{

    public function gettattokenAction()
    {

        $this->getResponse()->setHeader('Content-Type', 'text/html; charset=utf-8');
        $this->getResponse()->setHeader('User-Agent', 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/54.0.2840.99 Safari/537.36');

        $user = Mage::getStoreConfig('repiitsubscription/general/partener_id');
        $pass = Mage::getStoreConfig('repiitsubscription/general/key');

        ?>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/hmac-sha256.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/components/enc-base64.js"></script>

        <script>
            var result = 'nM5aiFNUeWL9icb56akttLsO7NomSJoqS/L2+wpi594y:testIP';
            var pass = '<?php echo $pass ?>';
            var user = '<?php echo $user ?>';
            var ticks = (new Date().getTime() * 10000) + 621355968000000000;
            var arrayOfResult = result.split(":");
            var passwordHash = CryptoJS.HmacSHA256(arrayOfResult[0], [pass, arrayOfResult[0]].join(":"));
            var passwordToken = CryptoJS.enc.Base64.stringify(passwordHash);
            var hash = CryptoJS.HmacSHA256([user, arrayOfResult[1], navigator.userAgent.replace(/ \.NET.+;/, ''), ticks].join(":"), passwordToken);
            var tokenLeft = CryptoJS.enc.Base64.stringify(hash);
            var combinedToken = [tokenLeft, [user, ticks].join(":")].join(":");
            var finalToken = CryptoJS.enc.Base64.stringify(CryptoJS.enc.Utf8.parse(combinedToken));

            console.log(navigator.userAgent);
            document.write(finalToken.toString());
        </script>
        <?php
    }

}