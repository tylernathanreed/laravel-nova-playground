<?php

if(!function_exists('tailwind')) {

    /**
     * Returns the tailwind classes to apply from the given style.
     *
     * @param  string  $style
     *
     * @return string
     */
    function tailwind($style)
    {
        switch($style) {

            case 'sidebar-link':
                return 'py-4 px-6 cursor-pointer flex items-center font-normal dim text-white text-base no-underline';

        }
    }
}
