<?php
require_once(__DIR__  . "/webp-convert/Exceptions/WebPConvertBaseException.php");
require_once(__DIR__  . "/webp-convert/Loggers/BaseLogger.php");
require_once(__DIR__  . "/webp-convert/WebPConvert.php");
require_once(__DIR__  . "/webp-convert/Converters/ConverterHelper.php");
require_once(__DIR__  . "/webp-convert/Converters/Cwebp.php");
require_once(__DIR__  . "/webp-convert/Converters/Ewww.php");
require_once(__DIR__  . "/webp-convert/Converters/Gd.php");
require_once(__DIR__  . "/webp-convert/Converters/Imagick.php");
require_once(__DIR__  . "/webp-convert/Converters/Wpc.php");
require_once(__DIR__  . "/webp-convert/Exceptions/ConverterNotFoundException.php");
require_once(__DIR__  . "/webp-convert/Exceptions/CreateDestinationFileException.php");
require_once(__DIR__  . "/webp-convert/Exceptions/CreateDestinationFolderException.php");
require_once(__DIR__  . "/webp-convert/Exceptions/InvalidFileExtensionException.php");
require_once(__DIR__  . "/webp-convert/Exceptions/TargetNotFoundException.php");
require_once(__DIR__  . "/webp-convert/Converters/Exceptions/ConversionDeclinedException.php");
require_once(__DIR__  . "/webp-convert/Converters/Exceptions/ConverterFailedException.php");
require_once(__DIR__  . "/webp-convert/Converters/Exceptions/ConverterNotOperationalException.php");
require_once(__DIR__  . "/webp-convert/Loggers/EchoLogger.php");
require_once(__DIR__  . "/webp-convert/Loggers/VoidLogger.php");