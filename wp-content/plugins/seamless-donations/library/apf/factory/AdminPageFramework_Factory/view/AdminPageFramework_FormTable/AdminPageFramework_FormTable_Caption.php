<?php
/**
 Admin Page Framework v3.5.12 by Michael Uno
 Generated by PHP Class Files Script Generator <https://github.com/michaeluno/PHP-Class-Files-Script-Generator>
 <http://en.michaeluno.jp/admin-page-framework>
 Copyright (c) 2013-2015, Michael Uno; Licensed under MIT <http://opensource.org/licenses/MIT>
 */
abstract class SeamlessDonationsAdminPageFramework_FormTable_Caption extends SeamlessDonationsAdminPageFramework_FormTable_Row {
    protected function _getCaption(array $aSection, $hfSectionCallback, $iSectionIndex, $aFields, $hfFieldCallback) {
        if (!$aSection['description'] && !$aSection['title']) {
            return "<caption class='admin-page-framework-section-caption' style='display:none;'></caption>";
        }
        $_abCollapsible = $this->_getCollapsibleArgument(array($aSection));
        $_bShowTitle = empty($_abCollapsible) && !$aSection['section_tab_slug'];
        return "<caption " . $this->generateAttributes(array('class' => 'admin-page-framework-section-caption', 'data-section_tab' => $aSection['section_tab_slug'],)) . ">" . $this->_getCollapsibleSectionTitleBlock($_abCollapsible, 'section', $aFields, $hfFieldCallback) . $this->getAOrB($_bShowTitle, $this->_getCaptionTitle($aSection, $iSectionIndex, $aFields, $hfFieldCallback), '') . $this->_getCaptionDescription($aSection, $hfSectionCallback) . $this->_getSectionError($aSection) . "</caption>";
    }
    private function _getSectionError($aSection) {
        $_sSectionError = isset($this->aFieldErrors[$aSection['section_id']]) && is_string($this->aFieldErrors[$aSection['section_id']]) ? $this->aFieldErrors[$aSection['section_id']] : '';
        return $_sSectionError ? "<div class='admin-page-framework-error'><span class='section-error'>* " . $_sSectionError . "</span></div>" : '';
    }
    private function _getCaptionTitle($aSection, $iSectionIndex, $aFields, $hfFieldCallback) {
        return "<div " . $this->generateAttributes(array('class' => 'admin-page-framework-section-title', 'style' => $this->getAOrB($this->_shouldShowCaptionTitle($aSection, $iSectionIndex), '', 'display: none;'),)) . ">" . $this->_getSectionTitle($aSection['title'], 'h3', $aFields, $hfFieldCallback) . "</div>";
    }
    private function _getCaptionDescription($aSection, $hfSectionCallback) {
        if ($aSection['collapsible']) {
            return '';
        }
        if (!is_callable($hfSectionCallback)) {
            return '';
        }
        return "<div class='admin-page-framework-section-description'>" . call_user_func_array($hfSectionCallback, array($this->_getDescriptions($aSection['description'], 'admin-page-framework-section-description'), $aSection)) . "</div>";
    }
    private function _shouldShowCaptionTitle($aSection, $iSectionIndex) {
        if (!$aSection['title']) {
            return false;
        }
        if ($aSection['collapsible']) {
            return false;
        }
        if ($aSection['section_tab_slug']) {
            return false;
        }
        if ($aSection['repeatable'] && $iSectionIndex != 0) {
            return false;
        }
        return true;
    }
}