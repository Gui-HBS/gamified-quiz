<?php 
/**
 * Função que converte caracteres ISO-8859-1 para UTF-8, mantendo os caracteres UTF-8 intactos.
 * @param string $texto
 * @return string
 */
function sanitizar_utf8($texto) {
    $saida = '';

    $i = 0;
    $len = strlen($texto);
    while ($i < $len) {
        $char = $texto[$i++];
        $ord  = ord($char);

        // Primeiro byte 0xxxxxxx: simbolo ascii possui 1 byte
        if (($ord & 0x80) == 0x00) {

            // Se e' um caractere de controle
            if (($ord >= 0 && $ord <= 31) || $ord == 127) {

                // Incluir se for: tab, retorno de carro ou quebra de linha
                if ($ord == 9 || $ord == 10 || $ord == 13) {
                    $saida .= $char;
                }

            // Simbolo ASCII
            } else {
                $saida .= $char;
            }

        // Primeiro byte 110xxxxx ou 1110xxxx ou 11110xxx: simbolo possui 2, 3 ou 4 bytes
        } else {

            // Determinar quantidade de bytes analisando os bits da esquerda para direita
            $bytes = 0;
            for ($b = 7; $b >= 0; $b--) {
                $bit = $ord & (1 << $b);
                if ($bit) {
                    $bytes += 1;
                } else {
                    break;
                }
            }

            switch ($bytes) {
            case 2: // 110xxxxx 10xxxxxx
            case 3: // 1110xxxx 10xxxxxx 10xxxxxx
            case 4: // 11110xxx 10xxxxxx 10xxxxxx 10xxxxxx
                $valido = true;
                $saida_padrao = $char;
                $i_inicial = $i;
                for ($b = 1; $b < $bytes; $b++) {
                    if (!isset($texto[$i])) {
                        $valido = false;
                        break;
                    }
                    $char_extra = $texto[$i++];
                    $ord_extra  = ord($char_extra);

                    if (($ord_extra & 0xC0) == 0x80) {
                        $saida_padrao .= $char_extra;
                    } else {
                        $valido = false;
                        break;
                    }
                }
                if ($valido) {
                    $saida .= $saida_padrao;
                } else {
                    $saida .= ($ord < 0x7F || $ord > 0x9F) ? utf8_encode($char) : '';
                    $i = $i_inicial;
                }
                break;
            case 1:  // 10xxxxxx: ISO-8859-1
            default: // 11111xxx: ISO-8859-1
                $saida .= ($ord < 0x7F || $ord > 0x9F) ? utf8_encode($char) : '';
                break;
            }
        }
    }
    return $saida;
}
?>