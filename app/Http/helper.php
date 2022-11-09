<?php
use Stevebauman\Location\Facades\Location;

if (!function_exists('setActive')) {
    function setActive($path, $active = 'text-primary')
    {
        return request()->server("REQUEST_URI") == '/dashboard/' . $path ? $active : "";
    }
}

// the request shurthund of admin resource
if (!function_exists('adminUrl')) {
    function adminUrl($url = null)
    {
        if (env('APP_ENV') == "production") {
            return secure_url('/dashboard/' . $url);
        } else {
            return url('/admin/' . $url);
        }
    }
}

if (!function_exists('redirect_to_404_if_emty')) {
    function redirect_to_404_if_emty($needle)
    {
        if ($needle == null) {
            return view('_partial.404');
        }
    }
}
// get the segment of request and user in the navigation bar to open the li activated
if (!function_exists("active_menu")) {
    function active_menu($link)
    {

        if (preg_match("/" . $link . "/i", request()->segment(2))) {
            return ["menu-open", "active"];
        } else {
            return ["", ""];
        }
    }
}

if (!function_exists("active_dashboard_item")) { //this function for active dashboard link in the navigation bar its a link not has a item
    function active_dashboard_item($link)
    {
        if (preg_match('/' . $link . '/i', request()->segment(1)) && request()->segment(2) == "") {
            return ["active"];
        } else {
            return [""];
        }
    }
}

// user status
if (!function_exists("user_status")) {
    function user_status()
    {
        return [
            'activé' => "activé",
            "désactivé" => 'désactivé',
        ];
    }
}

// -------------------------------------------------------------------------

// ----------------------------------------------------------------------------------------

if (!function_exists('product_status')) {
    function product_status()
    {
        return [
            'activé' => 'activé',
            'désactivé' => 'désactivé',
        ];
    }
}

// special date format d-m-y
if (!function_exists('created')) {
    function created($date)
    {
        return \Carbon\Carbon::parse($date)->format('d-m-Y');
    }
}

// special date format منذ 15دقيقة
if (!function_exists('date_str')) {
    function date_str($date)
    {
        // return $date;
        \Carbon\Carbon::setlocale('fr');
        return Carbon\Carbon::parse($date)->diffForHumans();
    }
}

// special date format منذ 15دقيقة
if (!function_exists('date_format_type1')) {
    function date_format_type1($date)
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d H:m');
    }
}

// localisation
if (!function_exists("location")) {

    function location()
    {

        $localisation = file_get_contents("http://www.geoplugin.net/json.gp?ip=" . getRealIpAddr());
        $data = response()->json(['localisation' => json_decode($localisation)]);
        $data = $data->original;

        return $data['localisation'];
    }
}

if (!function_exists("getRealIpAddr")) {

    function getRealIpAddr()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }
}

if (!function_exists('location_adress')) {
    function location_adress()
    {
        $myIp = request()->ip();
        $position = Location::get($myIp);
        return $position;
    }
}
if (!function_exists('client_location')) {
    function client_location($param)
    {
        $location = location();
        $client_location['country'] = $location->geoplugin_countryName != null ? $location->geoplugin_countryName : 'unknown';
        $client_location['adress'] = $location->geoplugin_city != null ?
        $location->geoplugin_city . "|" . $location->geoplugin_region
        : "unknown";

        return $client_location[$param];
    }
}

if (!function_exists('countries_number_code')) {
    function countries_number_code($country)
    {
        $country = strtolower($country);

        $autorizedCountries = [
            'saudi arabia' => '+966',
            'united arab emirates' => '+971',
            'qatar' => '+974',
            'bahrain' => '+973',
            'oman' => '+968',
            "kuwait" => '+965',
            'united kingdom' => '+44',
            "morocco" => '+212',
            "united states" => '+1',
        ];

        return $country == null ? $autorizedCountries["united states"] : $autorizedCountries[$country];
    }
}

// redirect with flash msg
if (!function_exists('redirect_with_flash')) {
    function redirect_with_flash($alerType, $msg, $redirectTo, $admin = "")
    {
        request()->session()->flash($alerType, $msg);
        $url = $admin == "" ? adminUrl($redirectTo) : url($redirectTo);
        return redirect($url);
    }
}

// motoccan region
if (!function_exists('moroccan_region')) {
    function moroccan_region()
    {
        $regions = [
            "1" => "Tanger-Tétouan-Al Hoceïma",
            "2" => 'l\'Oriental',
            "3" => 'Fès-Meknès',
            "4" => 'Rabat-Salé-Kénitra',
            "5" => 'Béni Mellal-Khénifra',
            "6" => 'Casablanca-Settat',
            "7" => 'Marrakech-Safi',
            "8" => 'Drâa-Tafilalet',
            "9" => 'Souss-Massa',
            "10" => 'Guelmim-Oued Noun',
            "11" => 'Laâyoune-Sakia El Hamra',
            "12" => 'Dakhla-Oued Ed Dahab',
        ];

        return $regions;
    }
}

if (!function_exists('periodicites')) {
    function periodicites()
    {
        $periodicites = [
            "once" => 'Une seule fois',
            "every_day" => 'Tous les jours',
            "every_monday" => 'Tous les semaine le lundi',
            "every_month" => 'Tous les mois',
            "every_3_month" => 'Tous les 3 mois',
            "personalized" => 'Personnalisé',
        ];

        return $periodicites;
    }
}

if (!function_exists('repeate_at')) {
    function repeate_at()
    {
        $repeate_at = [
            "Jours" => "Jours",
            "Semaine" => "Semaine",
            "Mois" => "Mois",
            "Année" => "Année",
        ];

        return $repeate_at;
    }
}

// events colors
if (!function_exists("event_colors")) {
    function event_colors()
    {
        $colors = [
            'bg-primary' => "blue",
            'bg-success' => "verte",
            'bg-warning' => "jaune",
            'bg-danger' => "rouge",
        ];

        return $colors;
    }
}

// reapet every
if (!function_exists("repeat_every")) {
    function repeat_every()
    {
        $data = [
            'day' => 'jour',
            'week' => 'semaine',
            'month' => 'moi',
            'year' => 'an',
        ];

        return $data;
    }
}

// yes no
if (!function_exists("yes_no")) {
    function yes_no()
    {
        $boolean = [
            '0' => 'non',
            '1' => 'oui',
        ];
        return $boolean;
    }
}
// event status
if (!function_exists("event_status")) {
    function event_status()
    {
        $status = [
            'open' => 'ouverte',
            'in-progress' => 'en cours',
            'completed' => 'complété',
            'cancelled' => 'annulé',
        ];
        return $status;
    }
}

// ticket status
if (!function_exists('ticket_status')) {
    function ticket_status()
    {
        $status = [
            'creation' => "warning",
            'en cours' => "success",
            'ferme' => "danger",
        ];

        return $status;
    }
}

// sync on off
if (!function_exists('on_off')) {
    function on_off()
    {
        $status = [
            'on' => "1",
            'off' => "0",
        ];

        return $status;
    }
}

// sync on off
if (!function_exists('type_paiment')) {
    function type_paiment()
    {
        $type_paiment = [
            'Espèce' => "Espèce",
            'Credit' => "Credit",
            'Gratuits' => "Gratuits",
            'Tpe' => "Tpe",
        ];

        return $type_paiment;
    }
}

// sync on off
if (!function_exists('bundel_status')) {
    function bundel_status($status)
    {
        $bundel_status = [
            'livré' => "bg-success",
            'en attente' => "bg-warning",
            'annulé' => "bg-danger",
            'retourné' => "bg-info",
        ];
        
        if (in_array($status, ['livré', "en attente", "annulé", "retourné"])) {

            return $bundel_status[$status];
        }

        return "bg-secondary";
    }
}
