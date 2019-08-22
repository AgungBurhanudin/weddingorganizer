<?php

namespace Libraries;

use Resources;

class Simulator {

    public static function plnpostpaid($jenis) {
        if($jenis == 'inq'){
            $response = '{"ket1":"MUSHOLA MIFTAHUL JANNAH  ","ket2":"201712","ket3":"","reff":"simulator77666FC6CB864EB780D0000000000000","response_code":"0000","response_message":"OK","nama":"MUSHOLA MIFTAHUL JANNAH  ","idpel":"232346112625","daya":"450","tarif":"  S2","detail":[{"periode":"201712","meter_kini":"8515","meter_lalu":"8487","tagihan":8182,"adm":2500,"denda":"0","total_tagihan":10682}],"periode":"201712","lembar":1,"tagihan":8182,"adm":2500,"denda":0,"total_tagihan":10682,"ori":{"billStatus":"1","postpaidBillInfos":[{"billPeriod":"201712","currentMeterReading1":"8515","currentMeterReading2":"0","currentMeterReading3":"0","dueDate":"20122017","incentive":"D0000000000","meterReadDate":"00000000","penaltyFee":"0","previousMeterReading1":"8487","previousMeterReading2":"0","previousMeterReading3":"0","totalElectricityBill":"000000008182","valueAddedTax":"0"}],"powerConsumingCategory":"450","serviceUnit":"53871","serviceUnitPhone":"123            ","subscriberId":"538711365154","subscriberName":"MUSHOLA MIFTAHUL JANNAH  ","subscriberSegmentation":"  S2","switcherId":"0000000","switcherRefNum":"simulator77666FC6CB864EB780D0000000000000","totalAdminCharges":"0","totalAmount":"8182","totalOutstandingBill":"1"},"loadTime":"0.0013","tipe_request":"inquiry","prv":"hpay","userID":"1001010","product":"PLN","produk":"PLN","product_detail":"POSTPAID","produk_tipe":"POSTPAID","traceId":222105848385}';
        }else{
            $response = '{"adm":2500,"ori":{"infoText":"\"Informasi Hubungi Call Center 123 Atau Hub PLN Terdekat :\"                     ","billStatus":"1","switcherId":"0000000","serviceUnit":"53871","totalAmount":"8309","subscriberId":"538711365154","subscriberName":"MUSHOLA MIFTAHUL JANNAH  ","switcherRefNum":"0BNS25AF11F22199E243B889416D3AD9","serviceUnitPhone":"123            ","postpaidBillInfos":[{"dueDate":"20112017","incentive":"D0000000000","billPeriod":"201711","penaltyFee":"0","meterReadDate":"00000000","valueAddedTax":"0","currentMeterReading1":"8487","currentMeterReading2":"0","currentMeterReading3":"0","totalElectricityBill":"000000008309","previousMeterReading1":"8458","previousMeterReading2":"0","previousMeterReading3":"0"}],"totalAdminCharges":"2500","totalOutstandingBill":"1","inquiryReferenceNumber":"744B0D033FC64E55BA50000000000000","powerConsumingCategory":"450","subscriberSegmentation":"  S2"},"prv":"hpay","daya":"450","ket1":"MUSHOLA MIFTAHUL JANNAH  ","ket2":"201711","ket3":"","nama":"simulator MUSHOLA MIFTAHUL JANNAH  ","reff":"0BNS25AF11F22199E243B889416D3AD9","denda":0,"idpel":"538711365154","saldo":405381,"tarif":"  S2","waktu":"2017-11-16 16:51:24","amount":8182,"detail":[{"adm":2500,"denda":"0","periode":"201711","tagihan":8309,"meter_kini":"8487","meter_lalu":"8458","total_tagihan":10809}],"lembar":1,"produk":"PLN","userID":"1001010","periode":"201711","product":"PLN","tagihan":8182,"traceId":222105848385,"loadTime":"0.2454","produk_tipe":"POSTPAID","tipe_request":"payment","response_code":"0000","total_tagihan":10682,"product_detail":"POSTPAID","response_message":"OK"}';
        }
        return $response;
    }
    
    public static function plnprepaid($jenis) {
        if($jenis == 'inq'){
            $response = '{"ket1":"M. MUQTAFIN ABDULLAH     ","reff":"simulator72D23145C06C4EF8A9A0000000000000","nama":"M. MUQTAFIN ABDULLAH     ","serial_meter":"56600276184","idpel":"821299256363","daya":"000000900","golongan":"R1M ","adm":2000,"tagihan":0,"total_tagihan":2000,"response_code":"0000","response_message":"OK","ori":{"adminCharge":"0","distributionCode":"52","flag":"1","maxKWHLimit":"648","meterSerialNumber":"56600276184","minorUnitofAdminCharge":"2","plnRefNumber":{"0":"                                "},"powerConsumingCategory":"000000900","serviceUnit":"52351","serviceUnitPhone":"123            ","subscriberId":"523511732557","subscriberName":"M. MUQTAFIN ABDULLAH     ","subscriberSegmentation":"R1M ","swRefNumber":"simulator72D23145C06C4EF8A9A0000000000000","switcherId":"0000000","totalAmount":"0","totalRepeat":"0"},"loadTime":"0.0004","tipe_request":"inquiry","prv":"hpay","userID":"1001010","product":"PLN","produk":"PLN","product_detail":"PREPAID","produk_tipe":"PREPAID","traceId":222111331293}';
        }else{
            $response = '{"adm":2000,"ori":{"flag":"1","infoText":"Informasi Hubungi Call Center 123 Atau hubungi PLN Terdekat ","traceNum":"000000000072","stampDuty":"0","switcherId":"0000000","adminCharge":"250000","maxKWHLimit":"648","serviceUnit":"52351","swRefNumber":"0BNS252CC908F1BD30478A86C800743B","tokenNumber":"02385796156021148639","totalAmount":"22500","totalRepeat":"0","plnRefNumber":{"0":"                                "},"subscriberId":"523511732557","buyingOptions":"0","powerPurchase":"1834800","valueAddedTax":"0","subscriberName":"M. MUQTAFIN ABDULLAH     ","purchaseKWHUnit":"1360","distributionCode":"52","inquiryRefNumber":"8573CB6142B1495E9F30000000000000","serviceUnitPhone":"123            ","meterSerialNumber":"56600276184","publicLightingTax":"165200","minorUnitStampDuty":"2","vendingReceiptNumber":"00000000","minorUnitofAdminCharge":"2","powerConsumingCategory":"000000900","subscriberSegmentation":"R1M ","minorUnitOfPowerPurchase":"2","minorUnitOfValueAddedTax":"2","customerPayablesInstallment":"0","minorUnitOfPurchasedKWHUnit":"2","minorUnitOfPublicLightingTax":"2","minorUnitCustomerPayablesInstallment":"2"},"ppj":1652,"ppn":0,"prv":"hpay","daya":"000000900","ket1":"M. MUQTAFIN ABDULLAH     ","ket2":"02385796156021148639","ket3":"","nama":"simulator M. MUQTAFIN ABDULLAH     ","reff":"0BNS252CC908F1BD30478A86C800743B","idpel":"523511732557","saldo":103740555000,"tarif":"R1M ","token":"02385796156021148639","waktu":"2017-07-14 14:35:08","amount":"50000","lembar":1,"produk":"PLN","stroom":18348,"userID":"1001010","jml_kwh":13.6,"materai":0,"product":"PLN","tagihan":"50000","traceId":222111002567,"loadTime":"0.3813","no_meter":"56600276184","produk_tipe":"PREPAID","tipe_request":"payment","response_code":"0000","total_tagihan":52000,"product_detail":"PREPAID","response_message":"SUKSES"}';
        }
        return $response;
    }
    
    public static function plnnontaglist($jenis) {
        if($jenis == 'inq'){
            $response = '';
        }else{
            $response = '';
        }
        return $response;
    }
    
    public static function pulsa($jenis) {
        $response = '{"detail": {"voucherSerialNumber": "0055441130088279"},"response_code": "0000","response_message": "OK"}';
        return $response;
    }
    
    public static function telkomtelepon($jenis) {
        if($jenis == 'inq'){
            $response = '{"trxId":"110334","response_code":"0000","response_message":"OK","ket1":" donny alvaro                 ","tagihan":4080,"total_tagihan":4080,"lembar":1,"detail":{"jastelBills":{"@attributes":{"index":"1"},"bulanTag":"201711","nilaiTagihan":"4080","noRef":"711A       "},"jmlBill":"1","kodeArea":"0022","kodeDatel":"0006","kodeDivre":"03","namaPelanggan":" donny alvaro                 ","noTelp":"020270688","npwp":"              0"},"loadTime":"0.0004","tipe_request":"inquiry","prv":"hpay","userID":"1001010","idpel":"478566593424","product":"TELKOM","produk":"TELKOM","product_detail":"TELEPON","produk_tipe":"TELEPON","traceId":222132713918,"adm":2500}';
        }else{
            $response = '{"content":{"jastelBills":{"@attributes":{"index":"1"},"bulanTag":"201711","nilaiTagihan":"4080","noRef":"711A "},"jmlBill":"1","kodeArea":"0022","kodeDatel":"0006","kodeDivre":"03","namaPelanggan":" donny alvaro ","noTelp":"020270688"},"trxId":"110341","response_code":"0000","response_message":"OK","ket1":" donny alvaro ","tagihan":"4080","total_tagihan":410595,"detail":{"jastelBills":{"@attributes":{"index":"1"},"bulanTag":"201711","nilaiTagihan":"4080","noRef":"711A "},"jmlBill":"1","kodeArea":"0022","kodeDatel":"0006","kodeDivre":"03","namaPelanggan":" donny alvaro ","noTelp":"020270688"},"loadTime":"2.0043","tipe_request":"payment","prv":"hpay","userID":"1001010","idpel":"022-20270688","product":"TELKOM","produk":"TELKOM","product_detail":"TELEPON","produk_tipe":"TELEPON","traceId":222132713918,"amount":"4080","saldo":894149,"waktu":"2017-11-07 04:53:58","adm":2500}';
        }
        return $response;
    }
    
    public static function telkomspeedy($jenis) {
        if($jenis == 'inq'){
            $response = '{"trxId":"110334","response_code":"0000","response_message":"OK","ket1":" donny alvaro                 ","tagihan":4080,"total_tagihan":4080,"lembar":1,"detail":{"jastelBills":{"@attributes":{"index":"1"},"bulanTag":"201711","nilaiTagihan":"4080","noRef":"711A       "},"jmlBill":"1","kodeArea":"0022","kodeDatel":"0006","kodeDivre":"03","namaPelanggan":" donny alvaro                 ","noTelp":"020270688","npwp":"              0"},"loadTime":"0.0004","tipe_request":"inquiry","prv":"hpay","userID":"1001010","idpel":"478566593424","product":"TELKOM","produk":"TELKOM","product_detail":"TELEPON","produk_tipe":"TELEPON","traceId":222132713918,"adm":2500}';
        }else{
            $response = '{"content":{"jastelBills":{"@attributes":{"index":"1"},"bulanTag":"201711","nilaiTagihan":"4080","noRef":"711A "},"jmlBill":"1","kodeArea":"0022","kodeDatel":"0006","kodeDivre":"03","namaPelanggan":" donny alvaro ","noTelp":"020270688"},"trxId":"110341","response_code":"0000","response_message":"OK","ket1":" donny alvaro ","tagihan":"4080","total_tagihan":410595,"detail":{"jastelBills":{"@attributes":{"index":"1"},"bulanTag":"201711","nilaiTagihan":"4080","noRef":"711A "},"jmlBill":"1","kodeArea":"0022","kodeDatel":"0006","kodeDivre":"03","namaPelanggan":" donny alvaro ","noTelp":"020270688"},"loadTime":"2.0043","tipe_request":"payment","prv":"hpay","userID":"1001010","idpel":"022-20270688","product":"TELKOM","produk":"TELKOM","product_detail":"TELEPON","produk_tipe":"TELEPON","traceId":222132713918,"amount":"4080","saldo":894149,"waktu":"2017-11-07 04:53:58","adm":2500}';
        }
        return $response;
    }
    
    public static function telkomvision($jenis) {
        if($jenis == 'inq'){
            $response = '';
        }else{
            $response = '';
        }
        return $response;
    }
    
    public static function telkomhalo($jenis) {
        if($jenis == 'inq'){
            $response = '';
        }else{
            $response = '';
        }
        return $response;
    }
    
    public static function bpjskesehatan($jenis) {
        if($jenis == 'inq'){
            $response = '';
        }else{
            $response = '';
        }
        return $response;
    }

}
