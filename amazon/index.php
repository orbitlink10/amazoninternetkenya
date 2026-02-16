<?php
/**
 * Front controller shim for hosts pointing the docroot at the project root.
 * It simply includes the real Laravel front controller inside /public
 * without redirecting the browser (keeps URLs clean).
 */
require __DIR__ . '/public/index.php';
