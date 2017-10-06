<?php

class Import_DB extends ZeCtrl
{
    public function view(){
        $this->load->view('/import_DB/view');
    }

    private $old;
    private $step = 3000;

    private $users_i = [];
    private $account_families_i = [];
    private $modalities_i = [];
    private $taxes_i = [];
    private $product_categories_i = [];
    private $product_stocks_i = [];
    private $products_i = [];
    private $contacts_i = [];
    private $companies_i = [];
    private $destinations_i = [];
    private $abonnements_i = [];
    private $numbers_i = [];
    private $warehouses_i = [];
    private $order_lines_i = [];
    private $publications_i = [];
    private $invoices_i = [];
    private $countries_i = [
        "3" => "8",
        "4" => "1",
        "5" => "4",
        "6" => "21",
        "7" => "231",
        "8" => "30",
        "9" => "230",
        "10" => "38",
        "11" => "40",
        "12" => "188",
        "13" => "44",
        "14" => "2",
        "15" => "49",
        "16" => "3",
        "17" => "54",
        "18" => "34",
        "19" => "233",
        "20" => "58",
        "21" => "236",
        "22" => "60",
        "23" => "63",
        "24" => "64",
        "25" => "68",
        "26" => "5",
        "27" => "76",
        "28" => "69",
        "29" => "71",
        "30" => "28",
        "31" => "32",
        "32" => "74",
        "33" => "20",
        "34" => "82",
        "35" => "217",
        "36" => "81",
        "37" => "6",
        "38" => "86",
        "39" => "7",
        "40" => "8",
        "41" => "91",
        "42" => "9",
        "43" => "102",
        "44" => "241",
        "45" => "22",
        "46" => "143",
        "47" => "110",
        "48" => "111",
        "49" => "113",
        "50" => "112",
        "51" => "26",
        "52" => "109",
        "53" => "29",
        "54" => "10",
        "55" => "11",
        "56" => "117",
        "57" => "119",
        "58" => "122",
        "59" => "125",
        "60" => "126",
        "61" => "129",
        "62" => "131",
        "63" => "12",
        "64" => "134",
        "65" => "136",
        "66" => "137",
        "67" => "138",
        "68" => "152",
        "69" => "145",
        "70" => "148",
        "71" => "",
        "72" => "160",
        "73" => "31",
        "74" => "23",
        "75" => "158",
        "76" => "169",
        "77" => "27",
        "78" => "165",
        "79" => "170",
        "80" => "13",
        "81" => "171",
        "82" => "14",
        "83" => "15",
        "84" => "36",
        "85" => "17",
        "86" => "177",
        "87" => "189",
        "88" => "192",
        "89" => "25",
        "90" => "37",
        "91" => "193",
        "92" => "198",
        "93" => "18",
        "94" => "19",
        "95" => "",
        "96" => "203",
        "97" => "",
        "98" => "67",
        "99" => "16",
        "100" => "33",
        "101" => "210",
        "102" => "211",
        "103" => "216",
        "104" => "218",
        "105" => "221",
        "106" => "",
        "107" => "",
        "108" => "24",
        "109" => "70",
        "110" => "",
        "111" => "142",
        "112" => "144",
        "113" => "164",
        "114" => "48",
        "115" => "220",
        "116" => "175",
        "117" => "51",
        "118" => "206",
        "119" => "87",
        "120" => "153",
        "121" => "25",
        "122" => "242",
        "123" => "223",
        "124" => "131",
        "125" => "",
        "126" => "176",
        "127" => "141",
        "128" => "191",
        "129" => "98",
        "130" => "130",
        "131" => "",
        "132" => "139",
        "133" => "190",
        "134" => "",
        "135" => "",
        "136" => "41",
        "137" => "42",
        "138" => "43",
        "139" => "157",
        "140" => "45",
        "141" => "46",
        "142" => "47",
        "143" => "50",
        "144" => "53",
        "145" => "55",
        "146" => "56",
        "147" => "",
        "148" => "",
        "149" => "57",
        "150" => "234",
        "151" => "59",
        "152" => "62",
        "153" => "237",
        "154" => "65",
        "155" => "",
        "156" => "238",
        "157" => "",
        "158" => "239",
        "159" => "72",
        "160" => "240",
        "161" => "121",
        "162" => "73",
        "163" => "75",
        "164" => "77",
        "165" => "79",
        "166" => "78",
        "167" => "83",
        "168" => "85",
        "169" => "133",
        "170" => "89",
        "171" => "90",
        "172" => "92",
        "173" => "93",
        "174" => "196",
        "175" => "94",
        "176" => "97",
        "177" => "",
        "178" => "95",
        "179" => "96",
        "180" => "99",
        "181" => "100",
        "182" => "101",
        "183" => "84",
        "184" => "103",
        "185" => "104",
        "186" => "105",
        "187" => "106",
        "188" => "108",
        "189" => "115",
        "190" => "116",
        "191" => "118",
        "192" => "123",
        "193" => "120",
        "194" => "",
        "195" => "124",
        "196" => "127",
        "197" => "128",
        "198" => "135",
        "199" => "88",
        "200" => "114",
        "201" => "163",
        "202" => "140",
        "203" => "35",
        "204" => "146",
        "205" => "",
        "206" => "149",
        "207" => "150",
        "208" => "151",
        "209" => "154",
        "210" => "155",
        "211" => "156",
        "212" => "159",
        "213" => "161",
        "214" => "162",
        "215" => "235",
        "216" => "215",
        "217" => "219",
        "218" => "166",
        "219" => "167",
        "220" => "168",
        "221" => "172",
        "222" => "173",
        "223" => "174",
        "224" => "",
        "225" => "",
        "226" => "178",
        "227" => "226",
        "228" => "179",
        "229" => "",
        "230" => "186",
        "231" => "182",
        "232" => "183",
        "233" => "184",
        "234" => "",
        "235" => "181",
        "236" => "194",
        "237" => "39",
        "238" => "185",
        "239" => "187",
        "240" => "195",
        "241" => "197",
        "242" => "199",
        "243" => "200",
        "244" => "201",
        "245" => "202",
        "246" => "204",
        "247" => "205",
        "248" => "",
        "249" => "",
        "250" => "",
        "251" => "243",
        "252" => "",
        "253" => "",
        "254" => "80",
        "255" => "207",
        "256" => "208",
        "257" => "209",
        "258" => "212",
        "259" => "213",
        "260" => "214",
        "261" => "107",
        "262" => "224",
        "263" => "222",
        "264" => "225",
        "265" => "227",
        "266" => "228",
        "267" => "229"
    ];

    public function process($step = '0', $offset = '0'){
        $this->old = new mysqli("127.0.0.1", "root", "root", "quiltmania_import");

        $this->load_tables();
        $this->load_concordance_arrays();

        switch ($step){
            case "1" :
                $this->import_user($offset);
                break;
            case "2" :
                $this->import_product_category($offset);
                break;
            case "3" :
                $this->import_product_stock($offset);
                break;
            case "4" :
                $this->import_product($offset);
                break;
            case "5" :
                $this->import_stock_movement($offset);
                break;
            case "6" :
                $this->import_contact($offset);
                break;
            case "7" :
                $this->import_zone_port($offset);
                break;
            case "8" :
                $this->import_publication($offset);
                break;
            case "9" :
                $this->import_abonnement($offset);
                break;
            case "10" :
                $this->import_delivery($offset);
                break;
            case "11" :
                $this->import_quote($offset);
                break;
            case "12" :
                $this->import_order($offset);
                break;
            case "13" :
                $this->import_invoice($offset);
                break;
            case "14" :
                $this->import_abonnement_client($offset);
                break;
            case "15" :
                $this->import_payments($offset);
                break;
            case "0" :
            default:
                $this->empty_tables();

                $this->import_taxes();
                $this->import_accounting_numbers();
                $this->import_warehouses();
                $this->import_modality();
                $this->import_account_family();

                break;
        }

        $this->save_concordance_arrays();

        $this->old->close();
    }

    public function getSizeOf($step = '0'){
        $this->old = new mysqli("127.0.0.1", "root", "root", "quiltmania_import");

        switch ($step){
            case "1" :
                echo $this->count_rows_of('utilisateur');
                break;
            case "2" :
                echo $this->count_rows_of('produit_categorie');
                break;
            case "3" :
                echo $this->count_rows_of('stock_article');
                break;
            case "4" :
                echo $this->count_rows_of('produit', "CODE_ABONNEMENT = ''");
                break;
            case "5" :
                echo $this->count_rows_of('stock_mouvement');
                break;
            case "6" :
                echo $this->count_rows_of('contact');
                break;
            case "7" :
                echo $this->count_rows_of('zone_port');
                break;
            case "8" :
                echo $this->count_rows_of('publication');
                break;
            case "9" :
                echo $this->count_rows_of('abonnement');
                break;
            case "10" :
                echo $this->count_rows_of('bon_livraison');
                break;
            case "11" :
                echo $this->count_rows_of('devis');
                break;
            case "12" :
                echo $this->count_rows_of('commande');
                break;
            case "13" :
                echo $this->count_rows_of('facture');
                break;
            case "14" :
                echo $this->count_rows_of('abonnement_client');
                break;
            case "15" :
                echo $this->count_rows_of('encaissement');
                break;
            case "0" :
            default:
                echo 1;

                break;
        }

        $this->old->close();
    }

    private function load_tables(){
        $this->load->model("Zeapps_taxes", "taxes", "com_zeapps_crm");
        $this->load->model("Zeapps_accounting_numbers", "accounting_numbers", "com_zeapps_crm");
        $this->load->model("Zeapps_warehouses", "warehouses", "com_zeapps_crm");
        $this->load->model("Zeapps_modalities", "modalities", "com_zeapps_crm");
        $this->load->model("Zeapps_account_families", "account_families", "com_zeapps_contact");
        $this->load->model("Zeapps_users", "users");
        $this->load->model("Zeapps_product_categories", "product_categories", "com_zeapps_crm");
        $this->load->model("Zeapps_product_stocks", "product_stocks", "com_zeapps_crm");
        $this->load->model("Zeapps_product_products", "product_products", "com_zeapps_crm");
        $this->load->model("Zeapps_product_lines", "product_lines", "com_zeapps_crm");
        $this->load->model("Zeapps_stock_movements", "stock_movements", "com_zeapps_crm");
        $this->load->model("Zeapps_contacts", "contacts", "com_zeapps_contact");
        $this->load->model("Zeapps_companies", "companies", "com_zeapps_contact");
        $this->load->model("Com_quiltmania_destinations", "destinations", "com_quiltmania_abonnement");
        $this->load->model("Com_quiltmania_publications", "publications", "com_quiltmania_abonnement");
        $this->load->model("Com_quiltmania_abonnements", "abonnements", "com_quiltmania_abonnement");
        $this->load->model("Com_quiltmania_repartitions", "repartitions", "com_quiltmania_abonnement");
        $this->load->model("Com_quiltmania_packs", "packs", "com_quiltmania_abonnement");
        $this->load->model("Com_quiltmania_pack_lines", "pack_lines", "com_quiltmania_abonnement");
        $this->load->model("Com_quiltmania_abonnement_clients", "abonnement_clients", "com_quiltmania_abonnement");
        $this->load->model("Com_quiltmania_abonnement_client_details", "abonnement_client_details", "com_quiltmania_abonnement");
        $this->load->model("Zeapps_deliveries", "deliveries", "com_zeapps_crm");
        $this->load->model("Zeapps_delivery_lines", "delivery_lines", "com_zeapps_crm");
        $this->load->model("Zeapps_quotes", "quotes", "com_zeapps_crm");
        $this->load->model("Zeapps_quote_lines", "quote_lines", "com_zeapps_crm");
        $this->load->model("Zeapps_invoices", "invoices", "com_zeapps_crm");
        $this->load->model("Zeapps_invoice_lines", "invoice_lines", "com_zeapps_crm");
        $this->load->model("Zeapps_orders", "orders", "com_zeapps_crm");
        $this->load->model("Zeapps_order_lines", "order_lines", "com_zeapps_crm");
        $this->load->model("Zeapps_accounting_entries", "accounting_entries", "com_zeapps_crm");
        $this->load->model("Zeapps_credit_balance_details", "credit_balance_details", "com_zeapps_crm");
        $this->load->model("zeapps_country", "country");


        $this->load->model("Concordance_tables", "concordance_tables");
    }

    private function empty_tables(){
        $this->taxes->query('TRUNCATE zeapps_taxes');
        $this->accounting_numbers->query('TRUNCATE zeapps_accounting_numbers');
        $this->warehouses->query('TRUNCATE zeapps_warehouses');
        $this->modalities->query('TRUNCATE zeapps_modalities');
        $this->account_families->query('TRUNCATE zeapps_account_families');
        $this->product_categories->query('TRUNCATE zeapps_product_categories');
        $this->product_stocks->query('TRUNCATE zeapps_product_stocks');
        $this->product_products->query('TRUNCATE zeapps_product_products');
        $this->product_lines->query('TRUNCATE zeapps_stock_movements');
        $this->stock_movements->query('TRUNCATE zeapps_stock_movements');
        $this->contacts->query('TRUNCATE zeapps_contacts');
        $this->companies->query('TRUNCATE zeapps_companies');
        $this->destinations->query('TRUNCATE com_quiltmania_destinations');
        $this->publications->query('TRUNCATE com_quiltmania_publications');
        $this->abonnements->query('TRUNCATE com_quiltmania_abonnements');
        $this->repartitions->query('TRUNCATE com_quiltmania_repartitions');
        $this->abonnements->query('TRUNCATE com_quiltmania_packs');
        $this->abonnements->query('TRUNCATE com_quiltmania_pack_lines');
        $this->abonnement_clients->query('TRUNCATE com_quiltmania_abonnement_clients');
        $this->abonnement_client_details->query('TRUNCATE com_quiltmania_abonnement_client_details');
        $this->deliveries->query('TRUNCATE zeapps_deliveries');
        $this->delivery_lines->query('TRUNCATE zeapps_delivery_lines');
        $this->quotes->query('TRUNCATE zeapps_quotes');
        $this->quote_lines->query('TRUNCATE zeapps_quote_lines');
        $this->invoices->query('TRUNCATE zeapps_invoices');
        $this->invoice_lines->query('TRUNCATE zeapps_invoice_lines');
        $this->orders->query('TRUNCATE zeapps_orders');
        $this->order_lines->query('TRUNCATE zeapps_order_lines');
        $this->accounting_entries->query('TRUNCATE zeapps_accounting_entries');
        $this->credit_balance_details->query('TRUNCATE zeapps_credit_balance_details');

        
        $this->concordance_tables->query('TRUNCATE concordance_tables');
    }

    private function load_concordance_arrays(){
        if($tables = $this->concordance_tables->all()){
            foreach($tables as $table){
                $key = $table->id;
                $value = json_decode($table->value, true);

                $this->$key = $value ?: [];
            }
        }
    }

    private function save_concordance_arrays(){
        $this->concordance_tables->delete(['1 >' => 0], true);

        $this->concordance_tables->insert(array('id' => "users_i", 'value' => json_encode($this->users_i)));
        $this->concordance_tables->insert(array('id' => "account_families_i", 'value' => json_encode($this->account_families_i)));
        $this->concordance_tables->insert(array('id' => "modalities_i", 'value' => json_encode($this->modalities_i)));
        $this->concordance_tables->insert(array('id' => "taxes_i", 'value' => json_encode($this->taxes_i)));
        $this->concordance_tables->insert(array('id' => "product_categories_i", 'value' => json_encode($this->product_categories_i)));
        $this->concordance_tables->insert(array('id' => "product_stocks_i", 'value' => json_encode($this->product_stocks_i)));
        $this->concordance_tables->insert(array('id' => "products_i", 'value' => json_encode($this->products_i)));
        $this->concordance_tables->insert(array('id' => "contacts_i", 'value' => json_encode($this->contacts_i)));
        $this->concordance_tables->insert(array('id' => "companies_i", 'value' => json_encode($this->companies_i)));
        $this->concordance_tables->insert(array('id' => "destinations_i", 'value' => json_encode($this->destinations_i)));
        $this->concordance_tables->insert(array('id' => "abonnements_i", 'value' => json_encode($this->abonnements_i)));
        $this->concordance_tables->insert(array('id' => "numbers_i", 'value' => json_encode($this->numbers_i)));
        $this->concordance_tables->insert(array('id' => "warehouses_i", 'value' => json_encode($this->warehouses_i)));
        $this->concordance_tables->insert(array('id' => "order_lines_i", 'value' => json_encode($this->order_lines_i)));
        $this->concordance_tables->insert(array('id' => "publications_i", 'value' => json_encode($this->publications_i)));
        $this->concordance_tables->insert(array('id' => "invoices_i", 'value' => json_encode($this->invoices_i)));
    }

    private function count_rows_of($table = null, $where = null){
        $count = 0;

        if($table){
            $query = "SELECT COUNT(*) as count FROM ".$table;
            if($where){
                $query .= " WHERE ".$where;
            }
            if($rows = $this->old->query($query)){
                foreach($rows as $row){
                    $count = $row['count'];
                }
            }
        }

        return $count;
    }

// zeapps_taxes
    private function import_taxes()
    {
        if($rows = $this->old->query("SELECT * FROM taux_tva")) {
            foreach($rows as $row) {
                $data = array(
                    "label" => $this->convert($row['LIBELLE']),
                    "value" => $row['TAUX'],
                    "accounting_number" => $row['C_COMPTE_COMPTA'],
                    "active" => "1"
                );
                $this->taxes_i[$row['C_TAUX_TVA']] = $this->taxes->insert($data);
            }
        }
    }

// zeapps_accounting_numbers
    private function import_accounting_numbers()
    {
        if($rows = $this->old->query("SELECT * FROM plan_comptable_controle")) {
            foreach($rows as $row) {
                $data = array(
                    "label" => $this->convert($row['libelle']),
                    "number" => $row['numero_compte']
                );
                $id = $this->accounting_numbers->insert($data);
                $this->numbers_i[$row['id']] = $id;
            }
        }
    }

// zeapps_warehouses
    private function import_warehouses()
    {
        if($rows = $this->old->query("SELECT * FROM entrepot")) {
            foreach($rows as $row) {
                $data = array(
                    "label" => $this->convert($row['libelle']),
                    "resupply_delay" => "15",
                    "resupply_unit" => "days",
                    "active" => "1"
                );
                $id = $this->warehouses->insert($data);
                $this->warehouses_i[$row['id']] = $id;
            }
        }
    }

// zeapps_modalities
    private function import_modality()
    {
        if($rows = $this->old->query("SELECT * FROM mode_reglement")) {
            foreach($rows as $row) {
                $data = array(
                    "label" => $this->convert($row['libelle']),
                    "label_doc" => $this->convert($row['libelle_document']),
                    "type" => $this->convert($row['type_reglement']),
                    "id_cheque" => $this->convert($row['identifiant_remise_cheque']),
                    "situation" => $this->convert($row['situation_comptable']),
                    "accounting_account" => $this->convert($row['compte_compta']),
                    "journal" => $this->convert($row['journal']),
                    "sort" => $row['ordre_affichage']
                );
                $id = $this->modalities->insert($data);

                $this->modalities_i[$row['id']] = $id;
            }
        }

        $this->modalities_i['ACB'] = 10;
        $this->modalities_i['ACH'] = 7;
        $this->modalities_i['CB'] = 3;
        $this->modalities_i['CH'] = 2;
        $this->modalities_i['CHC'] = 9;
        $this->modalities_i['ES'] = 1;
        $this->modalities_i['VC'] = 5;
        $this->modalities_i['VP'] = 6;
        $this->modalities_i['AGB'] = 10;
    }

// zeapps_account_families
    private function import_account_family()
    {
        if($rows = $this->old->query("SELECT * FROM menu_perso WHERE menu = 'TYPE_RELATION'")) {
            foreach($rows as $row) {
                $data = array(
                    "label" => $this->convert($row['libelle']),
                    "sort" => $row['ordre']
                );
                $data['id'] = $this->account_families->insert($data);

                $this->account_families_i[$row['valeur']] = $data;
            }
        }
    }

// zeapps_users
    private function import_user($offset = 0)
    {
        if($rows = $this->old->query("SELECT * FROM utilisateur LIMIT ".$this->step." OFFSET ".$offset)) {
            foreach($rows as $row) {
                $data = array(
                    "firstname" => $this->convert($row['PRENOM']),
                    "lastname" => $this->convert($row['NOM']),
                    "email" => $this->convert($row['EMAIL']),
                    "password" => "",
                    "lang" => "fr-fr",
                    "hourly_rate" => $row['cout_horaire']
                );
                $id = $this->users->insert($data);
                $this->users_i[$row['C_UTILISATEUR']] = $id;
            }
        }
    }

// zeapps_product_categories
    private function import_product_category($offset = 0)
    {
        if($rows = $this->old->query("SELECT * FROM produit_categorie LIMIT ".$this->step." OFFSET ".$offset)) {
            foreach($rows as $row) {
                $data = array(
                    "id_parent" => isset($this->product_categories_i[$row['id_parent']]) ? $this->product_categories_i[$row['id_parent']] : 0,
                    "name" => $this->convert($row['libelle']),
                    "sort" => $row['ordre']
                );
                $id = $this->product_categories->insert($data);
                $this->product_categories_i[$row['id']] = $id;
            }
        }
    }

// zeapps_product_stocks
    private function import_product_stock($offset = 0)
    {
        if($rows = $this->old->query("SELECT * FROM stock_article LIMIT ".$this->step." OFFSET ".$offset)) {
            foreach($rows as $row) {
                $data = array(
                    "ref" => $this->convert($row['code']),
                    "label" => $this->convert($row['libelle']),
                    "number" => 0
                );
                $id = $this->product_stocks->insert($data);
                $this->product_stocks_i[$row['id']] = $id;
            }
        }
    }

// zeapps_product_products
    private function import_product($offset = 0)
    {
        if($rows = $this->old->query("SELECT * FROM produit WHERE CODE_ABONNEMENT = '' LIMIT ".$this->step." OFFSET ".$offset)) {
            foreach($rows as $row) {
                // zeapps_product_products
                $data = array(
                    "id_cat" => isset($this->product_categories_i[$row['id_categorie']]) ? $this->product_categories_i[$row['id_categorie']] : 0,
                    "id_stock" => isset($this->product_stocks_i[$row['id_article_stock']]) ? $this->product_stocks_i[$row['id_article_stock']] : 0,
                    "compose" => 0,
                    "ref" => $this->convert($row['CODE_PRODUIT']),
                    "name" => $this->convert($row['LIBELLE']),
                    "description" => $this->convert($row['DESCRIPTIF']),
                    "auto" => "1"
                );

                if($res = $this->old->query("SELECT * FROM produit_tarif WHERE C_PRODUIT = ".$row['C_PRODUIT'])){
                    foreach($res as $re) {
                        $data['id_taxe'] = $re['C_TAUX_TVA'] > 0 ? $this->taxes_i[$re['C_TAUX_TVA']] : 0;
                        $data['accounting_number'] = $re['COMPTE_COMPTA'];
                        $data['price_ht'] = floatval($re['TARIF_HT']);
                        if ($taxe = $this->taxes->get($data['id_taxe'])) {
                            $data['value_taxe'] = floatval($taxe->value);
                        }
                        else{
                            $data['value_taxe'] = 0;
                        }

                        $data['price_ttc'] = round($data['price_ht'] * ( 1 + $data['value_taxe'] / 100), 2);
                    }
                }

                $id = $this->product_products->insert($data);
                $this->products_i[$row['C_PRODUIT']] = $id;
            }
        }
    }

// zeapps_stock_movements
    private function import_stock_movement($offset = 0)
    {
        if($rows = $this->old->query("SELECT * FROM stock_mouvement LIMIT ".$this->step." OFFSET ".$offset)) {
            foreach($rows as $row) {
                if($row['id_commande_client'] !== '0') {
                    $id_table = $row['id_commande_client'];
                    $name_table = "zeapps_orders";
                }
                elseif($row['id_bl_client'] !== '0') {
                    $id_table = $row['id_bl_client'];
                    $name_table = "zeapps_deliveries";
                }
                elseif($row['id_commande_fournisseur'] !== '0') {
                    $id_table = $row['id_ligne_fournisseur'];
                    $name_table = "zeapps_stock_movements";
                }
                else {
                    $id_table = 0;
                    $name_table = "zeapps_stock_movements";
                }

                if(isset($this->products_i[$row['id_article']]) && $product = $this->product_products->get($this->products_i[$row['id_article']])){
                    $id_stock = $product->id_stock;
                }
                else{
                    $id_stock = 0;
                }

                $data = array(
                    "id_warehouse" => $this->warehouses_i[$row['id_entrepot']],
                    "id_stock" => $id_stock,
                    "label" => $this->convert($row['designation']),
                    "qty" => $row['quantite'],
                    "id_table" => $id_table,
                    "name_table" => $name_table,
                    "date_mvt" => $row['date_entree'],
                    "ignored" => ""
                );

                $this->stock_movements->insert($data);
            }
        }
    }

// zeapps_contacts + zeapps_companies
// require : zeapps_users + zeapps_account_families + zeapps_countries
    private function import_contact($offset = 0)
    {
        if($rows = $this->old->query("SELECT * FROM contact LIMIT ".$this->step." OFFSET ".$offset)) {
            foreach($rows as $row) {
                $address = false;
                if($res = $this->old->query("SELECT * FROM adresse WHERE C_CONTACT = ".$row['C_CONTACT']." AND C_ADR_PRINCIPALE = 'Y'")) {
                    foreach($res as $re) {
                        $address = $re;
                    }
                }

                if(isset($this->users_i[$row['C_UTILISATEUR']])) {
                    $user = $this->users->get($this->users_i[$row['C_UTILISATEUR']]);
                    $manager_name = $user->firstname . " " . $user->lastname;
                    $manager_id = $user->id;
                }
                else{
                    $manager_name = "";
                    $manager_id = 0;
                }

                if(isset($this->countries_i[$address['C_PAYS']])) {
                    if($country = $this->country->get(array('zeapps_country.id' => $this->countries_i[$address['C_PAYS']], 'zeapps_country_lang.id_lang' => "1"))){
                        $country_id = $country[0]->id_country;
                        $country_name = $country[0]->name;
                    }
                    else{
                        $country_id = 0;
                        $country_name = "";
                    }
                }
                else{
                    $country_id = 0;
                    $country_name = "";
                }

                $account_family = $this->account_families->get($this->account_families_i[$row['C_TYPE_RELATION']]);
                if ($row['C_TYPE_CONTACT'] === "PP") {
                    // zeapps_contacts
                    $data = array(
                        "id_user_account_manager" => $this->convert($manager_id),
                        "name_user_account_manager" => $this->convert($manager_name),
                        "id_account_family" => $account_family->id,
                        "name_account_family" => $this->convert($account_family->label),
                        "title_name" => $this->convert($row['PP_C_CIVILITE']),
                        "first_name" => $this->convert($row['PP_PRENOM']),
                        "last_name" => $this->convert($row['PP_NOM']),
                        "email" => $this->convert($row['PP_EMAIL']),
                        "phone" => $address !== false ? $address['TEL_DOMICILE'] : "",
                        "other_phone" => $address !== false ? $address['TEL_BUREAU'] : "",
                        "mobile" => $address !== false ? $address['TEL_PORTABLE'] : "",
                        "fax" => $address !== false ? $address['FAX'] : "",
                        "date_of_birth" => $row['PP_DA_NAISSANCE'],
                        "address_1" => $address !== false ? $this->convert($address['LIGNE_1']) : "",
                        "address_2" => $address !== false ? $this->convert($address['LIGNE_2']) : "",
                        "address_3" => $address !== false ? $this->convert($address['LIGNE_3']) : "",
                        "city" => $address !== false ? $this->convert($address['COMMUNE']) : "",
                        "zipcode" => $address !== false ? $this->convert($address['CODE_POSTAL']) : "",
                        "country_id" => $country_id,
                        "country_name" => $country_name,
                        "comment" => $this->convert($row['COMMENTAIRE']),
                        "website_url" => $address ? $this->convert($address['SITEWEB']) : "",
                        "accounting_number" => $row['C_COMPTE_COMPTA']
                    );

                    $id = $this->contacts->insert($data);
                    $this->contacts_i[$row['C_CONTACT']] = $id;
                } elseif ($row['C_TYPE_CONTACT'] === "PM") {
                    // zeapps_companies
                    $data = array(
                        "id_user_account_manager" => $manager_id,
                        "name_user_account_manager" => $this->convert($manager_name),
                        "id_account_family" => isset($this->account_families_i[$row['C_TYPE_RELATION']]) ? $this->account_families_i[$row['C_TYPE_RELATION']] : 0,
                        "company_name" => $this->convert($row['PM_RAISON_SOCIALE']),
                        "name_parent_company" => $this->convert($row['PM_GROUPE']),
                        "name_activity_area" => $this->convert($row['secteur_activite']),
                        "billing_address_1" => $address !== false ? $this->convert($address['LIGNE_1']) : "",
                        "billing_address_2" => $address !== false ? $this->convert($address['LIGNE_2']) : "",
                        "billing_address_3" => $address !== false ? $this->convert($address['LIGNE_3']) : "",
                        "billing_city" => $address !== false ? $this->convert($address['COMMUNE']) : "",
                        "billing_zipcode" => $address !== false ? $this->convert($address['CODE_POSTAL']) : "",
                        "billing_country_id" => $country_id,
                        "billing_country_name" => $country_name,
                        "delivery_address_1" => $address !== false ? $this->convert($address['LIGNE_1']) : "",
                        "delivery_address_2" => $address !== false ? $this->convert($address['LIGNE_2']) : "",
                        "delivery_address_3" => $address !== false ? $this->convert($address['LIGNE_3']) : "",
                        "delivery_city" => $address !== false ? $this->convert($address['COMMUNE']) : "",
                        "delivery_zipcode" => $address !== false ? $this->convert($address['CODE_POSTAL']) : "",
                        "delivery_country_id" => $country_id,
                        "delivery_country_name" => $country_name,
                        "comment" => $this->convert($row['COMMENTAIRE']),
                        "email" => $address !== false ? $this->convert($address['EMAIL']) : "",
                        "phone" => $address !== false ? $address['TEL_BUREAU'] : "",
                        "fax" => $address !== false ? $address['FAX'] : "",
                        "website_url" => $address !== false ? $this->convert($address['SITEWEB']) : "",
                        "accounting_number" => $row['C_COMPTE_COMPTA']
                    );

                    $id = $this->companies->insert($data);
                    $this->companies_i[$row['C_CONTACT']] = $id;
                }
            }
        }
    }

// com_quiltmania_destinations
    private function import_zone_port($offset = 0)
    {
        if($rows = $this->old->query("SELECT * FROM zone_port LIMIT ".$this->step." OFFSET ".$offset)) {
            foreach($rows as $row) {
                $data = array(
                    "label" => $this->convert($row['nom_fr'])
                );
                $id = $this->destinations->insert($data);
                $this->destinations_i[$row['id']] = $id;
            }
        }
    }

// com_quiltmania_publications
    private function import_publication($offset = 0)
    {
        if($rows = $this->old->query("SELECT * FROM publication LIMIT ".$this->step." OFFSET ".$offset)) {
            foreach($rows as $row) {
                $data = array(
                    "label" => $this->convert($row['NOM']),
                    "numero_en_cours" => $row['NUMERO_EN_COURS'],
                    "numero_en_cours_compta" => $row['NUMERO_EN_COURS_COMPTA']
                );
                $id = $this->publications->insert($data);
                $this->publications_i[$row['C_PUBLICATION']] = $id;
            }
        }
    }

// com_quiltmania_abonnements + com_quiltamnia_repartitions
// require : com_quiltmania_destinations + com_quiltmania_publications + zeapps_taxes
    private function import_abonnement($offset = 0)
    {
        if($rows = $this->old->query("SELECT * FROM abonnement LIMIT ".$this->step." OFFSET ".$offset)) {
            foreach($rows as $row) {
                $i = 0;
                if($res = $this->old->query("SELECT * FROM abonnement_publication WHERE C_ABONNEMENT = ".$row['C_ABONNEMENT'])){
                    foreach($res as $re){
                        $id_publication = $re['C_PUBLICATION'];
                        $qty = $re['NB_NUMERO'];
                        $i++;
                    }
                }
                else{
                    $id_publication = 0;
                    $qty = 0;
                }

                if($i === 1) {
                    // com_quiltmania_abonnements
                    $data = array(
                        "id_publication" => isset($this->publications_i[$id_publication]) ? $this->publications_i[$id_publication] : 0,
                        "label" => $this->convert($row['NOM']),
                        "qty" => $qty
                    );
                    $id = $this->abonnements->insert($data);
                    $this->abonnements_i[$row['C_ABONNEMENT']] = $id;

                    if ($res = $this->old->query("SELECT * FROM abonnement_produit WHERE CODE_ABONNEMENT = '" . $row['CODE_ABONNEMENT'] . "'")) {
                        foreach ($res as $re) {
                            $code_produit = $re['CODE_PRODUIT'];
                            $code_zone_port = $re['C_ZONE_PORT'];

                            $produit_tarifs = [];

                            // com_quiltamnia_repartitions
                            $data = array(
                                "id_abonnement" => $row['C_ABONNEMENT'],
                                "id_destination" => isset($this->destinations_i[$code_zone_port]) ? $this->destinations_i[$code_zone_port] : 0,
                                "active" => "1",
                                "code_article" => $this->convert($code_produit)
                            );
                            if ($results = $this->old->query("SELECT * FROM produit_tarif t LEFT JOIN produit p ON t.C_PRODUIT = p.C_PRODUIT LEFT JOIN taux_tva tva ON tva.C_TAUX_TVA = t.C_TAUX_TVA WHERE p.CODE_PRODUIT = '" . $code_produit . "'")) {
                                foreach ($results as $result) {
                                    $produit_tarifs[] = $result;
                                }
                                if ($produit_tarifs[0]['TAUX'] > $produit_tarifs[1]['TAUX']) {
                                    $data['base_ht_abo'] = $produit_tarifs[1]['TARIF_HT'];
                                    $data['value_tva_abo'] = $produit_tarifs[1]['TAUX'];
                                    $data['id_tva_abo'] = isset($this->taxes_i[$produit_tarifs[1]['C_TAUX_TVA']]) ? $this->taxes_i[$produit_tarifs[1]['C_TAUX_TVA']] : 0;
                                    $data['accounting_number_abo'] = $produit_tarifs[1]['COMPTE_COMPTA'];

                                    $data['base_ht_dest'] = $produit_tarifs[0]['TARIF_HT'];
                                    $data['value_tva_dest'] = $produit_tarifs[0]['TAUX'];
                                    $data['id_tva_dest'] = isset($this->taxes_i[$produit_tarifs[0]['C_TAUX_TVA']]) ? $this->taxes_i[$produit_tarifs[0]['C_TAUX_TVA']] : 0;
                                    $data['accounting_number_dest'] = $produit_tarifs[0]['COMPTE_COMPTA'];
                                } else {
                                    $data['base_ht_abo'] = $produit_tarifs[0]['TARIF_HT'];
                                    $data['value_tva_abo'] = $produit_tarifs[0]['TAUX'];
                                    $data['id_tva_abo'] = isset($this->taxes_i[$produit_tarifs[0]['C_TAUX_TVA']]) ? $this->taxes_i[$produit_tarifs[0]['C_TAUX_TVA']] : 0;
                                    $data['accounting_number_abo'] = $produit_tarifs[0]['COMPTE_COMPTA'];

                                    $data['base_ht_dest'] = $produit_tarifs[1]['TARIF_HT'];
                                    $data['value_tva_dest'] = $produit_tarifs[1]['TAUX'];
                                    $data['id_tva_dest'] = isset($this->taxes_i[$produit_tarifs[1]['C_TAUX_TVA']]) ? $this->taxes_i[$produit_tarifs[1]['C_TAUX_TVA']] : 0;
                                    $data['accounting_number_dest'] = $produit_tarifs[1]['COMPTE_COMPTA'];
                                }


                                $data['total_ht'] = floatval($data['base_ht_abo']) + floatval($data['base_ht_dest']);
                                $data['total_ttc'] = (floatval($data['base_ht_abo']) * (1 + (floatval($data['value_tva_abo']) / 100))) + (floatval($data['base_ht_dest']) * (1 + (floatval($data['value_tva_dest']) / 100)));
                            }

                            $this->repartitions->insert($data);
                        }
                    }
                }
                elseif($i > 1){
                    // com_quiltmania_packs
                    if ($rows2 = $this->old->query("SELECT * FROM abonnement_produit WHERE CODE_ABONNEMENT = '" . $row['CODE_ABONNEMENT'] . "'")) {
                        foreach($rows2 as $row2){
                            $code_produit = $row2['CODE_PRODUIT'];

                            if ($results = $this->old->query("SELECT * FROM produit_tarif t LEFT JOIN produit p ON t.C_PRODUIT = p.C_PRODUIT LEFT JOIN taux_tva tva ON tva.C_TAUX_TVA = t.C_TAUX_TVA WHERE p.CODE_PRODUIT = '" . $code_produit . "'")) {
                                $data = array(
                                    "ref" => $this->convert($code_produit),
                                    "label" => $this->convert($row['NOM']),
                                    "total_ttc" => 0
                                );

                                $id_pack = $this->packs->insert($data);
/*
                                foreach ($res as $re) {
                                    var_dump($this->convert($result['CODE_PRODUIT']));
                                    if($repartition = $this->repartitions->get(array('code_article' => $this->convert($result['CODE_PRODUIT'])))) {
                                        $id_repartition = $repartition->id;
                                        $ttc = $repartition->total_ttc;
                                    }
                                    else{
                                        $ttc = 1;
                                        $id_repartition = 0;
                                    }

                                    $prorata = $total_ttc / $ttc;

                                    $data = array(
                                        "id_pack" => $id_pack,
                                        "id_repartition" => $id_repartition,
                                        "prorata" => $prorata
                                    );

                                    $id_pack = $this->pack_lines->insert($data);
                                }
*/
                            }
                        }
                    }
                }
            }
        }
    }

// zeapps_deliveries
    private function import_delivery($offset = 0)
    {
        if($rows = $this->old->query("SELECT * FROM bon_livraison LIMIT ".$this->step." OFFSET ".$offset)) {
            foreach($rows as $row) {
                if(isset($this->contacts_i[$row['C_CONTACT_LIVRAISON']]) && $contact = $this->contacts->get($this->contacts_i[$row['C_CONTACT_LIVRAISON']])){
                    $id = $contact->id;
                    $name = $contact->first_name ." ".$contact->last_name;
                    $address1 = $contact->address_1;
                    $address2 = $contact->address_2;
                    $address3 = $contact->address_3;
                    $city = $contact->city;
                    $zipcode = $contact->zipcode;
                    $state = $contact->state;
                    $country_id = $contact->country_id;
                    $country_name = $contact->country_name;
                    $con = 1;
                    $com = 0;
                }
                elseif(isset($this->companies_i[$row['C_CONTACT_LIVRAISON']]) && $contact = $this->companies->get($this->companies_i[$row['C_CONTACT_LIVRAISON']])){
                    $id = $contact->id;
                    $name = $contact->company_name;
                    $address1 = $contact->delivery_address_1;
                    $address2 = $contact->delivery_address_2;
                    $address3 = $contact->delivery_address_3;
                    $city = $contact->delivery_city;
                    $zipcode = $contact->delivery_zipcode;
                    $state = $contact->delivery_state;
                    $country_id = $contact->delivery_country_id;
                    $country_name = $contact->delivery_country_name;
                    $com = 1;
                    $con = 0;
                }
                else{
                    $id = 0;
                    $name = "";
                    $address1 = "";
                    $address2 = "";
                    $address3 = "";
                    $city = "";
                    $zipcode = "";
                    $state = "";
                    $country_id = 0;
                    $country_name = "";
                    $com = 0;
                    $con = 0;
                }

                if(strstr($row['LIBELLE'], "CDE WEB")){
                    $id_origin = 2;
                }
                else{
                    $id_origin = 1;
                }

                if(isset($this->modalities_i[$row['TYPE_PAIEMENT']]) && $modality = $this->modalities->get($this->modalities_i[$row['TYPE_PAIEMENT']])){
                    $id_modality = $modality->id;
                    $label_modality = $modality->label;
                }
                else{
                    $id_modality = 0;
                    $label_modality = "";
                }

                // zeapps_deliveries
                $data = array(
                    "libelle" => $row['LIBELLE'],
                    "numerotation" => $row['NUMERO_BON'],
                    "id_origin" => $id_origin,
                    "id_company" => $com ? $id : 0,
                    "name_company" => $com ? $name : "",
                    "id_contact" => $con ? $id : "",
                    "name_contact" => $con ? $name : "",
                    "billing_address_1" => $address1,
                    "billing_address_2" => $address2,
                    "billing_address_3" => $address3,
                    "billing_city" => $city,
                    "billing_zipcode" => $zipcode,
                    "billing_state" => $state,
                    "billing_country_id" => $country_id,
                    "billing_country_name" => $country_name,
                    "delivery_address_1" => $address1,
                    "delivery_address_2" => $address2,
                    "delivery_address_3" => $address3,
                    "delivery_city" => $city,
                    "delivery_zipcode" => $zipcode,
                    "delivery_state" => $state,
                    "delivery_country_id" => $country_id,
                    "delivery_country_name" => $country_name,
                    "accounting_number" => $row['COMPTE_CLIENT_COMPTA'],
                    "global_discount" => $row['taux_remise'],
                    "total_ht" => $row['MONTANT_HT'],
                    "total_ttc" => $row['MONTANT_TTC'],
                    "date_creation" => $row['DATE_COMMANDE'],
                    "date_limit" => $row['DATE_LIMITE_PAIEMENT'],
                    "id_modality" => $id_modality,
                    "label_modality" => $label_modality
                );

                $id_delivery = $this->deliveries->insert($data);

                if($rows2 = $this->old->query("SELECT * FROM bon_livraison_ligne WHERE C_BON = ".$row['C_BON'])) {
                    foreach ($rows2 as $row2) {
                        if($res = $this->old->query("SELECT * FROM bon_livraison_ligne_compta WHERE C_BON_LIGNE = ".$row2['C_BON_LIGNE'])) {
                            foreach($res as $re){
                                $taux_tva = $re["TAUX_TVA"];
                                $c_taux_tva = $re["C_TAUX_TVA"];
                                $compte_compta = $re["COMPTE_COMPTA"];
                            }
                        }
                        else{
                            $taux_tva = 0;
                            $c_taux_tva = 0;
                            $compte_compta = "";
                        }
                        // zeapps_delivery_lines
                        $data = array(
                            "id_delivery" => $id_delivery,
                            "type" => 'product',
                            "id_product" => isset($this->products_i[$row2['id_produit']]) ? $this->products_i[$row2['id_produit']] : 0,
                            "ref" => $this->convert($row2['CODE_PRODUIT']),
                            "designation_title" => $this->convert($row2['LIBELLE']),
                            "designation_desc" => $this->convert($row2['DESCRIPTIF']),
                            "qty" => $row2['QUANTITE'],
                            "discount" => $row2['taux_remise'],
                            "price_unit" => $row2['prix_unitaire_ht'],
                            "accounting_number" => $compte_compta,
                            "id_taxe" => isset($this->taxes_i[$c_taux_tva]) ? $this->taxes_i[$c_taux_tva] : 0,
                            "value_taxe" => $taux_tva,
                            "total_ht" => $row2['prix_total_ht'],
                            "total_ttc" => $row2['prix_total_ttc'],
                            "sort" => $row2['ordre']
                        );

                        $this->delivery_lines->insert($data);
                    }
                }
            }
        }
    }

// zeapps_quotes
    private function import_quote($offset = 0)
    {
        if($rows = $this->old->query("SELECT * FROM devis LIMIT ".$this->step." OFFSET ".$offset)) {
            foreach($rows as $row) {
                if(isset($this->contacts_i[$row['C_CONTACT_LIVRAISON']]) && $contact = $this->contacts->get($this->contacts_i[$row['C_CONTACT_LIVRAISON']])){
                    $id = $contact->id;
                    $name = $contact->first_name ." ".$contact->last_name;
                    $address1 = $contact->address_1;
                    $address2 = $contact->address_2;
                    $address3 = $contact->address_3;
                    $city = $contact->city;
                    $zipcode = $contact->zipcode;
                    $state = $contact->state;
                    $country_id = $contact->country_id;
                    $country_name = $contact->country_name;
                    $con = 1;
                    $com = 0;
                }
                elseif(isset($this->companies_i[$row['C_CONTACT_LIVRAISON']]) && $contact = $this->companies->get($this->companies_i[$row['C_CONTACT_LIVRAISON']])){
                    $id = $contact->id;
                    $name = $contact->company_name;
                    $address1 = $contact->delivery_address_1;
                    $address2 = $contact->delivery_address_2;
                    $address3 = $contact->delivery_address_3;
                    $city = $contact->delivery_city;
                    $zipcode = $contact->delivery_zipcode;
                    $state = $contact->delivery_state;
                    $country_id = $contact->delivery_country_id;
                    $country_name = $contact->delivery_country_name;
                    $com = 1;
                    $con = 0;
                }
                else{
                    $id = 0;
                    $name = "";
                    $address1 = "";
                    $address2 = "";
                    $address3 = "";
                    $city = "";
                    $zipcode = "";
                    $state = "";
                    $country_id = 0;
                    $country_name = "";
                    $com = 0;
                    $con = 0;
                }

                if(strstr($row['LIBELLE'], "CDE WEB")){
                    $id_origin = 2;
                }
                else{
                    $id_origin = 1;
                }

                if(isset($this->modalities_i[$row['TYPE_PAIEMENT']]) && $modality = $this->modalities->get($this->modalities_i[$row['TYPE_PAIEMENT']])){
                    $id_modality = $modality->id;
                    $label_modality = $modality->label;
                }
                else{
                    $id_modality = 0;
                    $label_modality = "";
                }

                // zeapps_quotes
                $data = array(
                    "libelle" => $row['LIBELLE'],
                    "numerotation" => $row['NUMERO_DEVIS'],
                    "id_origin" => $id_origin,
                    "id_company" => $com ? $id : 0,
                    "name_company" => $com ? $name : "",
                    "id_contact" => $con ? $id : "",
                    "name_contact" => $con ? $name : "",
                    "billing_address_1" => $address1,
                    "billing_address_2" => $address2,
                    "billing_address_3" => $address3,
                    "billing_city" => $city,
                    "billing_zipcode" => $zipcode,
                    "billing_state" => $state,
                    "billing_country_id" => $country_id,
                    "billing_country_name" => $country_name,
                    "delivery_address_1" => $address1,
                    "delivery_address_2" => $address2,
                    "delivery_address_3" => $address3,
                    "delivery_city" => $city,
                    "delivery_zipcode" => $zipcode,
                    "delivery_state" => $state,
                    "delivery_country_id" => $country_id,
                    "delivery_country_name" => $country_name,
                    "accounting_number" => $row['COMPTE_CLIENT_COMPTA'],
                    "global_discount" => $row['taux_remise'],
                    "total_ht" => $row['MONTANT_HT'],
                    "total_ttc" => $row['MONTANT_TTC'],
                    "date_creation" => $row['DATE_COMMANDE'],
                    "date_limit" => $row['DATE_LIMITE_PAIEMENT'],
                    "id_modality" => $id_modality,
                    "label_modality" => $label_modality
                );

                $id_quote = $this->quotes->insert($data);

                if($rows2 = $this->old->query("SELECT * FROM devis_ligne WHERE C_DEVIS = ".$row['C_DEVIS'])) {
                    foreach ($rows2 as $row2) {
                        if($res = $this->old->query("SELECT * FROM devis_ligne_compta WHERE C_DEVIS_LIGNE = ".$row2['C_DEVIS_LIGNE'])) {
                            foreach($res as $re){
                                $taux_tva = $re["TAUX_TVA"];
                                $c_taux_tva = $re["C_TAUX_TVA"];
                                $compte_compta = $re["COMPTE_COMPTA"];
                            }
                        }
                        else{
                            $taux_tva = 0;
                            $c_taux_tva = 0;
                            $compte_compta = "";
                        }
                        // zeapps_quote_lines
                        $data = array(
                            "id_quote" => $id_quote,
                            "type" => 'product',
                            "id_product" => isset($this->products_i[$row2['id_produit']]) ? $this->products_i[$row2['id_produit']] : 0,
                            "ref" => $this->convert($row2['CODE_PRODUIT']),
                            "designation_title" => $this->convert($row2['LIBELLE']),
                            "designation_desc" => $this->convert($row2['DESCRIPTIF']),
                            "qty" => $row2['QUANTITE'],
                            "discount" => $row2['taux_remise'],
                            "price_unit" => $row2['prix_unitaire_ht'],
                            "accounting_number" => $compte_compta,
                            "id_taxe" => isset($this->taxes_i[$c_taux_tva]) ? $this->taxes_i[$c_taux_tva] : 0,
                            "value_taxe" => $taux_tva,
                            "total_ht" => $row2['prix_total_ht'],
                            "total_ttc" => $row2['prix_total_ttc'],
                            "sort" => $row2['ordre']
                        );

                        $this->quote_lines->insert($data);
                    }
                }
            }
        }
    }

// zeapps_orders
    private function import_order($offset = 0)
    {
        if($rows = $this->old->query("SELECT * FROM commande LIMIT ".$this->step." OFFSET ".$offset)) {
            foreach($rows as $row) {
                if(isset($this->contacts_i[$row['C_CONTACT_LIVRAISON']]) && $contact = $this->contacts->get($this->contacts_i[$row['C_CONTACT_LIVRAISON']])){
                    $id = $contact->id;
                    $name = $contact->first_name ." ".$contact->last_name;
                    $address1 = $contact->address_1;
                    $address2 = $contact->address_2;
                    $address3 = $contact->address_3;
                    $city = $contact->city;
                    $zipcode = $contact->zipcode;
                    $state = $contact->state;
                    $country_id = $contact->country_id;
                    $country_name = $contact->country_name;
                    $con = 1;
                    $com = 0;
                }
                elseif(isset($this->companies_i[$row['C_CONTACT_LIVRAISON']]) && $contact = $this->companies->get($this->companies_i[$row['C_CONTACT_LIVRAISON']])){
                    $id = $contact->id;
                    $name = $contact->company_name;
                    $address1 = $contact->delivery_address_1;
                    $address2 = $contact->delivery_address_2;
                    $address3 = $contact->delivery_address_3;
                    $city = $contact->delivery_city;
                    $zipcode = $contact->delivery_zipcode;
                    $state = $contact->delivery_state;
                    $country_id = $contact->delivery_country_id;
                    $country_name = $contact->delivery_country_name;
                    $com = 1;
                    $con = 0;
                }
                else{
                    $id = 0;
                    $name = "";
                    $address1 = "";
                    $address2 = "";
                    $address3 = "";
                    $city = "";
                    $zipcode = "";
                    $state = "";
                    $country_id = 0;
                    $country_name = "";
                    $com = 0;
                    $con = 0;
                }

                if(strstr($row['LIBELLE'], "CDE WEB")){
                    $id_origin = 2;
                }
                else{
                    $id_origin = 1;
                }

                if(isset($this->modalities_i[$row['TYPE_PAIEMENT']]) && $modality = $this->modalities->get($this->modalities_i[$row['TYPE_PAIEMENT']])){
                    $id_modality = $modality->id;
                    $label_modality = $modality->label;
                }
                else{
                    $id_modality = 0;
                    $label_modality = "";
                }

                // zeapps_orders
                $data = array(
                    "libelle" => $row['LIBELLE'],
                    "numerotation" => $row['NUMERO_COMMANDE'],
                    "id_origin" => $id_origin,
                    "id_company" => $com ? $id : 0,
                    "name_company" => $com ? $name : "",
                    "id_contact" => $con ? $id : "",
                    "name_contact" => $con ? $name : "",
                    "billing_address_1" => $address1,
                    "billing_address_2" => $address2,
                    "billing_address_3" => $address3,
                    "billing_city" => $city,
                    "billing_zipcode" => $zipcode,
                    "billing_state" => $state,
                    "billing_country_id" => $country_id,
                    "billing_country_name" => $country_name,
                    "delivery_address_1" => $address1,
                    "delivery_address_2" => $address2,
                    "delivery_address_3" => $address3,
                    "delivery_city" => $city,
                    "delivery_zipcode" => $zipcode,
                    "delivery_state" => $state,
                    "delivery_country_id" => $country_id,
                    "delivery_country_name" => $country_name,
                    "accounting_number" => $row['COMPTE_CLIENT_COMPTA'],
                    "global_discount" => $row['taux_remise'],
                    "total_ht" => $row['MONTANT_HT'],
                    "total_ttc" => $row['MONTANT_TTC'],
                    "date_creation" => $row['DATE_COMMANDE'],
                    "date_limit" => $row['DATE_LIMITE_PAIEMENT'],
                    "id_modality" => $id_modality,
                    "label_modality" => $label_modality
                );

                $id_order = $this->orders->insert($data);

                if($rows2 = $this->old->query("SELECT * FROM commande_ligne WHERE C_COMMANDE = ".$row['C_COMMANDE'])) {
                    foreach ($rows2 as $row2) {
                        if($res = $this->old->query("SELECT * FROM commande_ligne_compta WHERE C_COMMANDE_LIGNE = ".$row2['C_COMMANDE_LIGNE'])) {
                            foreach($res as $re){
                                $taux_tva = $re["TAUX_TVA"];
                                $c_taux_tva = $re["C_TAUX_TVA"];
                                $compte_compta = $re["COMPTE_COMPTA"];
                            }
                        }
                        else{
                            $taux_tva = 0;
                            $c_taux_tva = 0;
                            $compte_compta = "";
                        }
                        // zeapps_order_lines
                        $data = array(
                            "id_order" => $id_order,
                            "type" => 'product',
                            "id_product" => isset($this->products_i[$row2['id_produit']]) ? $this->products_i[$row2['id_produit']] : 0,
                            "ref" => $this->convert($row2['CODE_PRODUIT']),
                            "designation_title" => $this->convert($row2['LIBELLE']),
                            "designation_desc" => $this->convert($row2['DESCRIPTIF']),
                            "qty" => $row2['QUANTITE'],
                            "discount" => $row2['taux_remise'],
                            "price_unit" => $row2['prix_unitaire_ht'],
                            "accounting_number" => $compte_compta,
                            "id_taxe" => isset($this->taxes_i[$c_taux_tva]) ? $this->taxes_i[$c_taux_tva] : 0,
                            "value_taxe" => $taux_tva,
                            "total_ht" => $row2['prix_total_ht'],
                            "total_ttc" => $row2['prix_total_ttc'],
                            "sort" => $row2['ordre']
                        );

                        $id = $this->order_lines->insert($data);
                        $this->order_lines_i[$row2['C_COMMANDE_LIGNE']] = $id;
                    }
                }
            }
        }
    }

// zeapps_invoices
    private function import_invoice($offset = 0)
    {
        if($rows = $this->old->query("SELECT * FROM facture LIMIT ".$this->step." OFFSET ".$offset)) {
            foreach($rows as $row) {
                if(isset($this->contacts_i[$row['C_CONTACT_LIVRAISON']]) && $contact = $this->contacts->get($this->contacts_i[$row['C_CONTACT_LIVRAISON']])){
                    $id = $contact->id;
                    $name = $contact->first_name ." ".$contact->last_name;
                    $address1 = $contact->address_1;
                    $address2 = $contact->address_2;
                    $address3 = $contact->address_3;
                    $city = $contact->city;
                    $zipcode = $contact->zipcode;
                    $state = $contact->state;
                    $country_id = $contact->country_id;
                    $country_name = $contact->country_name;
                    $con = 1;
                    $com = 0;
                }
                elseif(isset($this->companies_i[$row['C_CONTACT_LIVRAISON']]) && $contact = $this->companies->get($this->companies_i[$row['C_CONTACT_LIVRAISON']])){
                    $id = $contact->id;
                    $name = $contact->company_name;
                    $address1 = $contact->delivery_address_1;
                    $address2 = $contact->delivery_address_2;
                    $address3 = $contact->delivery_address_3;
                    $city = $contact->delivery_city;
                    $zipcode = $contact->delivery_zipcode;
                    $state = $contact->delivery_state;
                    $country_id = $contact->delivery_country_id;
                    $country_name = $contact->delivery_country_name;
                    $com = 1;
                    $con = 0;
                }
                else{
                    $id = 0;
                    $name = "";
                    $address1 = "";
                    $address2 = "";
                    $address3 = "";
                    $city = "";
                    $zipcode = "";
                    $state = "";
                    $country_id = 0;
                    $country_name = "";
                    $com = 0;
                    $con = 0;
                }

                if(strstr($row['LIBELLE'], "CDE WEB")){
                    $id_origin = 2;
                }
                else{
                    $id_origin = 1;
                }

                if(isset($this->modalities_i[$row['TYPE_PAIEMENT']]) && $modality = $this->modalities->get($this->modalities_i[$row['TYPE_PAIEMENT']])){
                    $id_modality = $modality->id;
                    $label_modality = $modality->label;
                }
                else{
                    $id_modality = 0;
                    $label_modality = "";
                }

                // zeapps_invoices
                $data = array(
                    "libelle" => $row['LIBELLE'],
                    "numerotation" => $row['NUMERO_FACTURE'],
                    "finalized" => 1,
                    "id_origin" => $id_origin,
                    "id_company" => $com ? $id : 0,
                    "name_company" => $com ? $name : "",
                    "id_contact" => $con ? $id : "",
                    "name_contact" => $con ? $name : "",
                    "billing_address_1" => $address1,
                    "billing_address_2" => $address2,
                    "billing_address_3" => $address3,
                    "billing_city" => $city,
                    "billing_zipcode" => $zipcode,
                    "billing_state" => $state,
                    "billing_country_id" => $country_id,
                    "billing_country_name" => $country_name,
                    "delivery_address_1" => $address1,
                    "delivery_address_2" => $address2,
                    "delivery_address_3" => $address3,
                    "delivery_city" => $city,
                    "delivery_zipcode" => $zipcode,
                    "delivery_state" => $state,
                    "delivery_country_id" => $country_id,
                    "delivery_country_name" => $country_name,
                    "accounting_number" => $row['COMPTE_CLIENT_COMPTA'],
                    "global_discount" => $row['taux_remise'],
                    "total_ht" => $row['MONTANT_HT'],
                    "total_ttc" => $row['MONTANT_TTC'],
                    "date_creation" => $row['DATE_COMMANDE'],
                    "date_limit" => $row['DATE_LIMITE_PAIEMENT'],
                    "id_modality" => $id_modality,
                    "label_modality" => $label_modality
                );

                $id_invoice = $this->invoices->insert($data);
                $this->invoices_i[$row['C_FACTURE']] = $id_invoice;

                if(floatval($row['solde']) === 0){
                    if($test = $this->old->query("SELECT COUNT(id) as total FROM encaissement_ligne l WHERE id_facture = ".$row['C_FACTURE'])) {
                        $total = 1;
                        foreach($test as $t){
                            $total = intval($t["total"]);
                        }
                        if($total < 1){
                            $data = array(
                                "id_invoice" => $id_invoice,
                                "paid" => $row['MONTANT_TTC'],
                                "id_modality" => $id_modality,
                                "label_modality" => $label_modality,
                                "date_payment" => $row['DATE_LIMITE_PAIEMENT']
                            );

                            $this->credit_balance_details->insert($data);
                        }
                    }
                }

                if($rows2 = $this->old->query("SELECT * FROM facture_ligne WHERE C_FACTURE = ".$row['C_FACTURE'])) {
                    foreach ($rows2 as $row2) {
                        if($res = $this->old->query("SELECT * FROM facture_ligne_compta WHERE C_FACTURE_LIGNE = ".$row2['C_FACTURE_LIGNE'])) {
                            foreach($res as $re){
                                $taux_tva = $re["TAUX_TVA"];
                                $c_taux_tva = $re["C_TAUX_TVA"];
                                $compte_compta = $re["COMPTE_COMPTA"];
                            }
                        }
                        else{
                            $taux_tva = 0;
                            $c_taux_tva = 0;
                            $compte_compta = "";
                        }
                        // zeapps_invoice_lines
                        $data = array(
                            "id_invoice" => $id_invoice,
                            "type" => 'product',
                            "id_product" => isset($this->products_i[$row2['id_produit']]) ? $this->products_i[$row2['id_produit']] : 0,
                            "ref" => $this->convert($row2['CODE_PRODUIT']),
                            "designation_title" => $this->convert($row2['LIBELLE']),
                            "designation_desc" => $this->convert($row2['DESCRIPTIF']),
                            "qty" => $row2['QUANTITE'],
                            "discount" => $row2['taux_remise'],
                            "price_unit" => $row2['prix_unitaire_ht'],
                            "accounting_number" => $compte_compta,
                            "id_taxe" => isset($this->taxes_i[$c_taux_tva]) ? $this->taxes_i[$c_taux_tva] : 0,
                            "value_taxe" => $taux_tva,
                            "total_ht" => $row2['prix_total_ht'],
                            "total_ttc" => $row2['prix_total_ttc'],
                            "sort" => $row2['ordre']
                        );

                        $this->invoice_lines->insert($data);
                    }
                }
            }
        }
        $invoice = $this->invoices->get($id_invoice);
        $this->write_accounting($invoice);
    }

// com_quiltmania_abonnement_clients + com_quiltmania_abonnement_client_details
// require : zeapps_orders + zeapps_order_lines + zeapps_order_line_details + zeapps_contacts + zeapps_companies + com_quiltmania_abonnements + com_quiltmania_destinations
// + com_quiltmania_publications
    private function import_abonnement_client($offset = 0)
    {
        if($rows = $this->old->query("SELECT * FROM abonnement_client LIMIT ".$this->step." OFFSET ".$offset)) {
            foreach($rows as $row) {
                if(isset($this->abonnements_i[$row['C_ABONNEMENT']]) && $abonnement = $this->abonnements->get($this->abonnements_i[$row['C_ABONNEMENT']])){
                    $label = $abonnement->label;
                }
                else{
                    $label = "";
                }
                if(isset($this->order_lines_i[$row['C_COMMANDE_LIGNE']]) && $order_line = $this->order_lines->get($this->order_lines_i[$row['C_COMMANDE_LIGNE']])){
                    $id_order = $order_line->id_order;
                    $total_ht = $order_line->total_ht;
                    $total_ttc = $order_line->total_ttc;
                    $c_zone_port = 0;
                    if($res = $this->old->query("SELECT * FROM abonnement_produit WHERE CODE_PRODUIT = ".$order_line->ref)) {
                        foreach($res as $re){
                            $c_zone_port = $re['C_ZONE_PORT'];
                        }
                    }
                }
                else{
                    $id_order = 0;
                    $total_ht = 0;
                    $total_ttc = 0;
                    $c_zone_port = 0;
                }
                // com_quiltmania_abonnement_clients
                $data = array(
                    "date_souscription" => $row['date_souscription'],
                    "id_commande" => $id_order,
                    "numero_commande" => $row['numero_commande'],
                    "id_ligne_commande" => isset($this->order_lines_i[$row['C_COMMANDE_LIGNE']]) ? $this->order_lines_i[$row['C_COMMANDE_LIGNE']] : 0,
                    "id_company" => isset($this->companies_i[$row['C_CONTACT']]) ? $this->companies_i[$row['C_CONTACT']] : 0,
                    "id_contact" => isset($this->contacts_i[$row['C_CONTACT']]) ? $this->contacts_i[$row['C_CONTACT']] : 0,
                    "prelevement_auto" => $row['PRELEVEMENT_AUTO'] === "Y",
                    "info" => $row['INFO'],
                    "json" => $row['json'],
                    "licence_prorpietaire" => $row['licence_prorpietaire'],
                    "sync" => $row['sync'],
                );
                $id_abonnement_client = $this->abonnement_clients->insert($data);

                if($rows2 = $this->old->query("SELECT * FROM abonnement_client_publication WHERE C_ABONNEMENT_CLIENT = ".$row['C_ABONNEMENT_CLIENT'])) {
                    foreach ($rows2 as $row2) {
                        // com_quiltmania_abonnement_client_details
                        $data = array(
                            "id_abonnement_client" => $id_abonnement_client,
                            "id_abonnement" => isset($this->abonnements_i[$row['C_ABONNEMENT']]) ? $this->abonnements_i[$row['C_ABONNEMENT']] : 0,
                            "id_destination" => isset($this->destinations_i[$c_zone_port]) ? $this->destinations_i[$c_zone_port] : 0,
                            "active" => '1',
                            "code_article" => $label,
                            "total_ht" => $total_ht,
                            "total_ttc" => $total_ttc,
                            "num_debut" => $row2['NUMERO_DEPART'],
                            "num_fin" => $row2['NUMERO_FIN']
                        );
                        $this->abonnement_client_details->insert($data);
                    }
                }
            }
        }
    }

// zeapps_credit_balance_details
    private function import_payments($offset = 0)
    {
        if($rows = $this->old->query("SELECT * FROM encaissement_ligne l LEFT JOIN encaissement e ON e.id = l.id_encaissement LIMIT ".$this->step." OFFSET ".$offset)) {
            foreach($rows as $row) {
                if(isset($this->modalities_i[$row['type_paiement']]) && $modality = $this->modalities->get($this->modalities_i[$row['type_paiement']])){
                    $id_modality = $modality->id;
                    $label_modality = $modality->label;
                }
                else{
                    $id_modality = 0;
                    $label_modality = "";
                }

                $data = array(
                    "id_invoice" => isset($this->invoices_i[$row['id_facture']]) ? $this->invoices_i[$row['id_facture']] : 0,
                    "paid" => $row['montant'],
                    "id_modality" => $id_modality,
                    "label_modality" => $label_modality,
                    "date_payment" => $row['date_encaissement']
                );

                $this->credit_balance_details->insert($data);
            }
        }
    }






// zeapps_accounting_entries
    private function write_accounting($invoice)
    {
        $label_entry = $invoice->numerotation . ' - ';
        $label_entry .= $invoice->name_company ?: ($invoice->name_contact ?: "");

        $invoice_lines = $this->invoice_lines->all(array('id_invoice' => $invoice->id));
        //$invoice_line_details = $this->invoice_line_details->all(array('id_invoice' => $invoice->id));
        $entries = [];
        $tvas = [];
        foreach ($invoice_lines as $line) {
            if ($line->has_detail === '0') {
                if (!isset($products[$line->accounting_number])) {
                    $products[$line->accounting_number] = 0;
                }

                $products[$line->accounting_number] += floatval($line->total_ht);

                if ($line->id_taxe !== '0') {
                    if (!isset($tvas[$line->id_taxe])) {
                        $tvas[$line->id_taxe] = array(
                            'ht' => 0,
                            'value_taxe' => floatval($line->value_taxe)
                        );
                    }

                    $tvas[$line->id_taxe]['ht'] += floatval($line->total_ht);
                    $tvas[$line->id_taxe]['value'] = round(floatval($tvas[$line->id_taxe]['ht']) * ($tvas[$line->id_taxe]['value_taxe'] / 100), 2);
                }
            }
        }
    }

    private function convert($latin){
        if (mb_detect_encoding($latin, 'utf-8', true) === false) {
            return mb_convert_encoding($latin, 'utf-8', 'iso-8859-1');
        }
        else{
            return $latin;
        }
    }
}