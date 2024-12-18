<?php

function set_custom_structure_permalinks() {
  // Define uma estrutura de permalink personalizada
  update_option('permalink_structure', '/blog/%postname%/'); // Altere para a estrutura desejada

  // Atualiza as regras de reescrita para garantir que as mudanças entrem em vigor
  flush_rewrite_rules();
}

// Adiciona a função ao gancho 'init' para que seja executada ao iniciar o WordPress
add_action('init', 'set_custom_structure_permalinks');