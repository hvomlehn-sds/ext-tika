<?php

declare(strict_types=1);

if (empty($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tika']['extractor']['driverRestrictions'])) {
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tika']['extractor']['driverRestrictions'] = [];
}
$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tika']['extractor']['driverRestrictions'] = array_merge(
    [
        'Local',
    ],
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['tika']['extractor']['driverRestrictions']
);

/* @var \TYPO3\CMS\Core\Resource\Index\ExtractorRegistry$metaDataExtractorRegistry */
$metaDataExtractorRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\Index\ExtractorRegistry::class);
$metaDataExtractorRegistry->registerExtractionService(\ApacheSolrForTypo3\Tika\Service\Extractor\MetaDataExtractor::class);

$extConf = \ApacheSolrForTypo3\Tika\Util::getTikaExtensionConfiguration();
if ($extConf['extractor'] !== 'solr') {
    $metaDataExtractorRegistry->registerExtractionService(\ApacheSolrForTypo3\Tika\Service\Extractor\LanguageDetector::class);
}
unset($extConf);

/* @var \TYPO3\CMS\Core\Resource\TextExtraction\TextExtractorRegistry $textExtractorRegistry */
$textExtractorRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Resource\TextExtraction\TextExtractorRegistry::class);
$textExtractorRegistry->registerTextExtractor(\ApacheSolrForTypo3\Tika\Service\Extractor\TextExtractor::class);

$GLOBALS['TYPO3_CONF_VARS']['BE']['ContextMenu']['ItemProviders'][1505197586] = \ApacheSolrForTypo3\Tika\ContextMenu\Preview::class;
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['typo3/backend.php']['constructPostProcess'][] = \ApacheSolrForTypo3\Tika\Hooks\BackendControllerHook::class . '->addJavaScript';
