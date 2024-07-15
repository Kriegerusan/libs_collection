<?php

class StringInputManager
{
    public static function IsEmail(string $emailInput): bool
    {
        $template = "/^([a-z]([a-z0-9]|([-.](?![-.])))+[a-z0-9])[@]([a-z]+)(([.]([a-z]{2,3}))|([.]([a-z]{2,3})[.]([a-z]{2,3})))$/";
        $strlen = mb_strlen($emailInput);
        $out = "";
        for($i = 0;$i < $strlen;$i++){
            if(ord($emailInput[$i]) >= 65 && ord($emailInput[$i]) <= 90){
                $out .= strtolower($emailInput[$i]);
            }else{
                $out .= $emailInput[$i];
            }
        }
        return preg_match($template, $out);
    }

    public static function IsPasswordStrong(string $passwordInput)
    {

    }
}