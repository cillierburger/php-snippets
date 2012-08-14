<?php 


/** 
 * Parses the content of the Nagios status.dat file into an array
 **/
function parse_nagios_status ($string) { 
    $token_block_start  = "{"; 
    $token_block_end    = "}"; 
    $in_block           = FALSE; 
    $result             = array(); 
    $lines = explode("\n",$string); 
    foreach ($lines as $line) {
        if ( !$in_block && substr($line,-1) == $token_block_start ) { 
            $in_block = TRUE; 
            $block_name = trim(substr($line,0,-1)); 
            $block_data = array(); 
        } elseif ( $in_block && substr($line,-1) == $token_block_end ) { 
            if(!array_key_exists($block_name,$result)) { 
                $result[$block_name] = array(); 
            }
            $result[$block_name][] = $block_data;
            $in_block = FALSE; 
        } else { 
            $parts = explode("=",trim($line)); 
            if (sizeof($parts) == 2) { 
                $block_data[$parts[0]] = $parts[1];
            }
        }        
    }    
    
    return $result; 
} 


