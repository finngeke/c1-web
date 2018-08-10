<?php

class MensajeHelper extends \Prefab
{

    public static function render($args)
    {
        $attr = $args['@attrib'];
        $salida = '';

        $t_color = isset($attr['color']) ? \Template::instance()->token($attr['color']) : false;
        $t_icon = isset($attr['icon']) ? \Template::instance()->token($attr['icon']) : false;
        $t_msg = \Template::instance()->token($args[0]);
        $t_head = isset($attr['header']) ? \Template::instance()->token($attr['header']) : false;

        $icon = $t_icon !== false ? 'icon' : '';

        $salida .= sprintf('<div class="ui %s <?php echo ' . $t_color . ' ?> message">', $icon);

        if ($t_icon !== false) {
            $salida .= '<i class="<?php echo ' . $t_icon . '?> icon"></i>';
        }
        $salida .= '<div class="content">';

        if ($t_head !== false) {
            $salida .= '<div class="header">
                        <?php echo ' . $t_head . ' ?>
                    </div>';
        }
        $salida .= "<p><?php echo " . $t_msg . " ?></p>";
        if ($t_head !== false) {
            $salida .= "</div>";
        }
        $salida .= "</div>";

        return $salida;
    }

    public static function easy($args)
    {
        $attr = $args['@attrib'];
        if (isset($attr['parametros']) === true && is_array($attr['parametros']) === true) {
            foreach ($attr['parametros'] as $index => $value) {
                $attr[$index] = $value;
            }
        }

        $salida = '';
        $header = false;
        $color = isset($attr['color']) ? $attr['color'] : '';

        $salida .= sprintf('<div class="ui icon %s message">', $color);

        if (isset($attr['icon']) && strlen($attr['icon'])) {
            $salida .= sprintf('<i class="%s icon"></i>', $attr['icon']);
        }
        $salida .= '<div class="content">';

        if (isset($attr['header']) && strlen($attr['header'])) {
            $salida .= sprintf('<div class="header">
                        %s
                    </div>', $attr['header']);
            $header = true;
        }
        $salida .= sprintf('<p>%s</p>', $args[0]);
        if ($header === true) {
            $salida .= "</div>";
        }
        $salida .= "</div>";
        return $salida;
    }

}
