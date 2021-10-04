<?php
/*
 * webtrees - extended family tab
 *
 * webtrees: online genealogy / web based family history software
 * Copyright (C) 2021 webtrees development team.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; If not, see <https://www.gnu.org/licenses/>.
 */

/*
 * tbd: Offene Punkte
 * ------------------
 * Übersetzungen für italian und chinese einbauen, sobald sie zugeliefert wurden
 * fehlende Übersetzungen für french, norwegian (2x), finish und andere organisieren
 */
    
namespace Hartenthaler\Webtrees\Module\ExtendedFamily;

use Fisharebest\Webtrees\I18N;

/**
 * Class ExtendedFamilyTranslations
 */
class ExtendedFamilyTranslations
{
    /**
     * @return array
     */
    public static function czechTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Širší rodina',
            'A tab showing the extended family of an individual.' => 'Panel širší rodiny dané osoby.',
            'In which sequence should the parts of the extended family be shown?' => 'V jakém pořadí se části širší rodiny zobrazí?',
            'Family part' => 'Část rodiny',
            'Show name of proband as short name or as full name?' => 'Má se jméno probanta zobrazit jako zkrácené jméno, nebo jako úplné jméno?',
            'Show options to filter the results (gender and alive/dead)?' => 'Mají se zobrazit filtry výsledků (rod a živí/zemřelí)?',
            'Show filter options' => 'Zobrazit filtry',
            'How should empty parts of extended family be presented?' => 'Jak se mají zobrazit prázdné části (bloky) širší rodiny?',
            'Show empty block' => 'Zobrazit prázdné bloky',
            'yes, always at standard location' => 'ano, vždy na obvyklém místě',
            'no, but collect messages about empty blocks at the end' => 'ne, ale uvést prázdné bloky na konci výpisu',
            'never' => 'nikdy',
            'The short name is based on the probands Rufname or nickname. If these are not available, the first of the given names is used, if one is given. Otherwise the last name is used.' => 'Za zkrácené probantovo jméno se vezme domácké jméno nebo přezdívka. Pokud neexistuje, vezme se první křestní jméno, je-li k dispozici. Pokud ani to ne, vezme se příjmení.',
            'Show short name' => 'Zobrazovat zkrácené jméno',
            'Show labels in special situations?' => 'Mají se zobrazovat štítky pro zvláštní situace?',
            'Labels (or stickers) are used for example for adopted persons or foster children.' => 'Štítky se zobrazí např. pro adoptované osoby nebo děti v pěstounské péči. ',
            'Show labels' => 'Zobrazovat štítky',
            'Use the compact design?' => 'Má se použít kompaktní vzhled?',
            'Use the compact design' => 'Použít kompaktní vzhled',
            'The compact design only shows the name and life span for each person. The enriched design also shows a photo (if this is activated for this tree) as well as birth and death information.' => 'V kompaktním vzhledu se u osob zobrazuje jen jméno a životní letopočty. V obohaceném vzhledu se zobrazí také foto (pokud je pro daný strom aktivováno) a údaje o narození a úmrtí.',
            'don\'t use this filter' => 'tento filtr nepoužívat',
            'show only male persons' => 'zobrazit pouze osoby mužského pohlaví',
            'show only female persons' => 'zobrazit pouze osoby ženského pohlaví',
            'show only persons of unknown gender' => 'zobrazit pouze osoby neznámého pohlaví',
            'show only alive persons' => 'zobrazit pouze žijící osoby',
            'show only dead persons' => 'zobrazit pouze zemřelé osoby',
            'alive' => 'žijící',
            'dead' => 'zemřelí',
            'a dead person' => 'zemřelá osoba',
            'a living person' => 'žijící osoba',
            'not a male person' => 'osoba nikoliv mužského pohlaví',
            'not a female person' => 'osoba nikoliv ženského pohlaví',
            'not a person of unknown gender' => 'osoba nikoliv neznámého pohlaví',

            'twin' => 'dvojče',
            'triplet' => 'trojče',
            'quadruplet' => 'čtyřče',
            'quintuplet' => 'paterče',
            'sextuplet' => 'šesterče',
            'septuplet' => 'sedmerče',
            'octuplet' => 'osmerče',
            'nonuplet' => 'devaterče',
            'decuplet' => 'desaterče',
            'stillborn' => 'mrtvě narozený/á',
            'died as infant' => 'zemřela/a jako nemluvně',
            'linkage challenged' => 'vztah sporný',
            'linkage disproven' => 'vztah vyvrácený',
            'linkage proven' => 'vztah prokázaný',

            'Marriage' => 'Manželství',
            'Ex-marriage' => 'Rozvedené manželství',
            'Partnership' => 'Partnerství',
            'Fiancée' => 'Zasnoubení',
            ' with ' => ' s osobou ',
            'Biological parents of father' => 'Vlastní rodiče otce',
            'Biological parents of mother' => 'Vlastní rodiče matky',
            'Biological parents of parent' => 'Vlastní rodiče jednoho z rodičů',
            'Stepparents of father' => 'Nevlastní rodiče otce',
            'Stepparents of mother' => 'Nevlastní rodiče matky',
            'Stepparents of parent' => 'Nevlastní rodiče rodiče',
            'Parents of stepparents' => 'Rodiče nevlastních rodičů',
            'Siblings of father' => 'Sourozenci otce',
            'Siblings of mother' => 'Sourozenci matky',
            'Siblings-in-law of father' => 'Švagři a švagrové otce',
            'Siblings-in-law of mother' => 'Švagři a švagrové matky',
            'Biological parents' => 'Vlastní rodiče',
            'Stepparents' => 'Nevlastní rodiče',
            'Parents-in-law of biological children' => 'Tcháni a tchyně vlastních dětí',
            'Parents-in-law of stepchildren' => 'Tcháni a tchyně nevlastních dětí',
            'Full siblings' => 'Plnorodí sourozenci',
            'Half siblings' => 'Polorodí sourozenci',
            'Stepsiblings' => 'Nevlastní sourozenci',
            'Children of full siblings of father' => 'Děti plnorodých sourozenců otce',
            'Children of full siblings of mother' => 'Děti plnorodých sourozenců matky',
            'Children of full siblings of parent' => 'Děti plnorodých sourozenců jednoho rodiče',
            'Children of half siblings of father' => 'Děti polorodých sourozenců otce',
            'Children of half siblings of mother' => 'Děti polorodých sourozenců matky',
            'Children of half siblings of parent' => 'Děti polorodých sourozenců jednoho rodiče',
            'Siblings of partners' => 'Sourozenci partnerů',
            'Partners of siblings' => 'Partneři sourozenců',
            'Siblings of siblings-in-law' => 'Sourozenci švagrů a švagrových',
            'Partners of siblings-in-law' => 'Partneři švagrů a švagrových',
            'Children of siblings' => 'Děti sourozenců',
            'Siblings\' stepchildren' => 'Sourozenci nevlastních dětí',
            'Children of siblings of partners' => 'Děti sourozenců partnerů',
            'Biological children' => 'Vlastní děti',
            'Stepchildren' => 'Nevlastní děti',
            'Stepchild' => 'Nevlastní dítě',
            'Stepson' => 'Nevlastní syn',
            'Stepdaughter' => 'Nevlastní dcera',
            'Partners of biological children' => 'Partneři vlastních dětí',
            'Partners of stepchildren' => 'Partneři nevlastních dětí',
            'Biological grandchildren' => 'Vlastní vnoučata',
            'Stepchildren of children' => 'Nevlastní děti dětí',
            'Children of stepchildren' => 'Děti nevlastních dětí',
            'Stepchildren of stepchildren' => 'Nevlastní děti nevlastních dětí',

            'He' => 'On',
            'She' => 'Ona',
            'He/she' => 'On/ona',
            'Mr.' => 'Pan',
            'Mrs.' => 'Paní',
            'No family available' => 'Rodina chybí',
            'Parts of extended family without recorded information' => 'Chybějící části širší rodiny',
            '%s has no %s recorded.' => 'Pro osobu \'%s\' chybí záznamy %s.',
            '%s has no %s, and no %s recorded.' => 'Pro osobu \'%s\' chybí záznamy %s a %s.',
            'Father\'s family (%d)' => 'Otcova rodina (%d)',
            'Mother\'s family (%d)' => 'Matčina rodina (%d)',
            'Father\'s and Mother\'s family (%d)' => 'Otcova a matčina rodina (%d)',
            'Parents %1$s of %2$s' => 'Rodiče %1$s osoby \'%2$s\'',
            'Parents %1$s (%2$s) of %3$s' => 'Rodiče %1$s (%2$s) osoby \'%3$s\'',
            'Partners of %s' => 'Partneři osoby \'%s\'',
            'Brother %1$s of partner %2$s' => 'Bratr %1$s partnera %2$s',
            'Sister %1$s of partner %2$s' => 'Sestra %1$s partnera %2$s',
            'Sibling %1$s of partner %2$s' => 'Sourozenec %1$s partnera %2$s',

            'Grandparents' => 'Prarodiče',
            '%s has no grandparents recorded.' => '%s zde nemá zaznamenané žádné prarodiče.',
            '%s has one grandmother recorded.' => '%s má zaznamenanou jednu bábu.',
            '%s has one grandfather recorded.' => '%s má zaznamenaného jednoho děda.',
            '%s has one grandparent recorded.' => '%s má zaznamenaného jednoho prarodiče.',
            '%2$s has %1$d grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d grandmothers recorded.' => '%2$s má zaznamenanou %1$d bábu.' . I18N::PLURAL . '%2$s má zaznamenané %1$d báby.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d bab.',
            '%2$s has %1$d grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d grandfathers recorded.'
            => '%2$s má zaznamenaného %1$d děda.' . I18N::PLURAL . '%2$s má zaznamenané %1$d dědy.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d dědů.',
            '%2$s has %1$d grandfather and ' . I18N::PLURAL . '%2$s has %1$d grandfathers and '
            => '%2$s má zaznamenaného %1$d děda a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d dědy a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d dědů a ',
            '%d grandmother recorded (%d in total).' . I18N::PLURAL . '%d grandmothers recorded (%d in total).'
            => '%d bábu (celkem %d).' . I18N::PLURAL . '%d báby (celkem %d).' . I18N::PLURAL . '%d bab (celkem %d).',

            'Uncles and Aunts' => 'Strýcové a tety',
            '%s has no uncles or aunts recorded.' => '%s zde nemá zaznamenané žádné strýce ani tety.',
            '%s has one aunt recorded.' => '%s má zaznamenanou jednu tetu.',
            '%s has one uncle recorded.' => '%s má zaznamenaného jednoho strýce.',
            '%s has one uncle or aunt recorded.' => '%s má zaznamenaného jednoho strýce nebo jednu tetu.',
            '%2$s has %1$d aunt recorded.' . I18N::PLURAL . '%2$s has %1$d aunts recorded.' => '%2$s má zaznamenanou %1$d tetu.' . I18N::PLURAL . '%2$s má zaznamenané %1$d tety.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d tet.',
            '%2$s has %1$d uncle recorded.' . I18N::PLURAL . '%2$s has %1$d uncles recorded.'
            => '%2$s má zaznamenaného %1$d strýce.' . I18N::PLURAL . '%2$s má zaznamenané %1$d strýce.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d strýců.',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and '
            => '%2$s má zaznamenaného %1$d strýce a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d strýce a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d strýců a ',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).'
            => '%d tetu (celkem %d).' . I18N::PLURAL . '%d tety (celkem %d).' . I18N::PLURAL . '%d tet (celkem %d).',

            'Uncles and Aunts by marriage' => 'Vyženění/vyvdaní strýcové a tety',
            '%s has no uncles or aunts by marriage recorded.' => '%s nemá zaznamenané žádné vyženěné/vyvdané strýce ani tety.',
            '%s has one aunt by marriage recorded.' => '%s má zaznamenanou jednu vyženěnou/vyvdanou tetu.',
            '%s has one uncle by marriage recorded.' => '%s má zaznamenaného jednoho vyženěného/vyvdaného strýce.',
            '%s has one uncle or aunt by marriage recorded.' => '%s má zaznamenaného jednoho vyženěného/vyvdaného strýce nebo jednu vyženěnou/vyvdanou tetu.',
            '%2$s has %1$d aunt by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d aunts by marriage recorded.'
            => '%2$s má zaznamenanou %1$d vyženěnou/vyvdanou tetu.' . I18N::PLURAL . '%2$s má zaznamenané %1$d vyženěné/vyvdané tety.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vyženěných/vyvdaných tet.',
            '%2$s has %1$d uncle by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d uncles by marriage recorded.'
            => '%2$s má zaznamenaného %1$d vyženěného/vyvdaného strýce.' . I18N::PLURAL . '%2$s má zaznamenané %1$d vyženěné/vyvdané strýce.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vyženěných/vyvdaných strýců.',
            '%2$s has %1$d uncle by marriage and ' . I18N::PLURAL . '%2$s has %1$d uncles by marriage and '
            => '%2$s má zaznamenaného %1$d vyženěného/vyvdaného strýce a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d vyženěné/vyvdané strýce a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vyženěných/vyvdaných strýců a ',
            '%d aunt by marriage recorded (%d in total).' . I18N::PLURAL . '%d aunts by marriage recorded (%d in total).'
            => '%d vyženěnou/vyvdanou tetu (celkem %d).' . I18N::PLURAL . '%d vyženěné/vyvdané tety (celkem %d).' . I18N::PLURAL . '%d vyženěných/vyvdaných tet (celkem %d).',

            'Parents' => 'Rodiče',
            '%s has no parents recorded.' => '%s nemá zaznamenané žádné rodiče.',
            '%s has one mother recorded.' => '%s má zaznamenanou jednu matku.',
            '%s has one father recorded.' => '%s má zaznamenaného jednoho otce.',
            '%s has one parent recorded.' => '%s má zaznamenaného jednoho rodiče.',
            '%2$s has %1$d mother recorded.' . I18N::PLURAL . '%2$s has %1$d mothers recorded.' => '%2$s má zaznamenanou %1$d matku.' . I18N::PLURAL . '%2$s má zaznamenané %1$d matky.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d matek.',
            '%2$s has %1$d father recorded.' . I18N::PLURAL . '%2$s has %1$d fathers recorded.'
            => '%2$s má zaznamenaného %1$d otce.' . I18N::PLURAL . '%2$s má zaznamenané %1$d otce.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d otců.',
            '%2$s has %1$d father and ' . I18N::PLURAL . '%2$s has %1$d fathers and '
            => '%2$s má zaznamenaného %1$d otce a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d otce a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d otců a ',
            '%d mother recorded (%d in total).' . I18N::PLURAL . '%d mothers recorded (%d in total).'
            => '%d matku (celkem %d).' . I18N::PLURAL . '%d matky (celkem %d).' . I18N::PLURAL . '%d matek (celkem %d).',

            'Parents-in-law' => 'Tcháni a tchyně',
            '%s has no parents-in-law recorded.' => '%s zde nemá zaznamenaného žádného tchána ani tchyni.',
            '%s has one mother-in-law recorded.' => '%s má zaznamenanou jednu tchyni.',
            '%s has one father-in-law recorded.' => '%s má zaznamenaného jednoho tchána.',
            '%s has one parent-in-law recorded.' => '%s má zaznamenaného jednoho tchána či tchyni.',
            '%2$s has %1$d mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d mothers-in-law recorded.' => '%2$s má zaznamenanou %1$d tchyni.' . I18N::PLURAL . '%2$s má zaznamenané %1$d tchyně.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d tchyní.',
            '%2$s has %1$d father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d fathers-in-law recorded.'
            => '%2$s má zaznamenaného %1$d tchána.' . I18N::PLURAL . '%2$s má zaznamenané %1$d tchány.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d tchánů.',
            '%2$s has %1$d father-in-law and ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law and '
            => '%2$s má zaznamenaného %1$d tchána a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d tchány a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d tchánů a ',
            '%d mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d mothers-in-law recorded (%d in total).'
            => '%d tchyni (celkem %d).' . I18N::PLURAL . '%d tchyně (celkem %d).' . I18N::PLURAL . '%d tchyní (celkem %d).',

            'Co-parents-in-law' => 'Tcháni a tchyně dětí (spolutcháni a spolutchyně)',
            '%s has no co-parents-in-law recorded.' => '%s nemá zaznamenané žádné spolutchány ani spolutchyně.',
            '%s has one co-mother-in-law recorded.' => '%s má zaznamenanou jednu spolutchyni.',
            '%s has one co-father-in-law recorded.' => '%s má zaznamenaného jednoho spolutchána.',
            '%s has one co-parent-in-law recorded.' => '%s má zaznamenaného jednoho spolutchána či spolutchyni.',
            '%2$s has %1$d co-mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law recorded.'
            => '%2$s má zaznamenanou %1$d spolutchyni.' . I18N::PLURAL . '%2$s má zaznamenané %1$d spolutchyně.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d spolutchyní.',
            '%2$s has %1$d co-father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law recorded.'
            => '%2$s má zaznamenaného %1$d spolutchána.' . I18N::PLURAL . '%2$s má zaznamenané %1$d spolutchány.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d spolutchánů.',
            '%2$s has %1$d co-father-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law and '
            => '%2$s má zaznamenaného %1$d spolutchána a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d spolutchány a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d spolutchánů a ',
            '%d co-mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-mothers-in-law recorded (%d in total).'
            => '%d spolutchyni (celkem %d).' . I18N::PLURAL . '%d spolutchyně (celkem %d).' . I18N::PLURAL . '%d spolutchyní (celkem %d).',

            'Siblings' => 'Sourozenci',
            '%s has no siblings recorded.' => '%s zde nemá zaznamenané žádné sourozence.',
            '%s has one sister recorded.' => '%s má zaznamenanou jednu sestru.',
            '%s has one brother recorded.' => '%s má zaznamenaného jednoho bratra.',
            '%s has one brother or sister recorded.' => '%s má zaznamenaného jednoho sourozence.',
            '%2$s has %1$d sister recorded.' . I18N::PLURAL . '%2$s has %1$d sisters recorded.' => '%2$s má zaznamenanou %1$d sestru.' . I18N::PLURAL . '%2$s má zaznamenané %1$d sestry.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d sester.',
            '%2$s has %1$d brother recorded.' . I18N::PLURAL . '%2$s has %1$d brothers recorded.'
            => '%2$s má zaznamenaného %1$d bratra.' . I18N::PLURAL . '%2$s má zaznamenané %1$d bratry.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d bratrů.',
            '%2$s has %1$d brother and ' . I18N::PLURAL . '%2$s has %1$d brothers and '
            => '%2$s má zaznamenaného %1$d bratra a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d bratry a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d bratrů a ',
            '%d sister recorded (%d in total).' . I18N::PLURAL . '%d sisters recorded (%d in total).'
            => '%d sestru (celkem %d).' . I18N::PLURAL . '%d sestry (celkem %d).' . I18N::PLURAL . '%d sester (celkem %d).',

            'Siblings-in-law' => 'Švagři a švagrové',
            '%s has no siblings-in-law recorded.' => '%s nemá zaznamenané žádné švagry ani švagrové.',
            '%s has one sister-in-law recorded.' => '%s má zaznamenanou jednu švagrovou.',
            '%s has one brother-in-law recorded.' => '%s má zaznamenaného jednoho švagra.',
            '%s has one sibling-in-law recorded.' => '%s má zaznamenaného jednoho švagra nebo jednu švagrovou.',
            '%2$s has %1$d sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sisters-in-law recorded.'
            => '%2$s má zaznamenanou %1$d švagrovou.' . I18N::PLURAL . '%2$s má zaznamenané %1$d švagrové.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d švagrových.',
            '%2$s has %1$d brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d brothers-in-law recorded.'
            => '%2$s má zaznamenaného %1$d švagra.' . I18N::PLURAL . '%2$s má zaznamenané %1$d švagry.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d švagrů.',
            '%2$s has %1$d brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law and '
            => '%2$s má zaznamenaného %1$d švagra a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d švagry a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d švagrů a ',
            '%d sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d sisters-in-law recorded (%d in total).'
            => '%d švagrovou (celkem %d).' . I18N::PLURAL . '%d švagrové (celkem %d).' . I18N::PLURAL . '%d švagrových (celkem %d).',

            'Co-siblings-in-law' => 'Partneři a sourozenci švagrů a švagrových<br>(spolušvagři a spolušvagrové)',
            '%s has no co-siblings-in-law recorded.' => '%s nemá zaznamenané žádné spolušvagry ani spolušvagrové.',
            '%s has one co-sister-in-law recorded.' => '%s má zaznamenanou jednu spolušvagrovou.',
            '%s has one co-brother-in-law recorded.' => '%s má zaznamenaného jednoho spolušvagra.',
            '%s has one co-sibling-in-law recorded.' => '%s má zaznamenaného jednoho spolušvagra nebo jednu spolušvagrovou.',
            '%2$s has %1$d co-sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-sisters-in-law recorded.'
            => '%2$s má zaznamenanou %1$d spolušvagrovou.' . I18N::PLURAL . '%2$s má zaznamenané %1$d spolušvagrové.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d spolušvagrových.',
            '%2$s has %1$d co-brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law recorded.'
            => '%2$s má zaznamenaného %1$d spolušvagra.' . I18N::PLURAL . '%2$s má zaznamenané %1$d spolušvagry.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d spolušvagrů.',
            '%2$s has %1$d co-brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law and '
            => '%2$s má zaznamenaného %1$d spolušvagra a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d spolušvagry a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d spolušvagrů a ',
            '%d co-sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-sisters-in-law recorded (%d in total).'
            => '%d spolušvagrovou (celkem %d).' . I18N::PLURAL . '%d spolušvagrové (celkem %d).' . I18N::PLURAL . '%d spolušvagrových (celkem %d).',

            'Partners' => 'Partneři',
            'Partner of ' => 'Partner osoby ',
            '%s has no partners recorded.' => '%s zde nemá zaznamenaného žádného partnera.',
            '%s has one female partner recorded.' => '%s má zaznamenanou jednu partnerku.',
            '%s has one male partner recorded.' => '%s má zaznamenaného jednoho partnera.',
            '%s has one partner recorded.' => '%s má zaznamenaného jednoho partnera.',
            '%2$s has %1$d female partner recorded.' . I18N::PLURAL . '%2$s has %1$d female partners recorded.' => '%2$s má zaznamenanou %1$d partnerku.' . I18N::PLURAL . '%2$s má zaznamenané %1$d partnerky.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d partnerek.',
            '%2$s has %1$d male partner recorded.' . I18N::PLURAL . '%2$s has %1$d male partners recorded.'
            => '%2$s má zaznamenaného %1$d partnera.' . I18N::PLURAL . '%2$s má zaznamenané %1$d partnery.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d partnerů.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and '
            => '%2$s má zaznamenaného %1$d partnera a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d partnery a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d partnerů a ',
            '%2$s has %1$d female partner and ' . I18N::PLURAL . '%2$s has %1$d female partners and '
            => '%2$s má zaznamenanou %1$d partnerku a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d partnerky a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d partnerek a ',
            '%d female partner recorded (%d in total).' . I18N::PLURAL . '%d female partners recorded (%d in total).'
            => '%d partnerku (celkem %d).' . I18N::PLURAL . '%d partnerky (celkem %d).' . I18N::PLURAL . '%d partnerek (celkem %d).',
            '%2$s has %1$d partner and ' . I18N::PLURAL . '%2$s has %1$d partners and '
            => '%2$s má zaznamenaného %1$d partnera a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d partnery a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d partnerů a ',
            '%d male partner of female partners recorded (%d in total).' . I18N::PLURAL . '%d male partners of female partners recorded (%d in total).'
            => '%d partnera partnerek (celkem %d).' . I18N::PLURAL . '%d partnery partnerek (celkem %d).' . I18N::PLURAL . '%d partnerů partnerek (celkem %d).',
            '%d female partner of male partners recorded (%d in total).' . I18N::PLURAL . '%d female partners of male partners recorded (%d in total).'
            => '%d partnerku partnerů (celkem %d).' . I18N::PLURAL . '%d partnerky partnerů (celkem %d).' . I18N::PLURAL . '%d partnerek partnerů (celkem %d).',

            'Partner chains' => 'Řetězce partnerů',
            '%s has no members of a partner chain recorded.' => 'U osoby \'%s\' nejsou zaznamenané žádné řetězce partnerů.',
            'There are %d branches in the partner chain. ' => 'V řetězci partnerů jsou %d linie.',
            'The longest branch in the partner chain to %2$s consists of %1$d partners (including %3$s).' => 'Nejdelší linie v řetězci k osobě \'%2$s\' sestává z %1$d partnerů (včetně osoby \'%3$s\').',
            'The longest branch in the partner chain consists of %1$d partners (including %2$s).' => 'Nejdelší linie v řetězci partnerů sestává z %1$d partnerů (včetně osoby \'%2$s\').',
            '%d female partner in this partner chain recorded (%d in total).' . I18N::PLURAL . '%d female partners in this partner chain recorded (%d in total).'
            =>'v tomto řetězci je zaznamenaná %d partnerka (celkem %d).' . I18N::PLURAL . 'v tomto řetězci jsou zaznamenané %d partnerky (celkem %d).' . I18N::PLURAL . 'v tomto řetězci je zaznamenaných %d partnerek (celkem %d).',

            'Cousins' => 'Bratranci a sestřenice',
            '%s has no first cousins recorded.' => '%s nemá zaznamenané žádné bratrance ani sestřenice.',
            '%s has one female first cousin recorded.' => '%s má zaznamenanou jednu sestřenici.',
            '%s has one male first cousin recorded.' => '%s má zaznamenaného jednoho bratrance.',
            '%s has one first cousin recorded.' => '%s má zaznamenaného jednoho bratrance příp. jednu sestřenici.',
            '%2$s has %1$d female first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d female first cousins recorded.' => '%2$s má zaznamenanou %1$d sestřenici.' . I18N::PLURAL . '%2$s má zaznamenané %1$d sestřenice.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d sestřenic.',
            '%2$s has %1$d male first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d male first cousins recorded.'
            => '%2$s má zaznamenaného %1$d bratrance.' . I18N::PLURAL . '%2$s má zaznamenané %1$d bratrance.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d bratranců.',
            '%2$s has %1$d male first cousin and ' . I18N::PLURAL . '%2$s has %1$d male first cousins and '
            => '%2$s má zaznamenaného %1$d bratrance a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d bratrance a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d bratranců a ',
            '%d female first cousin recorded (%d in total).' . I18N::PLURAL . '%d female first cousins recorded (%d in total).'
            => '%d sestřenici (celkem %d).' . I18N::PLURAL . '%d sestřenice (celkem %d).' . I18N::PLURAL . '%d sestřenic (celkem %d).',

            'Nephews and Nieces' => 'Synovci a neteře',
            '%s has no nephews or nieces recorded.' => '%s nemá zaznamenané žádné synovce ani neteře.',
            '%s has one niece recorded.' => '%s má zaznamenanou jednu neteř.',
            '%s has one nephew recorded.' => '%s má zaznamenaného jednoho synovce.',
            '%s has one nephew or niece recorded.' => '%s má zaznamenaného jednoho synovce nebo jednu neteř.',
            '%2$s has %1$d niece recorded.' . I18N::PLURAL . '%2$s has %1$d nieces recorded.' => '%2$s má zaznamenanou %1$d sestřenici.' . I18N::PLURAL . '%2$s má zaznamenané %1$d sestřenice.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d sestřenic.',
            '%2$s has %1$d nephew recorded.' . I18N::PLURAL . '%2$s has %1$d nephews recorded.'
            => '%2$s má zaznamenaného %1$d synovce.' . I18N::PLURAL . '%2$s má zaznamenané %1$d synovce.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d synovců.',
            '%2$s has %1$d nephew and ' . I18N::PLURAL . '%2$s has %1$d nephews and '
            => '%2$s má zaznamenaného %1$d synovce a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d synovce a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d synovců a ',
            '%d niece recorded (%d in total).' . I18N::PLURAL . '%d nieces recorded (%d in total).'
            => '%d neteř (celkem %d).' . I18N::PLURAL . '%d neteře (celkem %d).' . I18N::PLURAL . '%d neteří (celkem %d).',

            'Children' => 'Děti',
            '%s has no children recorded.' => '%s nemá zaznamenané žádné děti.',
            '%s has one daughter recorded.' => '%s má zaznamenanou jednu dceru.',
            '%s has one son recorded.' => '%s má zaznamenaného jednoho syna.',
            '%s has one child recorded.' => '%s má zaznamenané jedno dítě.',
            '%2$s has %1$d daughter recorded.' . I18N::PLURAL . '%2$s has %1$d daughters recorded.' => '%2$s má zaznamenanou %1$d dceru.' . I18N::PLURAL . '%2$s má zaznamenané %1$d dcery.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d dcer.',
            '%2$s has %1$d son recorded.' . I18N::PLURAL . '%2$s has %1$d sons recorded.'
            => '%2$s má zaznamenaného %1$d syna.' . I18N::PLURAL . '%2$s má zaznamenané %1$d syny.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d synů.',
            '%2$s has %1$d son and ' . I18N::PLURAL . '%2$s has %1$d sons and '
            => '%2$s má zaznamenaného %1$d syna a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d syny a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d synů a ',
            '%d daughter recorded (%d in total).' . I18N::PLURAL . '%d daughters recorded (%d in total).'
            => '%d dceru (celkem %d).' . I18N::PLURAL . '%d dcery (celkem %d).' . I18N::PLURAL . '%d dcer (celkem %d).',

            'Children-in-law' => 'Zeťové a snachy',
            '%s has no children-in-law recorded.' => '%s nemá zaznamenané žádné zetě ani snachy.',
            '%s has one daughter-in-law recorded.' => '%s má zaznamenanou jednu snachu.',
            '%s has one son-in-law recorded.' => '%s má zaznamenaného jednoho zetě.',
            '%s has one child-in-law recorded.' => '%s má zaznamenaného jednoho zetě nebo snachu.',
            '%2$s has %1$d daughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d daughters-in-law recorded.'
            => '%2$s má zaznamenanou %1$d snachu.' . I18N::PLURAL . '%2$s má zaznamenané %1$d snachy.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d snach.',
            '%2$s has %1$d son-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sons-in-law recorded.'
            => '%2$s má zaznamenaného %1$d zetě.' . I18N::PLURAL . '%2$s má zaznamenané %1$d zetě.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d zeťů.',
            '%2$s has %1$d son-in-law and ' . I18N::PLURAL . '%2$s has %1$d sons-in-law and '
            => '%2$s má zaznamenaného %1$d zetě a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d zetě a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d zeťů a ',
            '%d daughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d daughters-in-law recorded (%d in total).'
            => '%d snachu (celkem %d).' . I18N::PLURAL . '%d snachy (celkem %d).' . I18N::PLURAL . '%d snach (celkem %d).',

            'Grandchildren' => 'Vnoučata',
            '%s has no grandchildren recorded.' => '%s nemá zaznamenaná žádná vnoučata.',
            '%s has one granddaughter recorded.' => '%s má zaznamenanou jednu vnučku.',
            '%s has one grandson recorded.' => '%s má zaznamenaného jednoho vnuka.',
            '%s has one grandchild recorded.' => '%s má zaznamenané jedno vnouče.',
            '%2$s has %1$d granddaughter recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters recorded.' => '%2$s má zaznamenanou %1$d vnučku.' . I18N::PLURAL . '%2$s má zaznamenané %1$d vnučky.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vnuček.',
            '%2$s has %1$d grandson recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons recorded.'
            => '%2$s má zaznamenaného %1$d vnuka.' . I18N::PLURAL . '%2$s má zaznamenané %1$d vnuky.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vnuků.',
            '%2$s has %1$d grandson and ' . I18N::PLURAL . '%2$s has %1$d grandsons and '
            => '%2$s má zaznamenaného %1$d vnuka a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d vnuky a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vnuků a ',
            '%d granddaughter recorded (%d in total).' . I18N::PLURAL . '%d granddaughters recorded (%d in total).'
            => '%d vnučku (celkem %d).' . I18N::PLURAL . '%d vnučky (celkem %d).' . I18N::PLURAL . '%d vnuček (celkem %d).',
        ];
    }

    /**
     * tbd
     *
     * @return array
     */
    public static function danishTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
        ];
    }

    /**
     * @return array
     */
    public static function germanTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Großfamilie',
            'A tab showing the extended family of an individual.' => 'Reiter zeigt die Großfamilie einer Person.',
            'In which sequence should the parts of the extended family be shown?' => 'In welcher Reihenfolge sollen die Teile der erweiterten Familie angezeigt werden?',
            'Family part' => 'Familienteil',
            'Show name of proband as short name or as full name?' => 'Soll eine Kurzform oder der vollständige Name des Probanden angezeigt werden?',
			'Show options to filter the results (gender and alive/dead)?' => 'Sollen Optionen zum Filtern der Ergebnisse angezeigt werden (Geschlecht und lebend/tot)?',
            'Show filter options' => 'Zeige Filteroptionen',
            'How should empty parts of extended family be presented?' => 'Wie sollen leere Teile der erweiterten Familie angezeigt werden?',
			'Show empty block' => 'Zeige leere Familienteile',
			'yes, always at standard location' => 'ja, immer am normalen Platz',
			'no, but collect messages about empty blocks at the end' => 'nein, aber sammle Nachrichten über leere Familienteile am Ende',
			'never' => 'niemals',
            'The short name is based on the probands Rufname or nickname. If these are not available, the first of the given names is used, if one is given. Otherwise the last name is used.' => 'Der Kurzname basiert auf dem Rufnamen oder dem Spitznamen des Probanden. Falls diese nicht vorhanden sind, wird der erste der Vornamen verwendet, sofern ein solcher angegeben ist. Andernfalls wird der Nachname verwendet.',
            'Show short name' => 'Zeige die Kurzform des Namens',
            'Show labels in special situations?' => 'Sollen in besonderen Situationen Etiketten gezeigt werden?',
            'Labels (or stickers) are used for example for adopted persons or foster children.' => 'Etiketten werden beispielsweise für Adoptivpersonen oder Pflegekinder verwendet. ',
            'Show labels' => 'Zeige Etiketten',
            'Use the compact design?' => 'Soll das kompakte Design verwendet werden?',
            'Use the compact design' => 'Kompaktes Design anwenden',
            'The compact design only shows the name and life span for each person. The enriched design also shows a photo (if this is activated for this tree) as well as birth and death information.' => 'Das kompakte Design zeigt für jede Person nur den Namen und die Lebensspanne. Das angereicherte Design zeigt zusätzlich ein Foto (wenn dies für diesen Baum aktiviert ist) sowie Geburts- und Sterbeinformationen.',
            'Show parameters of extended family part?' => 'Sollen Parameter für die erweiterten Familienteile angezeigt werden?',
            'Display of additional information for each part of the extended family, such as the generation shift and the coefficient of relationship, which is a measure of the degree of consanguinity.' => 'Anzeige von zusätzlichen Informationen für jeden Teil der Großfamilie wie etwa die Generationenverschiebung und den Verwandtschaftskoeffizienten, der ein Maß für den Grad der Blutsverwandtschaft ist.',
            'Show parameters' => 'Zeige Parameter',
            'generation +%s' => 'Generation +%s',
            'same generation' => 'gleiche Generation',
            'generation %s' => 'Generation %s',
            'relationship coefficient: %.1f' => 'Verwandtschaftskoeffizient: %.1f',
            'no blood relationship' => 'keine Blutsverwandtschaft',

            'don\'t use this filter' => 'verwende diesen Filter nicht',
            'show only male persons' => 'zeige nur männliche Personen',
            'show only female persons' => 'zeige nur weibliche Personen',
            'show only persons of unknown gender' => 'zeige nur Personen unbekannten Geschlechts',
            'show only alive persons' => 'zeige nur Personen, die noch leben',
            'show only dead persons' => 'zeige nur Personen, die bereits verstorben sind',
            'alive' => 'lebend',
            'dead' => 'verstorben',
            'a dead person' => 'eine verstorbende Person',
            'a living person' => 'eine lebende Person',
            'not a male person' => 'keine männliche Person',
            'not a female person' => 'keine weibliche Person',
            'not a person of unknown gender' => 'keine Person unbekannten Geschlechts',

            'twin' => 'Zwilling',
            'triplet' => 'Drilling',
            'quadruplet' => 'Vierling',
            'quintuplet' => 'Fünfling',
            'sextuplet' => 'Sechsling',
            'septuplet' => 'Siebenling',
            'octuplet' => 'Achtling',
            'nonuplet' => 'Neunling',
            'decuplet' => 'Zehnling',
            'stillborn' => 'tot geboren',
            'died as infant' => 'als Kleinkind gestorben',
            'linkage challenged' => 'Verbindung fragwürdig',
            'linkage disproven' => 'Verbindung widerlegt',
            'linkage proven' => 'Verbindung bewiesen',
            
            'Marriage' => 'Ehe',
            'Ex-marriage' => 'Geschiedene Ehe',
            'Partnership' => 'Partnerschaft',
            'Fiancée' => 'Verlobung',
            ' with ' => ' mit ',
            'Biological parents of father' => 'Biologische Eltern des Vaters',
            'Biological parents of mother' => 'Biologische Eltern der Mutter',
            'Biological parents of parent' => 'Biologische Eltern eines Elternteils',
            'Biological grandparents' => 'Biologische Großeltern',
            'Stepparents of father' => 'Stiefeltern des Vaters',
            'Stepparents of mother' => 'Stiefeltern der Mutter',
            'Stepparents of parent' => 'Stiefeltern eines Elternteils',
            'Parents of stepparents' => 'Eltern eines Stiefelternteils',
            'Siblings of father' => 'Geschwister des Vaters',
            'Siblings of mother' => 'Geschwister der Mutter',
            'Full siblings of biological parents' => 'Vollbürtige Geschwister der biologischen Eltern',
            'Siblings-in-law of father' => 'Schwäger und Schwägerinnen des Vaters',
            'Siblings-in-law of mother' => 'Schwäger und Schwägerinnen der Mutter',
            'Biological parents' => 'Biologische Eltern',
            'Stepparents' => 'Stiefeltern',
            'Parents-in-law of biological children' => 'Schwiegereltern der biologischen Kinder',
            'Parents-in-law of stepchildren' => 'Schwiegereltern der Stiefkinder',
            'Full siblings' => 'Vollbürtige Geschwister',
            'Half siblings' => 'Halbbürtige Geschwister',
            'Stepsiblings' => 'Stiefgeschwister',
            'Children of full siblings of father' => 'Kinder der vollbürtigen Geschwister des Vaters',
            'Children of full siblings of mother' => 'Kinder der vollbürtigen Geschwister der Mutter',
            'Children of full siblings of parent' => 'Kinder der vollbürtigen Geschwister eines Elternteils',
            'Children of half siblings of father' => 'Kinder der halbbürtigen Geschwister des Vaters',
            'Children of half siblings of mother' => 'Kinder der halbbürtigen Geschwister der Mutter',
            'Children of half siblings of parent' => 'Kinder der halbbürtigen Geschwister eines Elternteils',
            'Siblings of partners' => 'Geschwister der Partner',
            'Partners of siblings' => 'Partner der Geschwister',
            'Siblings of siblings-in-law' => 'Geschwister der Schwäger und Schwägerinnen',
            'Partners of siblings-in-law' => 'Partner der Schwäger und Schwägerinnen',
            'Children of full siblings of biological parents' => 'Kinder der vollbürtigen Geschwister der biologischen Eltern',
            'Children of siblings' => 'Kinder der Geschwister',
            'Children of full siblings' => 'Kinder der vollbürtigen Geschwister',
            'Siblings\' stepchildren' => 'Stiefkinder der Geschwister',
            'Children of siblings of partners' => 'Kinder der Geschwister der Partner',
            'Biological children' => 'Biologische Kinder',
            'Stepchildren' => 'Stiefkinder',
            'Stepchild' => 'Stiefkind',
            'Stepson' => 'Stiefsohn',
            'Stepdaughter' => 'Stieftochter',
            'Partners of biological children' => 'Partner der biologischen Kinder',
            'Partners of stepchildren' => 'Partner der Stiefkinder',
            'Biological grandchildren' => 'Biologische Enkelkinder',
            'Stepchildren of children' => 'Stiefkinder der Kinder',
            'Children of stepchildren' => 'Kinder der Stiefkinder',
            'Stepchildren of stepchildren' => 'Stiefkinder der Stiefkinder',

            'He' => 'ihn', // Kontext "Für ihn"
            'She' => 'sie', // Kontext "Für sie"
            'He/she' => 'ihn/sie', // Kontext "Für ihn/sie"
            'Mr.' => 'Herrn', // Kontext "Für Herrn xxx"
            'Mrs.' => 'Frau', // Kontext "Für Frau xxx"
            'No family available' => 'Es wurde keine Familie gefunden.',
            'Parts of extended family without recorded information' => 'Teile der erweiterten Familie ohne Angaben',
            '%s has no %s recorded.' => 'Für %s sind keine %s verzeichnet.',
            '%s has no %s, and no %s recorded.' => 'Für %s sind keine %s und keine %s verzeichnet.',
            'Father\'s family (%d)' => 'Familie des Vaters (%d)',
            'Mother\'s family (%d)' => 'Familie der Mutter (%d)',
            'Father\'s and Mother\'s family (%d)' => 'Familie des Vaters und der Mutter (%d)',
            'Parents %1$s of %2$s' => 'Eltern %1$s von %2$s',
            'Parents %1$s (%2$s) of %3$s' => 'Eltern %1$s (%2$s) von %3$s',
            'Partners of %s' => 'Partner von %s',
            'Brother %1$s of partner %2$s' => 'Bruder %1$s von Partner %2$s',
            'Sister %1$s of partner %2$s' => 'Schwester %1$s von Partner %2$s',
            'Sibling %1$s of partner %2$s' => 'Geschwister %1$s von Partner %2$s',

            'Grandparents' => 'Großeltern',
            '%s has no grandparents recorded.' => 'Für %s sind keine Großeltern verzeichnet.',
            '%s has one grandmother recorded.' => 'Für %s ist eine Großmutter verzeichnet.',
            '%s has one grandfather recorded.' => 'Für %s ist ein Großvater verzeichnet.',
            '%s has one grandparent of unknown sex recorded.' => 'Für %s ist ein Großelternteil mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d grandmothers recorded.'
                => 'Für %2$s ist %1$d Großmutter verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Großmütter verzeichnet.',
            '%2$s has %1$d grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d grandfathers recorded.'
                => 'Für %2$s ist %1$d Großvater verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Großväter verzeichnet.',
            '%2$s has %1$d grandparent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandparents of unknown sex recorded.'
                => 'Für %2$s ist %1$d Großelternteil mit unbekanntem Geschlecht verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Großelternteile mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d grandfather and ' . I18N::PLURAL . '%2$s has %1$d grandfathers and ' 
                => 'Für %2$s sind %1$d Großvater und ' . I18N::PLURAL . 'Für %2$s sind %1$d Großväter und ',
            '%d grandmother recorded (%d in total).' . I18N::PLURAL . '%d grandmothers recorded (%d in total).' 
                => '%d Großmutter verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Großmütter verzeichnet (insgesamt %d).',
            '%2$s has %1$d grandmother and ' . I18N::PLURAL . '%2$s has %1$d grandmothers and '
                => 'Für %2$s sind %1$d Großmutter und ' . I18N::PLURAL . 'Für %2$s sind %1$d Großmütter und ',
            '%d grandparent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandparents of unknown sex recorded (%d in total).'
                => '%d Großelternteil mit unbekanntem Geschlecht verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Großelternteile mit unbekanntem Geschlecht verzeichnet (insgesamt %d).',
            '%2$s has %1$d grandfather, ' . I18N::PLURAL . '%2$s has %1$d grandfathers, '
                => 'Für %2$s sind %1$d Großvater, ' . I18N::PLURAL . 'Für %2$s sind %1$d Großväter, ',
            '%d grandmother, and ' . I18N::PLURAL . '%d grandmothers, and '
                => '%d Großmutter und ' . I18N::PLURAL . '%d Großmütter und ',

            'Uncles and Aunts' => 'Onkel und Tanten',
            '%s has no uncles or aunts recorded.' => 'Für %s sind keine Onkel oder Tanten verzeichnet.',
            '%s has one aunt recorded.' => 'Für %s ist eine Tante verzeichnet.',
            '%s has one uncle recorded.' => 'Für %s ist ein Onkel verzeichnet.',
            '%s has one uncle or aunt of unknown sex recorded.' => 'Für %s ist ein Onkel oder eine Tante mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d aunt recorded.' . I18N::PLURAL . '%2$s has %1$d aunts recorded.'
                => 'Für %2$s ist %1$d Tante verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Tanten verzeichnet.',
            '%2$s has %1$d uncle recorded.' . I18N::PLURAL . '%2$s has %1$d uncles recorded.'
                => 'Für %2$s ist %1$d Onkel verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Onkel verzeichnet.',
            '%2$s has %1$d uncle or aunt of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d uncles or aunts of unknown sex recorded.'
                => 'Für %2$s ist %1$d Onkel oder Tante mit unbekanntem Geschlecht verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Onkel oder Tanten mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and ' 
                => 'Für %2$s sind %1$d Onkel und ' . I18N::PLURAL . 'Für %2$s sind %1$d Onkel und ',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).'
                => '%d Tante verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Tanten verzeichnet (insgesamt %d).',
            '%2$s has %1$d aunt and ' . I18N::PLURAL . '%2$s has %1$d aunts and '
                => 'Für %2$s sind %1$d Tante und ' . I18N::PLURAL . 'Für %2$s sind %1$d Tanten und ',
            '%d uncle or aunt of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d uncles or aunts of unknown sex recorded (%d in total).'
                => '%d Onkel oder eine Tante mit unbekanntem Geschlecht verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Onkel oder Tanten mit unbekanntem Geschlecht verzeichnet (insgesamt %d).',
            '%2$s has %1$d uncle, ' . I18N::PLURAL . '%2$s has %1$d uncles, '
                => 'Für %2$s sind %1$d Onkel, ' . I18N::PLURAL . 'Für %2$s sind %1$d Onkel, ',
            '%d aunt, and ' . I18N::PLURAL . '%d aunts, and '
                => '%d Tante und ' . I18N::PLURAL . '%d Tanten und ',

            'Uncles and Aunts by marriage' => 'Angeheiratete Onkel und Tanten',
            '%s has no uncles or aunts by marriage recorded.' => 'Für %s sind keine angeheirateten Onkel oder Tanten verzeichnet.',
            '%s has one aunt by marriage recorded.' => 'Für %s ist eine angeheiratete Tante verzeichnet.',
            '%s has one uncle by marriage recorded.' => 'Für %s ist ein angeheirateter Onkel verzeichnet.',
            '%s has one uncle or aunt by marriage of unknown sex recorded.' => 'Für %s ist ein angeheirateter Onkel oder eine angeheiratete Tante mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d aunt by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d aunts by marriage recorded.'
                => 'Für %2$s ist %1$d angeheiratete Tante verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d angeheiratete Tanten verzeichnet.',
            '%2$s has %1$d uncle by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d uncles by marriage recorded.'
                => 'Für %2$s ist %1$d angeheirateter Onkel verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d angeheiratete Onkel verzeichnet.',
            '%2$s has %1$d uncle or aunt by marriage of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d uncles or aunts by marriage of unknown sex recorded.'
                => 'Für %2$s ist %1$d angeheirateter Onkel oder Tante mit unbekanntem Geschlecht verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d angeheiratete Onkel oder Tanten mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d uncle by marriage and ' . I18N::PLURAL . '%2$s has %1$d uncles by marriage and '
                => 'Für %2$s sind %1$d angeheiratete Onkel und ' . I18N::PLURAL . 'Für %2$s sind %1$d angeheiratete Onkel und ',
            '%d aunt by marriage recorded (%d in total).' . I18N::PLURAL . '%d aunts by marriage recorded (%d in total).'
                => '%d Tante verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Tanten verzeichnet (insgesamt %d).',
            '%2$s has %1$d aunt by marriage and ' . I18N::PLURAL . '%2$s has %1$d aunts by marriage and '
                => 'Für %2$s sind %1$d angeheiratete Tante und ' . I18N::PLURAL . 'Für %2$s sind %1$d angeheiratete Tanten und ',
            '%d uncle or aunt by marriage of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d uncles or aunts by marriage of unknown sex recorded (%d in total).'
                => '%d angeheirateter Onkel oder eine angeheiratete Tante mit unbekanntem Geschlecht verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d angeheiratete Onkel oder Tanten mit unbekanntem Geschlecht verzeichnet (insgesamt %d).',
            '%2$s has %1$d uncle by marriage, ' . I18N::PLURAL . '%2$s has %1$d uncles by marriage, '
                => 'Für %2$s sind %1$d angeheirateter Onkel, ' . I18N::PLURAL . 'Für %2$s sind %1$d angeheiratete Onkel, ',
            '%d aunt by marriage, and ' . I18N::PLURAL . '%d aunts by marriage, and '
                => '%d angeheiratete Tante und ' . I18N::PLURAL . '%d angeheiratete Tanten und ',

            'Parents' => 'Eltern',
            '%s has no parents recorded.' => 'Für %s sind keine Eltern verzeichnet.',
            '%s has one mother recorded.' => 'Für %s ist eine Mutter verzeichnet.',
            '%s has one father recorded.' => 'Für %s ist ein Vater verzeichnet.',
            '%s has one parent of unknown sex recorded.' => 'Für %s ist ein Elternteil mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d mother recorded.' . I18N::PLURAL . '%2$s has %1$d mothers recorded.'
                => 'Für %2$s ist %1$d Mutter verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Mütter verzeichnet.',
            '%2$s has %1$d father recorded.' . I18N::PLURAL . '%2$s has %1$d fathers recorded.'
                => 'Für %2$s ist %1$d Vater verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Väter verzeichnet.',
            '%2$s has %1$d parent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d parents of unknown sex recorded.'
                => 'Für %2$s ist %1$d Elternteil mit unbekanntem Geschlecht verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Elternteile mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d father and ' . I18N::PLURAL . '%2$s has %1$d fathers and '
                => 'Für %2$s sind %1$d Vater und ' . I18N::PLURAL . 'Für %2$s sind %1$d Väter und ',
            '%d mother recorded (%d in total).' . I18N::PLURAL . '%d mothers recorded (%d in total).'
                => '%d Mutter verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Mütter verzeichnet (insgesamt %d).',
            '%2$s has %1$d mother and ' . I18N::PLURAL . '%2$s has %1$d mothers and '
                => 'Für %2$s sind %1$d Mutter und ' . I18N::PLURAL . 'Für %2$s sind %1$d Mütter und ',
            '%d parent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d parents of unknown sex recorded (%d in total).'
                => '%d Elternteil mit unbekanntem Geschlecht verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Elternteile mit unbekanntem Geschlecht verzeichnet (insgesamt %d).',
            '%2$s has %1$d father, ' . I18N::PLURAL . '%2$s has %1$d fathers, '
                => 'Für %2$s sind %1$d Vater, ' . I18N::PLURAL . 'Für %2$s sind %1$d Väter, ',
            '%d mother, and ' . I18N::PLURAL . '%d mothers, and '
                => '%d Mutter und ' . I18N::PLURAL . '%d Mütter und ',
            
            'Parents-in-law' => 'Schwiegereltern',
            '%s has no parents-in-law recorded.' => 'Für %s sind keine Schwiegereltern verzeichnet.',
            '%s has one mother-in-law recorded.' => 'Für %s ist eine Schwiegermutter verzeichnet.',
            '%s has one father-in-law recorded.' => 'Für %s ist ein Schwiegervater verzeichnet.',
            '%s has one parent-in-law of unknown sex recorded.' => 'Für %s ist ein Schwiegerelternteil mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d mothers-in-law recorded.'
                => 'Für %2$s ist %1$d Schwiegermutter verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Schwiegermütter verzeichnet.',
            '%2$s has %1$d father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d fathers-in-law recorded.'
                => 'Für %2$s ist %1$d Schwiegervater verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Schwiegerväter verzeichnet.',
            '%2$s has %1$d parent-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d parents-in-law of unknown sex recorded.'
                => 'Für %2$s ist %1$d Schwiegerelternteil mit unbekanntem Geschlecht verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Schwiegerelternteile mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d father-in-law and ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law and '
                => 'Für %2$s sind %1$d Schwiegervater und ' . I18N::PLURAL . 'Für %2$s sind %1$d Schwiegerväter und ',
            '%d mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d mothers-in-law recorded (%d in total).'
                => '%d Schwiegermutter verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Schwiegermütter verzeichnet (insgesamt %d).',
            '%2$s has %1$d mother-in-law and ' . I18N::PLURAL . '%2$s has %1$d mothers-in-law and '
            => 'Für %2$s sind %1$d Schwiegermutter und ' . I18N::PLURAL . 'Für %2$s sind %1$d Schwiegermütter und ',
            '%d parent-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d parents-in-law of unknown sex recorded (%d in total).'
            => '%d Schwiegerelternteil mit unbekanntem Geschlecht verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Schwiegerelternteile mit unbekanntem Geschlecht verzeichnet (insgesamt %d).',
            '%2$s has %1$d father-in-law, ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law, '
            => 'Für %2$s sind %1$d Schwiegervater, ' . I18N::PLURAL . 'Für %2$s sind %1$d Schwiegerväter, ',
            '%d mother-in-law, and ' . I18N::PLURAL . '%d mothers-in-law, and '
            => '%d Schwiegermutter und ' . I18N::PLURAL . '%d Schwiegermütter und ',
 
            'Co-parents-in-law' => 'Gegenschwiegereltern',
            '%s has no co-parents-in-law recorded.' => 'Für %s sind keine Gegenschwiegereltern verzeichnet.',
            '%s has one co-mother-in-law recorded.' => 'Für %s ist eine Gegenschwiegermutter verzeichnet.',
            '%s has one co-father-in-law recorded.' => 'Für %s ist ein Gegenschwiegervater verzeichnet.',
            '%s has one co-parent-in-law of unknown sex recorded.' => 'Für %s ist ein Gegenschwiegerelternteil mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d co-mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law recorded.'
                => 'Für %2$s ist %1$d Gegenschwiegermutter verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Gegenschwiegermütter verzeichnet.',
            '%2$s has %1$d co-father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law recorded.'
                => 'Für %2$s ist %1$d Gegenschwiegervater verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Gegenschwiegerväter verzeichnet.',
            '%2$s has %1$d co-parent-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d co-parents-in-law of unknown sex recorded.'
                => 'Für %2$s ist %1$d Gegenschwiegerelternteil mit unbekanntem Geschlecht verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Gegenschwiegerelternteile mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d co-father-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law and '
                => 'Für %2$s sind %1$d Gegenschwiegervater und ' . I18N::PLURAL . 'Für %2$s sind %1$d Gegenschwiegerväter und ',
            '%d co-mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-mothers-in-law recorded (%d in total).'
                => '%d Gegenschwiegermutter verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Gegenschwiegermütter verzeichnet (insgesamt %d).',
            '%2$s has %1$d co-mother-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law and '
                => 'Für %2$s sind %1$d Gegenschwiegermutter und ' . I18N::PLURAL . 'Für %2$s sind %1$d Gegenschwiegermütter und ',
            '%d co-parent-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d co-parents-in-law of unknown sex recorded (%d in total).'
                => '%d Gegenschwiegerelternteil mit unbekanntem Geschlecht verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Gegenschwiegerelternteile mit unbekanntem Geschlecht verzeichnet (insgesamt %d).',
            '%2$s has %1$d co-father-in-law, ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law, '
                => 'Für %2$s sind %1$d Gegenschwiegervater, ' . I18N::PLURAL . 'Für %2$s sind %1$d Gegenschwiegerväter, ',
            '%d co-mother-in-law, and ' . I18N::PLURAL . '%d co-mothers-in-law, and '
                => '%d Gegenschwiegermutter und ' . I18N::PLURAL . '%d Gegenschwiegermütter und ',

            'Partners' => 'Partner',
            'Partner of ' => 'Partner von ',
            '%s has no partners recorded.' => 'Für %s sind keine Partner verzeichnet.',
            '%s has one female partner recorded.' => 'Für %s ist eine Partnerin verzeichnet.',
            '%s has one male partner recorded.' => 'Für %s ist ein Partner verzeichnet.',
            '%s has one partner of unknown sex recorded.' => 'Für %s ist ein Partner mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d female partner recorded.' . I18N::PLURAL . '%2$s has %1$d female partners recorded.'
                => 'Für %2$s ist %1$d Partnerin verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Partnerinnen verzeichnet.',
            '%2$s has %1$d male partner recorded.' . I18N::PLURAL . '%2$s has %1$d male partners recorded.'
                => 'Für %2$s ist %1$d Partner verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Partner verzeichnet.',
            '%2$s has %1$d partner of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d partners of unknown sex recorded.'
                => 'Für %2$s ist %1$d Partner mit unbekanntem Geschlecht verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Partner mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and '
                => 'Für %2$s sind %1$d Partner und ' . I18N::PLURAL . 'Für %2$s sind %1$d Partner und ',
            '%2$s has %1$d female partner and ' . I18N::PLURAL . '%2$s has %1$d female partners and '
                => 'Für %2$s sind %1$d Partnerin und ' . I18N::PLURAL . 'Für %2$s sind %1$d Partnerinnen und ',
            '%d female partner recorded (%d in total).' . I18N::PLURAL . '%d female partners recorded (%d in total).'
                => '%d Partnerin verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Partnerinnen verzeichnet (insgesamt %d).',
            '%2$s has %1$d partner and ' . I18N::PLURAL . '%2$s has %1$d partners and '
                => 'Für %2$s sind %1$d Partner und ' . I18N::PLURAL . 'Für %2$s sind %1$d Partner und ',
            '%d male partner of female partners recorded (%d in total).' . I18N::PLURAL . '%d male partners of female partners recorded (%d in total).'
                => '%d Partner von Partnerinnen verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Partner von Partnerinnen verzeichnet (insgesamt %d).',
            '%d female partner of male partners recorded (%d in total).' . I18N::PLURAL . '%d female partners of male partners recorded (%d in total).'
                => '%d Partnerin von Partnern verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Partnerinnen von Partnern verzeichnet (insgesamt %d).',

            'Partner chains' => 'Partnerketten',
            '%s has no members of a partner chain recorded.' => 'Für %s sind keine Mitglieder einer Partnerkette verzeichnet.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and '
                => 'Für %2$s sind %1$d männlicher Partner und ' . I18N::PLURAL . 'Für %2$s sind %1$d männliche Partner und ',
            '%d female partner in this partner chain recorded (%d in total).' . I18N::PLURAL . '%d female partners in this partner chain recorded (%d in total).'
                => '%d Partnerin in dieser Partnerkette verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Partnerinnen in dieser Partnerkette verzeichnet (insgesamt %d).',
            '%d female partner and ' . I18N::PLURAL . '%d female partners and '
                => '%d Partnerin und ' . I18N::PLURAL . '%d Partnerinnen und ',
            '%d partner of unknown sex in this partner chain recorded (%d in total).' . I18N::PLURAL . '%d partners of unknown sex in this partner chain recorded (%d in total).'
                => '%d Partner mit unbekanntem Geschlecht in dieser Partnerkette verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Partner mit unbekanntem Geschlecht in dieser Partnerkette verzeichnet (insgesamt %d).',
            '%2$s has %1$d female partner and ' . I18N::PLURAL . '%2$s has %1$d female partners and '
                => 'Für %2$s sind %1$d Partnerin und ' . I18N::PLURAL . 'Für %2$s sind %1$d Partnerinnen und ',
            '%d partner of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d partners of unknown sex recorded (%d in total).'
                => '%d Partner mit unbekanntem Geschlecht verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Partner mit unbekanntem Geschlecht verzeichnet (insgesamt %d).',
            '%2$s has %1$d male partner, ' . I18N::PLURAL . '%2$s has %1$d male partners, '
                => 'Für %2$s sind %1$d männlicher Partner, ' . I18N::PLURAL . 'Für %2$s sind %1$d männliche Partner, ',
            '%d female partner, and ' . I18N::PLURAL . '%d female partners, and '
                => '%d Partnerin und ' . I18N::PLURAL . '%d Partnerinnen und ',
            'There are %d branches in the partner chain. ' => 'Es gibt %d Zweige in der Partnerkette.',
            'The longest branch in the partner chain to %2$s consists of %1$d partners (including %3$s).' => 'Der längste Zweig in der Partnerkette zu %2$s besteht aus %1$d Partnern (einschließlich %3$s).',
            'The longest branch in the partner chain consists of %1$d partners (including %2$s).' => 'Der längste Zweig in der Partnerkette besteht aus %1$d Partnern (einschließlich %2$s).',

            'Siblings' => 'Geschwister',
            '%s has no siblings recorded.' => 'Für %s sind keine Geschwister verzeichnet.',
            '%s has one sister recorded.' => 'Für %s ist eine Schwester verzeichnet.',
            '%s has one brother recorded.' => 'Für %s ist ein Bruder verzeichnet.',
            '%s has one sibling of unknown sex recorded.' => 'Für %s ist ein Geschwister mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d sister recorded.' . I18N::PLURAL . '%2$s has %1$d sisters recorded.'
                => 'Für %2$s ist %1$d Schwester verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Schwestern verzeichnet.',
            '%2$s has %1$d brother recorded.' . I18N::PLURAL . '%2$s has %1$d brothers recorded.'
                => 'Für %2$s ist %1$d Bruder verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Brüder verzeichnet.',
            '%2$s has %1$d sibling of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d siblings of unknown sex recorded.'
                => 'Für %2$s ist %1$d Geschwister mit unbekanntem Geschlecht verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Geschwister mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d brother and ' . I18N::PLURAL . '%2$s has %1$d brothers and ' 
                => 'Für %2$s sind %1$d Bruder und ' . I18N::PLURAL . 'Für %2$s sind %1$d Brüder und ',
            '%d sister recorded (%d in total).' . I18N::PLURAL . '%d sisters recorded (%d in total).' 
                => '%d Schwester verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Schwestern verzeichnet (insgesamt %d).',
            '%2$s has %1$d sister and ' . I18N::PLURAL . '%2$s has %1$d sisters and '
                => 'Für %2$s sind %1$d Schwester und ' . I18N::PLURAL . 'Für %2$s sind %1$d Schwestern und ',
            '%d sibling of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d siblings of unknown sex recorded (%d in total).'
                => '%d Geschwister mit unbekanntem Geschlecht verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Geschwister mit unbekanntem Geschlecht verzeichnet (insgesamt %d).',
            '%2$s has %1$d brother, ' . I18N::PLURAL . '%2$s has %1$d brothers, '
                => 'Für %2$s sind %1$d Bruder, ' . I18N::PLURAL . 'Für %2$s sind %1$d Brüder, ',
            '%d sister, and ' . I18N::PLURAL . '%d sisters, and '
                => '%d Schwester und ' . I18N::PLURAL . '%d Schwestern und ',
            
            'Siblings-in-law' => 'Schwäger und Schwägerinnen',
            '%s has no siblings-in-law recorded.' => 'Für %s sind weder Schwäger noch Schwägerinnen verzeichnet.',
            '%s has one sister-in-law recorded.' => 'Für %s ist eine Schwägerin verzeichnet.',
            '%s has one brother-in-law recorded.' => 'Für %s ist ein Schwager verzeichnet.',
            '%s has one sibling-in-law of unknown sex recorded.' => 'Für %s ist ein Schwager oder eine Schwägerin mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sisters-in-law recorded.'
                => 'Für %2$s ist %1$d Schwägerin verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Schwägerinnen verzeichnet.',
            '%2$s has %1$d brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d brothers-in-law recorded.'
                => 'Für %2$s ist %1$d Schwager verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Schwäger verzeichnet.',
            '%2$s has %1$d sibling-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d siblings-in-law of unknown sex recorded.'
                => 'Für %2$s ist %1$d Schwager oder eine Schwägerin mit unbekanntem Geschlecht verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Schwäger oder Schwägerinnen mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law and ' 
                => 'Für %2$s sind %1$d Schwager und ' . I18N::PLURAL . 'Für %2$s sind %1$d Schwäger und ',
            '%d sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d sisters-in-law recorded (%d in total).' 
                => '%d Schwägerin verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Schwägerinnen verzeichnet (insgesamt %d).',
            '%2$s has %1$d sister-in-law and ' . I18N::PLURAL . '%2$s has %1$d sisters-in-law and '
                => 'Für %2$s sind %1$d Schwägerin und ' . I18N::PLURAL . 'Für %2$s sind %1$d Schwägerinnen und ',
            '%d sibling-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d siblings-in-law of unknown sex recorded (%d in total).'
                => '%d Schwager oder eine Schwägerin mit unbekanntem Geschlecht verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Schwäger oder Schwägerinnen mit unbekanntem Geschlecht verzeichnet (insgesamt %d).',
            '%2$s has %1$d brother-in-law, ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law, '
                => 'Für %2$s sind %1$d Schwager, ' . I18N::PLURAL . 'Für %2$s sind %1$d Schwäger, ',
            '%d sister-in-law, and ' . I18N::PLURAL . '%d sisters-in-law, and '
                => '%d Schwägerin und ' . I18N::PLURAL . '%d Schwägerinnen und ',

            'Co-siblings-in-law' => 'Schwippschwäger und Schwippschwägerinnen',
            '%s has no co-siblings-in-law recorded.' => 'Für %s sind weder Schwippschwäger noch Schwippschwägerinnen verzeichnet.',
            '%s has one co-sister-in-law recorded.' => 'Für %s ist eine Schwippschwägerin verzeichnet.',
            '%s has one co-brother-in-law recorded.' => 'Für %s ist ein Schwippschwager verzeichnet.',
            '%s has one co-sibling-in-law of unknown sex recorded.' => 'Für %s ist ein Schwippschwager oder eine Schwippschwägerin mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d co-sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-sisters-in-law recorded.'
                => 'Für %2$s ist %1$d Schwippschwägerin verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Schwippschwägerinnen verzeichnet.',
            '%2$s has %1$d co-brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law recorded.'
                => 'Für %2$s ist %1$d Schwippschwager verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Schwippschwäger verzeichnet.',
            '%2$s has %1$d co-sibling-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d co-siblings-in-law of unknown sex recorded.'
                => 'Für %2$s ist %1$d Schwippschwager oder eine Schwippschwägerin mit unbekanntem Geschlecht verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Schwippschwäger oder Schwippschwägerinnen mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d co-brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law and '
                => 'Für %2$s sind %1$d Schwippschwager und ' . I18N::PLURAL . 'Für %2$s sind %1$d Schwippschwäger und ',
            '%d co-sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-sisters-in-law recorded (%d in total).' 
                => '%d Schwippschwägerin verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Schwippschwägerinnen verzeichnet (insgesamt %d).',
            '%2$s has %1$d co-sister-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-sisters-in-law and '
                => 'Für %2$s sind %1$d Schwippschwägerin und ' . I18N::PLURAL . 'Für %2$s sind %1$d Schwippschwägerinnen und ',
            '%d co-sibling-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d co-siblings-in-law of unknown sex recorded (%d in total).'
                => '%d Schwippschwager oder eine Schwippschwägerin mit unbekanntem Geschlecht verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Schwippschwäger oder eine Schwippschwägerinnen mit unbekanntem Geschlecht verzeichnet (insgesamt %d).',
            '%2$s has %1$d co-brother-in-law, ' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law, '
                => 'Für %2$s sind %1$d Schwippschwager, ' . I18N::PLURAL . 'Für %2$s sind %1$d Schwippschwäger, ',
            '%d co-sister-in-law, and ' . I18N::PLURAL . '%d co-sisters-in-law, and '
                => '%d Schwippschwägerin und ' . I18N::PLURAL . '%d Schwippschwägerinnen und ',

            'Cousins' => 'Cousins und Cousinen',
            '%s has no first cousins recorded.' => 'Für %s sind keine Cousins und Cousinen ersten Grades verzeichnet.',
            '%s has one female first cousin recorded.' => 'Für %s ist eine Cousine ersten Grades verzeichnet.',
            '%s has one male first cousin recorded.' => 'Für %s ist ein Cousin ersten Grades verzeichnet.',
            '%s has one first cousin of unknown sex recorded.' => 'Für %s ist ein Cousin oder eine Cousine ersten Grades mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d female first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d female first cousins recorded.'
                => 'Für %2$s ist %1$d Cousine ersten Grades verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Cousinen ersten Grades verzeichnet.',
            '%2$s has %1$d male first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d male first cousins recorded.'
                => 'Für %2$s ist %1$d Cousin ersten Grades verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Cousins ersten Grades verzeichnet.',
            '%2$s has %1$d first cousin of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d first cousins of unknown sex recorded.'
                => 'Für %2$s ist %1$d Cousin oder eine Cousine ersten Grades mit unbekanntem Geschlecht verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Cousins oder Cousinen ersten Grades mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d male first cousin and ' . I18N::PLURAL . '%2$s has %1$d male first cousins and ' 
                => 'Für %2$s sind %1$d Cousin ersten Grades und ' . I18N::PLURAL . 'Für %2$s sind %1$d Cousins ersten Grades und ',
            '%d female first cousin recorded (%d in total).' . I18N::PLURAL . '%d female first cousins recorded (%d in total).' 
                => '%d Cousine ersten Grades verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Cousinen ersten Grades verzeichnet (insgesamt %d).',
            '%2$s has %1$d female first cousin and ' . I18N::PLURAL . '%2$s has %1$d female first cousins and '
                => 'Für %2$s sind %1$d Cousine ersten Grades und ' . I18N::PLURAL . 'Für %2$s sind %1$d Cousinen ersten Grades und ',
            '%d first cousin of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d first cousins of unknown sex recorded (%d in total).'
                => '%d Cousin oder eine Cousine ersten Grades mit unbekanntem Geschlecht verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Cousins oder Cousinen ersten Grades mit unbekanntem Geschlecht verzeichnet (insgesamt %d).',
            '%2$s has %1$d male first cousin, ' . I18N::PLURAL . '%2$s has %1$d male first cousins, '
                => 'Für %2$s sind %1$d Cousin ersten Grades, ' . I18N::PLURAL . 'Für %2$s sind %1$d Cousins ersten Grades, ',
            '%d female first cousin, and ' . I18N::PLURAL . '%d female first cousins, and '
                => '%d Cousine ersten Grades und ' . I18N::PLURAL . '%d Cousinen ersten Grades und ',

            'Nephews and Nieces' => 'Neffen und Nichten',
            '%s has no nephews or nieces recorded.' => 'Für %s sind keine Neffen oder Nichten verzeichnet.',
            '%s has one niece recorded.' => 'Für %s ist eine Nichte verzeichnet.',
            '%s has one nephew recorded.' => 'Für %s ist ein Neffe verzeichnet.',
            '%s has one nephew or niece of unknown sex recorded.' => 'Für %s ist ein Neffe oder eine Nichte mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d niece recorded.' . I18N::PLURAL . '%2$s has %1$d nieces recorded.'
                => 'Für %2$s ist %1$d Nichte verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Nichten verzeichnet.',
            '%2$s has %1$d nephew recorded.' . I18N::PLURAL . '%2$s has %1$d nephews recorded.'
                => 'Für %2$s ist %1$d Neffe verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Neffen verzeichnet.',
            '%2$s has %1$d nephew or niece of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d nephews or nieces of unknown sex recorded.'
            => 'Für %2$s ist %1$d Neffe oder eine Nichte mit unbekanntem Geschlecht verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Neffen oder Nichten mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d nephew and ' . I18N::PLURAL . '%2$s has %1$d nephews and '
                => 'Für %2$s sind %1$d Neffe und ' . I18N::PLURAL . 'Für %2$s sind %1$d Neffen und ',
            '%d niece recorded (%d in total).' . I18N::PLURAL . '%d nieces recorded (%d in total).' 
                => '%d Nichte verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Nichten verzeichnet (insgesamt %d).',
            '%2$s has %1$d niece and ' . I18N::PLURAL . '%2$s has %1$d nieces and '
                => 'Für %2$s sind %1$d Nichte und ' . I18N::PLURAL . 'Für %2$s sind %1$d Nichten und ',
            '%d nephew or niece of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d nephews or nieces of unknown sex recorded (%d in total).'
                => '%d Neffe oder eine Nichte mit unbekanntem Geschlecht verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Neffen oder Nichten mit unbekanntem Geschlecht verzeichnet (insgesamt %d).',
            '%2$s has %1$d nephew, ' . I18N::PLURAL . '%2$s has %1$d nephews, '
                => 'Für %2$s sind %1$d Neffe, ' . I18N::PLURAL . 'Für %2$s sind %1$d Neffen, ',
            '%d niece, and ' . I18N::PLURAL . '%d nieces, and '
                => '%d Nichte und ' . I18N::PLURAL . '%d Nichten und ',

            'Children' => 'Kinder',
            '%s has no children recorded.' => 'Für %s sind keine Kinder verzeichnet.',
            '%s has one daughter recorded.' => 'Für %s ist eine Tochter verzeichnet.',
            '%s has one son recorded.' => 'Für %s ist ein Sohn verzeichnet.',
            '%s has one child of unknown sex recorded.' => 'Für %s ist ein Kind mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d daughter recorded.' . I18N::PLURAL . '%2$s has %1$d daughters recorded.'
                => 'Für %2$s ist %1$d Tochter verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Töchter verzeichnet.',
            '%2$s has %1$d son recorded.' . I18N::PLURAL . '%2$s has %1$d sons recorded.'
                => 'Für %2$s ist %1$d Sohn verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Söhne verzeichnet.',
            '%2$s has %1$d child of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d children of unknown sex recorded.'
                => 'Für %2$s ist %1$d Kind mit unbekanntem Geschlecht verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Kinder mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d son and ' . I18N::PLURAL . '%2$s has %1$d sons and '
                => 'Für %2$s sind %1$d Sohn und ' . I18N::PLURAL . 'Für %2$s sind %1$d Söhne und ',
            '%d daughter recorded (%d in total).' . I18N::PLURAL . '%d daughters recorded (%d in total).' 
                => '%d Tochter verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Töchter verzeichnet (insgesamt %d).',
            '%2$s has %1$d daughter and ' . I18N::PLURAL . '%2$s has %1$d daughters and '
                => 'Für %2$s sind %1$d Tochter und ' . I18N::PLURAL . 'Für %2$s sind %1$d Töchter und ',
            '%d child of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d children of unknown sex recorded (%d in total).'
                => '%d Kind mit unbekanntem Geschlecht verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Kinder mit unbekanntem Geschlecht verzeichnet (insgesamt %d).',
            '%2$s has %1$d son, ' . I18N::PLURAL . '%2$s has %1$d sons, '
                => 'Für %2$s sind %1$d Sohn, ' . I18N::PLURAL . 'Für %2$s sind %1$d Söhne, ',
            '%d daughter, and ' . I18N::PLURAL . '%d daughters, and '
                => '%d Tochter und ' . I18N::PLURAL . '%d Töchter und ',

            'Children-in-law' => 'Schwiegerkinder',
            '%s has no children-in-law recorded.' => 'Für %s sind keine Schwiegerkinder verzeichnet.',
            '%s has one daughter-in-law recorded.' => 'Für %s ist eine Schwiegertochter verzeichnet.',
            '%s has one son-in-law recorded.' => 'Für %s ist ein Schwiegersohn verzeichnet.',
            '%s has one child-in-law of unknown sex recorded.' => 'Für %s ist ein Schwiegerkind mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d daughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d daughters-in-law recorded.'
                => 'Für %2$s ist %1$d Schwiegertochter verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Schwiegertöchter verzeichnet.',
            '%2$s has %1$d son-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sons-in-law recorded.'
                => 'Für %2$s ist %1$d Schwiegersohn verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Schwiegersöhne verzeichnet.',
            '%2$s has %1$d child-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d children-in-law recorded.'
                => 'Für %2$s ist %1$d Schwiegerkind mit unbekanntem Geschlecht verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Schwiegerkinder mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d son-in-law and ' . I18N::PLURAL . '%2$s has %1$d sons-in-law and '
                => 'Für %2$s sind %1$d Schwiegersohn und ' . I18N::PLURAL . 'Für %2$s sind %1$d Schwiegersöhne und ',
            '%d daughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d daughters-in-law recorded (%d in total).' 
                => '%d Schwiegertochter verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Schwiegertöchter verzeichnet (insgesamt %d).',
            '%2$s has %1$d daughter-in-law and ' . I18N::PLURAL . '%2$s has %1$d daughters-in-law and '
                => 'Für %2$s sind %1$d Schwiegertochter und ' . I18N::PLURAL . 'Für %2$s sind %1$d Schwiegertöchter und ',
            '%d child-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d children-in-law of unknown sex recorded (%d in total).'
                => '%d Schwiegerkind mit unbekanntem Geschlecht verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Schwiegerkinder mit unbekanntem Geschlecht verzeichnet (insgesamt %d).',
            '%2$s has %1$d son-in-law, ' . I18N::PLURAL . '%2$s has %1$d sons-in-law, '
                => 'Für %2$s sind %1$d Schwiegersohn, ' . I18N::PLURAL . 'Für %2$s sind %1$d Schwiegersöhne, ',
            '%d daughter-in-law, and ' . I18N::PLURAL . '%d daughters-in-law, and '
                => '%d Schwiegertochter und ' . I18N::PLURAL . '%d Schwiegertöchter und ',
                
            'Grandchildren' => 'Enkelkinder',
            '%s has no grandchildren recorded.' => 'Für %s sind keine Enkelkinder verzeichnet.',
            '%s has one granddaughter recorded.' => 'Für %s ist eine Enkeltochter verzeichnet.',
            '%s has one grandson recorded.' => 'Für %s ist ein Enkelsohn verzeichnet.',
            '%s has one grandchild of unknown sex recorded.' => 'Für %s ist ein Enkelkind mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d granddaughter recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters recorded.'
                => 'Für %2$s ist %1$d Enkeltochter verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Enkeltöchter verzeichnet.',
            '%2$s has %1$d grandson recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons recorded.'
                => 'Für %2$s ist %1$d Enkelsohn verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Enkelsöhne verzeichnet.',
            '%2$s has %1$d grandchild of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandchildren of unknown sex recorded.'
                => 'Für %2$s ist %1$d Enkelkind mit unbekanntem Geschlecht verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Enkelkinder mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d grandson and ' . I18N::PLURAL . '%2$s has %1$d grandsons and '
                => 'Für %2$s sind %1$d Enkelsohn und ' . I18N::PLURAL . 'Für %2$s sind %1$d Enkelsöhne und ',
            '%d granddaughter recorded (%d in total).' . I18N::PLURAL . '%d granddaughters recorded (%d in total).' 
                => '%d Enkeltochter verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Enkeltöchter verzeichnet (insgesamt %d).',
            '%2$s has %1$d granddaughter and ' . I18N::PLURAL . '%2$s has %1$d granddaughters and '
                => 'Für %2$s sind %1$d Enkeltochter und ' . I18N::PLURAL . 'Für %2$s sind %1$d Enkeltöchter und ',
            '%d grandchild of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandchildren of unknown sex recorded (%d in total).'
                => '%d Enkelkind mit unbekanntem Geschlecht verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Enkelkinder mit unbekanntem Geschlecht verzeichnet (insgesamt %d).',
            '%2$s has %1$d grandson, ' . I18N::PLURAL . '%2$s has %1$d grandsons, '
                => 'Für %2$s sind %1$d Enkelsohn, ' . I18N::PLURAL . 'Für %2$s sind %1$d Enkelsöhne, ',
            '%d granddaughter, and ' . I18N::PLURAL . '%d granddaughters, and '
                => '%d Enkeltochter und ' . I18N::PLURAL . '%d Enkeltöchter und ',
        ];
    }
    
    /**
     * @return array
     */
    public static function spanishTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Familia extendida',
            'A tab showing the extended family of an individual.' => 'Esta pestaña muestra todos los vinculos familiares de una persona',
            'In which sequence should the parts of the extended family be shown?' => '¿Que bloques de la familia quieres que se muestren, y en que orden, en la pestaña "Familia extendida"?',
            'Family part' => 'Bloques de la familia',
            'Show name of proband as short name or as full name?' => '¿Debe mostrarse una forma abreviada o el nombre completo de la persona?',
	        'Show options to filter the results (gender and alive/dead)?' => '¿Mostrar opciones para filtrar los resultados (género y vivo/muerto)?',
            'Show filter options' => 'Mostrar los filtros',
            'How should empty parts of extended family be presented?' => '¿Cómo quieres que se muestren los bloques vacíos en la pestaña "Familia extendida"?',
            'Show empty block' => 'Quieres que se muestren los bloques sin infromación?',
	        'yes, always at standard location' => 'Sí, mostrar bloques sin información en su posición estándar',
	        'no, but collect messages about empty blocks at the end' => 'No mostrar bloques sin información, pero poner una descripcción de los bloques que faltan al final',
	        'never' => 'No mostrar los bloques sin información',
            'The short name is based on the probands Rufname or nickname. If these are not available, the first of the given names is used, if one is given. Otherwise the last name is used.' => 'El nombre corto se basa en los apodos. Si estos no están disponibles, se utiliza el primero de los nombres de pila, si se da alguno. De lo contrario, se utiliza el apellido.',
            'Show short name' => 'Mostrar nombre corto',
            'Show labels in special situations?' => '¿Mostrar etiquetas en situaciones especiales?',
            'Labels (or stickers) are used for example for adopted persons or foster children.' => 'Las etiquetas se utilizan, por ejemplo, para personas adoptadas o niños de acogida. ',
            'Show labels' => 'Mostrar etiquetas',
            'Use the compact design?' => 'Usar el diseño compacto?',
            'Use the compact design' => 'Usar el diseño compacto',
            'The compact design only shows the name and life span for each person. The enriched design also shows a photo (if this is activated for this tree) as well as birth and death information.' => 'El diseño compacto solo muestra el nombre, fecha de nacimiento y fecha de la muerte de cada persona. El diseño enriquecido también muestra una foto (si tienes fotos en el perfil de los familiares en el árbol) así como información sobre el nacimiento y la muerte.',
			
            'don\'t use this filter' => 'No usar este filtro',
            'show only male persons' => 'Mostrar sólo hombres',
            'show only female persons' => 'Mostrar solo mujeres',
            'show only persons of unknown gender' => 'Mostrar solo personas de género desconocido',
            'show only alive persons' => 'Mostrar solo personas vivas',
            'show only dead persons' => 'Mostrar solo personas fallecidas',
            'alive' => 'Vivo',
            'dead' => 'Fallecido',
            'a dead person' => 'eine verstorbende Person',
            'a living person' => 'eine lebende Person',
            'not a male person' => 'No es un hombre',
            'not a female person' => 'No es una mujer',
            'not a person of unknown gender' => 'No es una persona de género desconocido',            
            
            'twin' => 'Mellizo',
            'triplet' => 'Trillizo',
            'quadruplet' => 'cuatrillizo',
            'quintuplet' => 'Quintillizo',
            'sextuplet' => 'Sextillizo',
            'septuplet' => 'Septillizo',
            'octuplet' => 'Octillizo',
            'nonuplet' => 'Nonallizos',
            'decuplet' => 'Decillizos',
            'stillborn' => 'nacido muerto',
            'died as infant' => 'Murió cuando era niño',
            'linkage challenged' => 'Disputa para ser reconocido',
            'linkage disproven' => 'No reconocido',
            'linkage proven' => 'Reconocido',

            'Marriage' => 'Matrimonio',
            'Ex-marriage' => 'Ex-matrimonio',
            'Partnership' => 'Cónyugue',
            'Fiancée' => 'Novia',
            ' with ' => ' con ',
            'Biological parents of father' => 'Abuelos biológicos por parte de padre',
            'Biological parents of mother' => 'Abuelos biológicos por parte de madre',
            'Biological parents of parent' => 'Padres biológicos',
            'Stepparents of father' => 'Padrastros del padre',
            'Stepparents of mother' => 'Padrastros de la madre',
            'Stepparents of parent' => 'Padrastros de los padres',
            'Parents of stepparents' => 'Padres de padrastros',
            'Siblings of father' => 'Hermanos del padre',
            'Siblings of mother' => 'Hermanos de la madre',
            'Siblings-in-law of father' => 'Hermanos políticos del padre',
            'Siblings-in-law of mother' => 'Hermanos políticos de la madre',
            'Biological parents' => 'Padres biológicos',
            'Stepparents' => 'Padrastros',
            'Parents-in-law of biological children' => 'Suegros de sus hijos/as biólogicos',
            'Parents-in-law of stepchildren' => 'Consuegros/as de hijastros',
            'Full siblings' => 'Todos los hermanos',
            'Half siblings' => 'Cuñados y cuñadas',
            'Stepsiblings' => 'Hermanastros',
            'Children of full siblings of father' => 'Primos y primas por parte de padre',
            'Children of full siblings of mother' => 'Primos y primas por parte de madre',
            'Children of full siblings of parent' => 'Primos y primas por parte de padres',
            'Children of half siblings of father' => 'Hijos de medio hermanos del padre',
            'Children of half siblings of mother' => 'Hijos de medio hermanos de la madre',
            'Children of half siblings of parent' => 'Hijos de medio hermanos de los padres',
            'Siblings of partners' => 'Hermanos/as del cónyuge',
            'Partners of siblings' => 'Cónyugues de sus hermanos/as',
            'Siblings of siblings-in-law' => 'Concuñados/as',
            'Partners of siblings-in-law' => 'Cónyuges de sus cuñados y cuñadas',
            'Children of siblings' => 'Hijos de hermanos',
            'Siblings\' stepchildren' => 'Hijastros de hermanos',
            'Children of siblings of partners' => 'Hijos de los hermanos del cónyuge',
            'Biological children' => 'Hijos biológicos',
            'Stepchildren' => 'Hijastros',
            'Stepchild' => 'Hijastras',
            'Stepson' => 'Hijastro',
            'Stepdaughter' => 'Hijastra',
            'Partners of biological children' => 'Cónyuges de los hijos biológicos',
            'Partners of stepchildren' => 'Cónyuge de hijastros',
            'Biological grandchildren' => 'Nietos biológicos',
            'Stepchildren of children' => 'Hijastros/as',
            'Children of stepchildren' => 'Hijos de hijastros/as',
            'Stepchildren of stepchildren' => 'Hijastro/a de hijastros',
            
            'He' => 'él',
            'She' => 'ella',
            'He/she' => 'él/ella',
            'Mr.' => 'Sr.',
            'Mrs.' => 'Sra.',
            'No family available' => 'No hay familia disponible',
            'Parts of extended family without recorded information' => 'Familiares de los que no hay información',
            '%s has no %s recorded.' => '%s no tiene %s registrados.',
            '%s has no %s, and no %s recorded.' => '%s no tiene %s ni %s registrados.',
            'Father\'s family (%d)' => 'Familia del padre (%d)',
            'Mother\'s family (%d)' => 'Familia de la madre (%d)',
            'Father\'s and Mother\'s family (%d)' => 'Familia del padre y de la Madre (%d)',
            'Parents %1$s of %2$s' => 'Padres %1$s de %2$s',
            'Parents %1$s (%2$s) of %3$s' => 'Padres %1$s (%2$s) de %3$s',
            'Partners of %s' => 'Cónyuge de %s',
            'Brother %1$s of partner %2$s' => 'Hermano %1$s de Cónyuge %2$s',
            'Sister %1$s of partner %2$s' => 'Hermana %1$s de Cónyuge %2$s',
            'Sibling %1$s of partner %2$s' => 'Hermanos %1$s de Cónyuge %2$s',
            
            'Grandparents' => 'Abuelos',
            '%s has no grandparents recorded.' => '%s no tiene Abuelos registrados.',
            '%s has one grandmother recorded.' => '%s tiene una Abuela registrada.',
            '%s has one grandfather recorded.' => '%s tiene un Abuelo registrado.',
            '%s has one grandparent recorded.' => '%s tiene un Abuelo registrado.',
            '%2$s has %1$d grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d grandmothers recorded.'
                => '%2$s tiene %1$d Abuela registrada.' . I18N::PLURAL . '%2$s tiene %1$d Abuelas registradas.',
            '%2$s has %1$d grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d grandfathers recorded.'
                => '%2$s tiene %1$d Abuelo registrado.' . I18N::PLURAL . '%2$s tiene %1$d Abuelos registrados.',
            '%2$s has %1$d grandfather and ' . I18N::PLURAL . '%2$s has %1$d grandfathers and '
                => '%2$s tiene %1$d Abuelo y ' . I18N::PLURAL . '%2$s tiene %1$d Abuelos y ',
            '%d grandmother recorded (%d in total).' . I18N::PLURAL . '%d grandmothers recorded (%d in total).'
                => '%d Abuela registrada (%d en total).' . I18N::PLURAL . '%d Abuelas registrados (%d en total).',
            
            'Uncles and Aunts' => 'Tíos y Tías',
            '%s has no uncles or aunts recorded.' => '%s no tiene Tíos registrados.',
            '%s has one aunt recorded.' => '%s tiene una Tía registrados.',
            '%s has one uncle recorded.' => '%s tiene un Tío registrados.',
            '%s has one uncle or aunt recorded.' => '%s tiene un Tío o Tía registrados.',
            '%2$s has %1$d aunt recorded.' . I18N::PLURAL . '%2$s has %1$d aunts recorded.'
                => '%2$s tiene %1$d Tía registrada.' . I18N::PLURAL . '%2$s tiene %1$d Tías registradas.',
            '%2$s has %1$d uncle recorded.' . I18N::PLURAL . '%2$s has %1$d uncles recorded.'
                => '%2$s tiene %1$d Tío registrado.' . I18N::PLURAL . '%2$s tiene %1$d Tíos registrados.',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and '
                => '%2$s tiene %1$d Tío y ' . I18N::PLURAL . '%2$s tiene %1$d Tíos y ',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).'
                => '%d Tía registrados (%d en total).' . I18N::PLURAL . '%d Tías registrados (%d en total).',

            'Uncles and Aunts by marriage' => 'Tíos y tías políticos',
            '%s has no uncles or aunts by marriage recorded.' => '%s no tiene Tíos políticos registrados.',
            '%s has one aunt by marriage recorded.' => '%s tiene una Tía política registrada.',
            '%s has one uncle by marriage recorded.' => '%s tiene un Tío político registrada.',
            '%s has one uncle or aunt by marriage recorded.' => '%s tiene un Tío o Tía político registrado.',
            '%2$s has %1$d aunt by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d aunts by marriage recorded.'
                => '%2$s tiene %1$d Tía política registrada.' . I18N::PLURAL . '%2$s tiene %1$d Tías políticas registradas.',
            '%2$s has %1$d uncle by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d uncles by marriage recorded.'
                => '%2$s tiene %1$d Tío político registrado.' . I18N::PLURAL . '%2$s tiene %1$d Tíos políticos registrados.',
            '%2$s has %1$d uncle by marriage and ' . I18N::PLURAL . '%2$s has %1$d uncles by marriage and '
                => '%2$s tiene %1$d Tío político y ' . I18N::PLURAL . '%2$s tiene %1$d Tíos políticos y ',
            '%d aunt by marriage recorded (%d in total).' . I18N::PLURAL . '%d aunts by marriage recorded (%d in total).'
                => '%d Tía política registrados (%d en total).' . I18N::PLURAL . '%d Tías políticas registrados (%d en total).',

            'Parents' => 'Padres',
            '%s has no parents recorded.' => '%s no tiene Padres registrados.',
            '%s has one mother recorded.' => '%s tiene una Madre registrados.',
            '%s has one father recorded.' => '%s tiene un Padre registrados.',
            '%s has one parent recorded.' => '%s tiene uno de los Padres registrados.',
            '%2$s has %1$d mother recorded.' . I18N::PLURAL . '%2$s has %1$d mothers recorded.'
                => '%2$s tiene %1$d Madre registrada.' . I18N::PLURAL . '%2$s tiene %1$d Madres registradas.',
            '%2$s has %1$d father recorded.' . I18N::PLURAL . '%2$s has %1$d fathers recorded.'
                => '%2$s tiene %1$d Padre registrado.' . I18N::PLURAL . '%2$s tiene %1$d Padres registrados.',
            '%2$s has %1$d father and ' . I18N::PLURAL . '%2$s has %1$d fathers and '
                => '%2$s tiene %1$d Padre y ' . I18N::PLURAL . '%2$s tiene %1$d Padres y ',
            '%d mother recorded (%d in total).' . I18N::PLURAL . '%d mothers recorded (%d in total).'
                => '%d Madre registrados (%d en total).' . I18N::PLURAL . '%d Madres registrados (%d en total).',
            
            'Parents-in-law' => 'Suegros',
            '%s has no parents-in-law recorded.' => '%s no tiene Suegros registrados.',
            '%s has one mother-in-law recorded.' => '%s tiene una Suegra registrada.',
            '%s has one father-in-law recorded.' => '%s tiene un Suegro registrado.',
            '%s has one parent-in-law recorded.' => '%s tine un suegro registrados.',
            '%2$s has %1$d mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d mothers-in-law recorded.'
                => '%2$s tiene %1$d Suegra registrados.' . I18N::PLURAL . '%2$s tiene %1$d Suegras registrados.',
            '%2$s has %1$d father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d fathers-in-law recorded.'
                => '%2$s tiene %1$d Suegro registrado.' . I18N::PLURAL . '%2$s tiene %1$d Suegros registrados.',
            '%2$s has %1$d father-in-law and ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law and ' 
                => '%2$s tiene %1$d Suegro y ' . I18N::PLURAL . '%2$s tiene %1$d Suegros y ',
            '%d mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d mothers-in-law recorded (%d in total).' 
                => '%d Suegra registrados (%d en total).' . I18N::PLURAL . '%d Suegras registrados (%d en total).',
            
            'Co-parents-in-law' => 'Consuegros',
            '%s has no co-parents-in-law recorded.' => '%s no tiene consuegros registrados.',
            '%s has one co-mother-in-law recorded.' => '%s tiene una consuegra registrada.',
            '%s has one co-father-in-law recorded.' => '%s tiene un consuegro registrado.',
            '%s has one co-parent-in-law recorded.' => '%s tiene un consuegro o consuegra registrado/a.',
            '%2$s has %1$d co-mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law recorded.'
                => '%2$s tiene %1$d Consuegra registrada.' . I18N::PLURAL . '%2$s tiene %1$d Consuegras registradas.',
            '%2$s has %1$d co-father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law recorded.'
                => '%2$s tiene %1$d Consuegro registrado.' . I18N::PLURAL . '%2$s tiene %1$d Consuegros registrados.',
            '%2$s has %1$d co-father-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law and '
                => '%2$s tiene %1$d Consuegro y ' . I18N::PLURAL . '%2$s tiene %1$d Consuegros y ',
            '%d co-mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-mothers-in-law recorded (%d in total).'
                => '%d Consuegra registrada (%d en total).' . I18N::PLURAL . '%d Consuegras registrados (%d en total).',

            'Siblings' => 'Hermanos y Hermanas',
            '%s has no siblings recorded.' => '%s no tiene Hermanos/as registrados.',
            '%s has one sister recorded.' => '%s tiene una Hermana registrada.',
            '%s has one brother recorded.' => '%s tiene un  Hermano registrado.',
            '%s has one brother or sister recorded.' => '%s tiene un Hermano o Hermana registrados.',
            '%2$s has %1$d sister recorded.' . I18N::PLURAL . '%2$s has %1$d sisters recorded.'
                => '%2$s tiene %1$d Hermana registrada.' . I18N::PLURAL . '%2$s tiene %1$d Hermanas registradas.',
            '%2$s has %1$d brother recorded.' . I18N::PLURAL . '%2$s has %1$d brothers recorded.'
                => '%2$s tiene %1$d Hermano registrado.' . I18N::PLURAL . '%2$s tiene %1$d Hermanos registrados.',
            '%2$s has %1$d brother and ' . I18N::PLURAL . '%2$s has %1$d brothers and '
                => '%2$s tiene %1$d Hermano y ' . I18N::PLURAL . '%2$s tiene %1$d Hermanos y ',
            '%d sister recorded (%d in total).' . I18N::PLURAL . '%d sisters recorded (%d in total).'
                => '%d Hermana registrados (%d en total).' . I18N::PLURAL . '%d Hermanas registrados (%d en total).',
            
            'Siblings-in-law' => 'Cuñados y Cuñadas',
            '%s has no siblings-in-law recorded.' => '%s no tiene cuñados/as registrados.',
            '%s has one sister-in-law recorded.' => '%s tiene una cuñada registrada.',
            '%s has one brother-in-law recorded.' => '%s un cuñado registrado.',
            '%s has one sibling-in-law recorded.' => '%s tiene un cuñado/a registrado.',
            '%2$s has %1$d sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sisters-in-law recorded.'
                => '%2$s tiene %1$d Cuñada registrada.' . I18N::PLURAL . '%2$s tiene %1$d Cuñadas registradas.',
            '%2$s has %1$d brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d brothers-in-law recorded.'
                => '%2$s tiene %1$d Cuñado registrado.' . I18N::PLURAL . '%2$s tiene %1$d Cuñados registrados.',
            '%2$s has %1$d brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law and '
                => '%2$s tiene %1$d Cuñado y ' . I18N::PLURAL . '%2$s tiene %1$d Cuñados y ',
            '%d sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d sisters-in-law recorded (%d in total).'
                => '%d Cuñada (%d en total).' . I18N::PLURAL . '%d Cuñadas registrados (%d en total).',

            'Co-siblings-in-law' => 'Concuñados y Concuñadas',
            '%s has no co-siblings-in-law recorded.' => '%s no tiene concuñados/as registrados.',
            '%s has one co-sister-in-law recorded.' => '%s tiene una concuñada registrada.',
            '%s has one co-brother-in-law recorded.' => '%s un concuñado registrado.',
            '%s has one co-sibling-in-law recorded.' => '%s tiene un concuñado/a registrado.',
            '%2$s has %1$d co-sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-sisters-in-law recorded.'
                => '%2$s tiene %1$d Concuñada registrada.' . I18N::PLURAL . '%2$s tiene %1$d Concuñadas registradas.',
            '%2$s has %1$d co-brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law recorded.'
                => '%2$s tiene %1$d Concuñado registrado.' . I18N::PLURAL . '%2$s tiene %1$d Concuñados registrados.',
            '%2$s has %1$d co-brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law and '
                => '%2$s tiene %1$d Concuñado y ' . I18N::PLURAL . '%2$s tiene %1$d Concuñados y ',
            '%d co-sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-sisters-in-law recorded (%d in total).'
                => '%d Concuñada (%d en total).' . I18N::PLURAL . '%d Concuñadas registrados (%d en total).',
                                
            'Partners' => 'Cónyuge',
            'Partner of ' => 'Cónyuge de ',
            '%s has no partners recorded.' => '%s no tiene Cónyuge registrado.',
            '%s has one female partner recorded.' => '%s tiene un Cónyuge registrado.',
            '%s has one male partner recorded.' => '%s tiene un Cónyuge registrado.',
            '%s has one partner recorded.' => '%s sólo tiene un Cónyuge registrado.',
            '%2$s has %1$d female partner recorded.' . I18N::PLURAL . '%2$s has %1$d female partners recorded.'
                => '%2$s tiene %1$d Cónyuge registrado.' . I18N::PLURAL . '%2$s tiene %1$d Cónyuges registrados.',
            '%2$s has %1$d male partner recorded.' . I18N::PLURAL . '%2$s has %1$d male partners recorded.'
                => '%2$s tiene %1$d Cónyuge registrado.' . I18N::PLURAL . '%2$s tiene %1$d Cónyuges registrados.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and ' 
                => '%2$s tiene %1$d Cónyuge y ' . I18N::PLURAL . '%2$s tiene %1$d Cónyuges y ',
            '%2$s has %1$d female partner and ' . I18N::PLURAL . '%2$s has %1$d female partners and ' 
                => '%2$s tiene %1$d Cónyuge y ' . I18N::PLURAL . '%2$s tiene %1$d Cónyuges y ',
            '%d female partner recorded (%d in total).' . I18N::PLURAL . '%d female partners recorded (%d in total).'
                => '%d Cónyuge registrado (%d en total).' . I18N::PLURAL . '%d Cónyuges registrados (%d en total).',
            '%2$s has %1$d partner and ' . I18N::PLURAL . '%2$s has %1$d partners and '
                => '%2$s tiene %1$d Cónyuge y ' . I18N::PLURAL . '%2$s tiene %1$d Cónyuges y ',
            '%d male partner of female partners recorded (%d in total).' . I18N::PLURAL . '%d male partners of female partners recorded (%d in total).'
                => '%d Cónyuge registrado (%d en total).' . I18N::PLURAL . '%d Cónyuges registrados (%d en total).',
            '%d female partner of male partners recorded (%d in total).' . I18N::PLURAL . '%d female partners of male partners recorded (%d in total).'
                => '%d Cónyuge registrado (%d en total).' . I18N::PLURAL . '%d Cónyuges registrados (%d en total).',

            'Partner chains' => 'Partnerketten',
            '%s has no members of a partner chain recorded.' => 'Für %s sind keine Mitglieder einer Partnerkette verzeichnet.', 
            'There are %d branches in the partner chain. ' => 'Es gibt %d Zweige in der Partnerkette.',
            'The longest branch in the partner chain to %2$s consists of %1$d partners (including %3$s).' => 'Der längste Zweig in der Partnerkette zu %2$s besteht aus %1$d Partnern (einschließlich %3$s).',
            'The longest branch in the partner chain consists of %1$d partners (including %2$s).' => 'Der längste Zweig in der Partnerkette besteht aus %1$d Partnern (einschließlich %2$s).',
            '%d female partner in this partner chain recorded (%d in total).' . I18N::PLURAL . '%d female partners in this partner chain recorded (%d in total).'
                =>'%d Partnerin in dieser Partnerkette verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Partnerinnen in dieser Partnerkette verzeichnet (insgesamt %d).',
            
            'Cousins' => 'Primos y Primas', 
            '%s has no first cousins recorded.' => '%s no tiene Primos ni Primas registrados.',
            '%s has one female first cousin recorded.' => '%s tiene una Prima registrada.',
            '%s has one male first cousin recorded.' => '%s tiene un Primo registrado.',
            '%s has one first cousin recorded.' => '%s tiene un Primo o Prima registrados.',
            '%2$s has %1$d female first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d female first cousins recorded.'
                => '%2$s tiene %1$d Prima registrada.' . I18N::PLURAL . '%2$s tiene %1$d Primas registradas.',
            '%2$s has %1$d male first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d male first cousins recorded.'
                => '%2$s tiene %1$d Primo registrado.' . I18N::PLURAL . '%2$s tiene %1$d Primos registrados.',
            '%2$s has %1$d male first cousin and ' . I18N::PLURAL . '%2$s has %1$d male first cousins and ' 
                => '%2$s tiene %1$d Primo y ' . I18N::PLURAL . '%2$s tiene %1$d Primos y ',
            '%d female first cousin recorded (%d in total).' . I18N::PLURAL . '%d female first cousins recorded (%d in total).' 
                => '%d Prima registrados (%d en total).' . I18N::PLURAL . '%d Primas registrados (%d en total).',
                
            'Nephews and Nieces' => 'Sobrinos y Sobrinas', 
            '%s has no nephews or nieces recorded.' => '%s no tiene Sobrinos ni Sobrinas registrados.',
            '%s has one niece recorded.' => '%s tiene una Sobrina registrada.',
            '%s has one nephew recorded.' => '%s tiene un Sobrino registrado.',
            '%s has one nephew or niece recorded.' => '%s tiene una Sobrina o Sobrino registrados.',
            '%2$s has %1$d niece recorded.' . I18N::PLURAL . '%2$s has %1$d nieces recorded.'
                => '%2$s tiene %1$d Sobrina registrada.' . I18N::PLURAL . '%2$s tiene %1$d Sobrinas registradas.',
            '%2$s has %1$d nephew recorded.' . I18N::PLURAL . '%2$s has %1$d nephews recorded.'
                => '%2$s tiene %1$d Sobrino registrado.' . I18N::PLURAL . '%2$s tiene %1$d Sobrinos registrados.',
            '%2$s has %1$d nephew and ' . I18N::PLURAL . '%2$s has %1$d nephews and '
                => '%2$s tiene %1$d Sobrino y ' . I18N::PLURAL . '%2$s tiene %1$d Sobrinos y ',
            '%d niece recorded (%d in total).' . I18N::PLURAL . '%d nieces recorded (%d in total).'
                => '%d Sobrina registrados (%d en total).' . I18N::PLURAL . '%d Sobrinas registrados (%d en total).',

            'Children' => 'Hijos e Hijas',   
            '%s has no children recorded.' => '%s no tiene Hijos registrados.',
            '%s has one daughter recorded.' => '%s tiene una Hija registrado.',
            '%s has one son recorded.' => '%s tiene un Hijo registrado.',
            '%s has one child recorded.' => '%s tiene un Hijo o Hija registrados.',
            '%2$s has %1$d daughter recorded.' . I18N::PLURAL . '%2$s has %1$d daughters recorded.'
                => '%2$s tiene %1$d Hija registrada.' . I18N::PLURAL . '%2$s tiene %1$d Hijas registradas.',
            '%2$s has %1$d son recorded.' . I18N::PLURAL . '%2$s has %1$d sons recorded.'
                => '%2$s tiene %1$d Hijo registrado.' . I18N::PLURAL . '%2$s tiene %1$d Hijos registrados.',
            '%2$s has %1$d son and ' . I18N::PLURAL . '%2$s has %1$d sons and '
                => '%2$s tiene %1$d Hijo y ' . I18N::PLURAL . '%2$s tiene %1$d Hijos y ',
            '%d daughter recorded (%d in total).' . I18N::PLURAL . '%d daughters recorded (%d in total).'
                => '%d Hija registrados (%d en total).' . I18N::PLURAL . '%d Hijas registrados (%d en total).',
            
            'Children-in-law' => 'Hijos políticos',
            '%s has no children-in-law recorded.' => '%s no tienes hijos políticos registrados.',
            '%s has one daughter-in-law recorded.' => '%s tiene una hija política registrada.',
            '%s has one son-in-law recorded.' => '%s tiene un hijo político registrado.',
            '%s has one child-in-law recorded.' => '%s tiene un hijo/a político/a registrado.',
            '%2$s has %1$d daughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d daughters-in-law recorded.'
                => '%2$s tiene %1$d Hija política registrada.' . I18N::PLURAL . '%2$s tiene %1$d Hijas políticas registradas.',
            '%2$s has %1$d son-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sons-in-law recorded.'
                => '%2$s tine %1$d Hijo político registrado.' . I18N::PLURAL . '%2$s tine %1$d Hijos politicos registrados.',
            '%2$s has %1$d son-in-law and ' . I18N::PLURAL . '%2$s has %1$d sons-in-law and '
                => '%2$s tiene %1$d Hijo político y ' . I18N::PLURAL . '%2$s tiene %1$d Hijos políticos y ',
            '%d daughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d daughters-in-law recorded (%d in total).'
                => '%d Hijas políticas registradas (%d en total).' . I18N::PLURAL . '%d Hijas políticas registrados (%d en total).',

            'Grandchildren' => 'Nietos y Nietas', 
            '%s has no grandchildren recorded.' => '%s no tiene Nietos registrados.',
            '%s has one granddaughter recorded.' => '%s tiene una Nieta registrada.',
            '%s has one grandson recorded.' => '%s tiene un Nieto registrado.',
            '%s has one grandchild recorded.' => '%s tiene un Nieto o Nieta registrados.',
            '%2$s has %1$d granddaughter recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters recorded.'
                => '%2$s ist %1$d Nieta registrada.' . I18N::PLURAL . '%2$s tiene %1$d Nietas registradas.',
            '%2$s has %1$d grandson recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons recorded.'
                => '%2$s ist %1$d Nieto registrado.' . I18N::PLURAL . '%2$s tiene %1$d Nietos registrados.',
            '%2$s has %1$d grandson and ' . I18N::PLURAL . '%2$s has %1$d grandsons and '
                => '%2$s tiene %1$d Nieto y ' . I18N::PLURAL . '%2$s tiene %1$d Nietos y ',
            '%d granddaughter recorded (%d in total).' . I18N::PLURAL . '%d granddaughters recorded (%d in total).'
                => '%d Nieta registrados (%d en total).' . I18N::PLURAL . '%d Nietas registrados (%d en total).',
        ];
    }

    /**
     * tbd
     *
     * @return array
     */
    public static function finnishTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
        ];
    }

    /**
     * tbd
     *
     * @return array
     */
    public static function frenchTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
        ];
    }

    /**
     * tbd
     *
     * @return array
     */
    public static function hebrewTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
        ];
    }

    /**
     * @return array
     */
    public static function italianTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
        ];
    }

    /**
     * tbd
     *
     * @return array
     */
    public static function lithuanianTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
        ];
    }

    /**
     * tbd
     *
     * @return array
     */
    public static function norwegianBokmålTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
        ];
    }

    /**
     * @return array
     */
    public static function dutchTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Uitgebreide familie',
            'A tab showing the extended family of an individual.' => 'Tab laat de uitgebreide familie van deze persoon zien.',
            'In which sequence should the parts of the extended family be shown?' => 'In welke volgorde moeten de delen van de uitgebreide familie worden weergegeven?',
            'Family part' => 'Familiedeel',
            'Show name of proband as short name or as full name?' => 'Naam van proband weergeven als korte naam of als volledige naam?',
            'Show options to filter the results (gender and alive/dead)?' => 'Filteropties (geslacht en levend/overleden) weergeven?',
            'Show filter options' => 'Filteropties weergeven',
            'How should empty parts of extended family be presented?' => 'Hoe moeten lege delen van de uitgebreide familie worden weergegeven?',
            'Show empty block' => 'Lege familiedelen weergeven',
            'yes, always at standard location' => 'ja, altijd op de standaardlocatie',
            'no, but collect messages about empty blocks at the end' => 'nee, maar verzamel berichten over lege familiedelen aan het eind',
            'never' => 'nooit',
            'The short name is based on the probands Rufname or nickname. If these are not available, the first of the given names is used, if one is given. Otherwise the last name is used.' => 'De korte naam is gebaseerd op de roepnaam of bijnaam van de proband. Als deze niet beschikbaar zijn, wordt de eerste van de voornamen gebruikt, als er een is opgegeven. Anders wordt de achternaam gebruikt.',
            'Show short name' => 'Korte naam weergeven',
            'Show labels in special situations?' => 'Labels weergeven in bijzondere situaties?',
            'Labels (or stickers) are used for example for adopted persons or foster children.' => 'Labels worden gebruikt voor bijvoorbeeld geadopteerde personen of pleegkinderen.',
            'Show labels' => 'Labels weergeven',
            'Use the compact design?' => 'Compact ontwerp gebruiken?',
            'Use the compact design' => 'Gebruik compact ontwerp',
            'The compact design only shows the name and life span for each person. The enriched design also shows a photo (if this is activated for this tree) as well as birth and death information.' => 'Het compacte ontwerp toont alleen de naam en de levensduur voor elke persoon. Het verrijkte ontwerp toont ook een foto (als dit voor deze boom is geactiveerd), en geboorte- en overlijdensinformatie',
            'Show parameters of extended family part?' => 'Parameters van uitgebreidefamiliedeel weergeven?',
            'Display of additional information for each part of the extended family, such as the generation shift and the coefficient of relationship, which is a measure of the degree of consanguinity.' => 'Weergave van aanvullende informatie voor elk deel van de uitgebreide familie, zoals de generatieverschuiving en de verwantschapscoëfficiënt, die een vermenigvuldigingsfactor is voor de graad van bloedverwantschap.',
            'Show parameters' => 'Parameters weergeven',
            'generation +%s' => 'generatie +%s',
            'same generation' => 'dezelfde generatie',
            'generation %s' => 'generatie %s',
            'relationship coefficient: %.1f' => 'Verwantschapscoëfficiënt: %.1f',
            'no blood relationship' => 'geen bloedverwantschap',

            'don\'t use this filter' => 'gebruik dit filter niet',
            'show only male persons' => 'toon alleen mannen',
            'show only female persons' => 'toon alleen vrouwen',
            'show only persons of unknown gender' => 'toon alleen personen van onbekend geslacht',
            'show only alive persons' => 'toon alleen levende personen',
            'show only dead persons' => 'toon alleen overleden personen',
            'alive' => 'levend',
            'dead' => 'overleden',
            'a dead person' => 'een overleden persoon',
            'a living person' => 'een levend persoon',
            'not a male person' => 'geen mannelijk persoon',
            'not a female person' => 'geen vrouwelijk persoon',
            'not a person of unknown gender' => 'geen persoon van onbekend geslacht',

            'twin' => 'tweeling',
            'triplet' => 'drieling',
            'quadruplet' => 'vierling',
            'quintuplet' => 'vijfling',
            'sextuplet' => 'zesling',
            'septuplet' => 'zevenling',
            'octuplet' => 'achtling',
            'nonuplet' => 'negenling',
            'decuplet' => 'tienling',
            'stillborn' => 'levenloos geboren',
            'died as infant' => 'als baby overleden',
            'linkage challenged' => 'koppeling betwist',
            'linkage disproven' => 'koppeling weerlegd',
            'linkage proven' => 'koppeling bewezen',

            'Marriage' => 'Huwelijk',
            'Ex-marriage' => 'Ex-huwelijk',
            'Partnership' => 'Relatie',
            'Fiancée' => 'Verloving',
            ' with ' => ' met ',
            'Biological parents of father' => 'Biologische ouders van de vader',
            'Biological parents of mother' => 'Biologische ouders van de moeder',
            'Biological parents of parent' => 'Biologische ouders van een ouder',
            'Biological grandparents' => 'Biologische grootouders',
            'Stepparents of father' => 'Stiefouders van de vader',
            'Stepparents of mother' => 'Stiefouders van de moeder',
            'Stepparents of parent' => 'Stiefouders van een ouder',
            'Parents of stepparents' => 'Ouders van stiefouders',
            'Siblings of father' => 'Broers/zussen van de vader',
            'Siblings of mother' => 'Broers/zussen van de moeder',
            'Full siblings of biological parents' => 'Volle broers/zussen van biologische ouders',
            'Siblings-in-law of father' => 'Zwagers/schoonzussen van de vader',
            'Siblings-in-law of mother' => 'Zwagers/schoonzussen van de moeder',
            'Biological parents' => 'Biologische ouders',
            'Stepparents' => 'Stiefouders',
            'Parents-in-law of biological children' => 'Schoonouders van biologische kinderen',
            'Parents-in-law of stepchildren' => 'Schoonouders van stiefkinderen',
            'Full siblings' => 'Volle broers/zussen',
            'Half siblings' => 'Halfbroers/-zussen',
            'Stepsiblings' => 'Stiefbroers/-zussen',
            'Children of full siblings of father' => 'Kinderen van volle broers/zussen van de vader',
            'Children of full siblings of mother' => 'Kinderen van volle broers/zussen van de moeder',
            'Children of full siblings of parent' => 'Kinderen van volle broers/zussen van een ouder',
            'Children of half siblings of father' => 'Kinderen van halfbroers/-zussen van de vader',
            'Children of half siblings of mother' => 'Kinderen van halfbroers/-zussen van de moeder',
            'Children of half siblings of parent' => 'Kinderen van halfbroers/-zussen van een ouder',
            'Siblings of partners' => 'Broers/zussen van partners',
            'Partners of siblings' => 'Partners van broers/zussen',
            'Siblings of siblings-in-law' => 'Broers/zussen van zwagers/schoonzussen',
            'Partners of siblings-in-law' => 'Partners van zwagers/schoonzussen',
            'Children of full siblings of biological parents' => 'Kinderen van volle broers/zussen van biologische ouders',
            'Children of siblings' => 'Kinderen van broers/zussen',
            'Children of full siblings' => 'Kinderen van volle broers/zussen',
            'Siblings\' stepchildren' => 'Stiefkinderen van broers/zussen',
            'Children of siblings of partners' => 'Kinderen van broers/zussen van partners',
            'Biological children' => 'Biologische kinderen',
            'Stepchildren' => 'Stiefkinderen',
            'Stepchild' => 'Stiefkind',
            'Stepson' => 'Stiefzoon',
            'Stepdaughter' => 'Stiefdochter',
            'Partners of biological children' => 'Partners van biologische kinderen',
            'Partners of stepchildren' => 'Partners van stiefkinderen',
            'Biological grandchildren' => 'Biologische kleinkinderen',
            'Stepchildren of children' => 'Stiefkinderen van kinderen',
            'Children of stepchildren' => 'Kinderen van stiefkinderen',
            'Stepchildren of stepchildren' => 'Stiefkinderen van stiefkinderen',

            'He' => 'hem',
            'She' => 'haar',
            'He/she' => 'hem/haar',
            'Mr.' => 'de heer',
            'Mrs.' => 'mevrouw',
            'No family available' => 'Geen familie gevonden',
            'Parts of extended family without recorded information' => 'Onderdelen van uitgebreide familie zonder geregistreerde informatie',
            '%s has no %s recorded.' => 'Voor %s zijn geen %s geregistreerd.',
            '%s has no %s, and no %s recorded.' => 'Voor %s zijn geen %s en geen %s geregistreerd.',
            'Father\'s family (%d)' => 'Familie van de vader (%d)',
            'Mother\'s family (%d)' => 'Familie van de moeder (%d)',
            'Father\'s and Mother\'s family (%d)' => 'Familie van de vader en de moeder (%d)',
            'Parents %1$s of %2$s' => 'Ouders %1$s van %2$s',
            'Parents %1$s (%2$s) of %3$s' => 'Ouders %1$s (%2$s) van %3$s',
            'Partners of %s' => 'Partners van %s',
            'Brother %1$s of partner %2$s' => 'Broer %1$s van partner %2$s',
            'Sister %1$s of partner %2$s' => 'Zus %1$s van partner %2$s',
            'Sibling %1$s of partner %2$s' => 'Broer/zus %1$s van partner %2$s',

            'Grandparents' => 'Grootouders',
            '%s has no grandparents recorded.' => 'Voor %s zijn geen grootouders geregistreerd.', 
            '%s has one grandmother recorded.' => 'Voor %s is een grootmoeder geregistreerd.',
            '%s has one grandfather recorded.' => 'Voor %s is een grootvader geregistreerd.',
            '%s has one grandparent of unknown sex recorded.' => 'Voor %s is een grootouder van onbekend geslacht geregistreerd.',
            '%2$s has %1$d grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d grandmothers recorded.'
                => 'Voor %2$s is %1$d grootmoeder geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d grootmoeders geregistreerd.',
            '%2$s has %1$d grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d grandfathers recorded.'
                => 'Voor %2$s is %1$d grootvader geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d grootvaders geregistreerd.',
            '%2$s has %1$d grandparent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandparents of unknown sex recorded.'
                => 'Voor %2$s is %1$d grootouder van onbekend geslacht geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d grootouders van onbekend geslacht geregistreerd.',
            '%2$s has %1$d grandfather and ' . I18N::PLURAL . '%2$s has %1$d grandfathers and ' 
                => 'Voor %2$s zijn %1$d grootvader en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d grootvaders en ',
            '%d grandmother recorded (%d in total).' . I18N::PLURAL . '%d grandmothers recorded (%d in total).' 
                => '%d grootmoeder geregistreerd (%d in totaal).' . I18N::PLURAL . '%d grootmoeders geregistreerd (%d in totaal).',
            '%2$s has %1$d grandmother and ' . I18N::PLURAL . '%2$s has %1$d grandmothers and '
                => 'Voor %2$s zijn %1$d grootmoeder en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d grootmoeders en ',
            '%d grandparent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandparents of unknown sex recorded (%d in total).'
                => '%d grootouder van onbekend geslacht geregistreerd (%d in totaal).' . I18N::PLURAL . '%d grootouders van onbekend geslacht geregistreerd (%d in totaal).',
            '%2$s has %1$d grandfather, ' . I18N::PLURAL . '%2$s has %1$d grandfathers, '
                => 'Voor %2$s zijn %1$d grootvader, ' . I18N::PLURAL . 'Voor %2$s zijn %1$d grootvaders, ',
            '%d grandmother, and ' . I18N::PLURAL . '%d grandmothers, and '
                => '%d grootmoeder en ' . I18N::PLURAL . '%d grootmoeders en ',

            'Uncles and Aunts' => 'Ooms en tantes',
            '%s has no uncles or aunts recorded.' => 'Voor %s zijn geen ooms/tantes geregistreerd.',
            '%s has one aunt recorded.' => 'Voor %s is een tante geregistreerd.',
            '%s has one uncle recorded.' => 'Voor %s is een oom geregistreerd.',
            '%s has one uncle or aunt of unknown sex recorded.' => 'Voor %s is een oom/tante van onbekend geslacht geregistreerd.',
            '%2$s has %1$d aunt recorded.' . I18N::PLURAL . '%2$s has %1$d aunts recorded.'
                => 'Voor %2$s is %1$d tante geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d tantes geregistreerd.',
            '%2$s has %1$d uncle recorded.' . I18N::PLURAL . '%2$s has %1$d uncles recorded.'
                => 'Voor %2$s is %1$d oom geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d ooms geregistreerd.',
            '%2$s has %1$d uncle or aunt of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d uncles or aunts of unknown sex recorded.'
                => 'Voor %2$s is %1$d oom/tante van onbekend geslacht geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d ooms/tantes van onbekend geslacht geregistreerd.',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and ' 
                => 'Voor %2$s zijn %1$d oom en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d ooms en ',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).' 
                => '%d tante geregistreerd (%d in totaal).' . I18N::PLURAL . '%d tantes geregistreerd (%d in totaal).',
            '%2$s has %1$d aunt and ' . I18N::PLURAL . '%2$s has %1$d aunts and '
                => 'Voor %2$s zijn %1$d tante en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d tantes en ',
            '%d uncle or aunt of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d uncles or aunts of unknown sex recorded (%d in total).'
                => '%d oom/tante van onbekend geslacht geregistreerd (%d in totaal).' . I18N::PLURAL . '%d ooms/tantes van onbekend geslacht geregistreerd (%d in totaal).',
            '%2$s has %1$d uncle, ' . I18N::PLURAL . '%2$s has %1$d uncles, '
                => 'Voor %2$s zijn %1$d oom, ' . I18N::PLURAL . 'Voor %2$s zijn %1$d ooms, ',
            '%d aunt, and ' . I18N::PLURAL . '%d aunts, and '
                => '%d tante en ' . I18N::PLURAL . '%d tantes en ',

            'Uncles and Aunts by marriage' => 'Aangetrouwde ooms en tantes',
            '%s has no uncles or aunts by marriage recorded.' => 'Voor %s zijn geen aangetrouwde ooms/tantes geregistreerd.',
            '%s has one aunt by marriage recorded.' => 'Voor %s is een aangetrouwde tante geregistreerd.',
            '%s has one uncle by marriage recorded.' => 'Voor %s is een aangetrouwde oom geregistreerd.',
            '%s has one uncle or aunt by marriage of unknown sex recorded.' => 'Voor %s is een aangetrouwde oom/tante van onbekend geslacht geregistreerd.',
            '%2$s has %1$d aunt by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d aunts by marriage recorded.'
                => 'Voor %2$s is %1$d aangetrouwde tante geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d aangetrouwde tantes geregistreerd.',
            '%2$s has %1$d uncle by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d uncles by marriage recorded.'
                => 'Voor %2$s is %1$d aangetrouwde oom geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d aangetrouwde ooms geregistreerd.',
            '%2$s has %1$d uncle or aunt by marriage of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d uncles or aunts by marriage of unknown sex recorded.'
                => 'Voor %2$s is %1$d aangetrouwde oom/tante van onbekend geslacht geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d aangetrouwde ooms/tantes van onbekend geslacht geregistreerd.',
            '%2$s has %1$d uncle by marriage and ' . I18N::PLURAL . '%2$s has %1$d uncles by marriage and ' 
                => 'Voor %2$s zijn %1$d aangetrouwde oom en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d aangetrouwde ooms en ',
            '%d aunt by marriage recorded (%d in total).' . I18N::PLURAL . '%d aunts by marriage recorded (%d in total).' 
                => '%d aangetrouwde tante geregistreerd (%d in totaal).' . I18N::PLURAL . '%d aangetrouwde tantes geregistreerd (%d in totaal).',

            'Parents' => 'Ouders',
            '%s has no parents recorded.' => 'Voor %s zijn geen ouders geregistreerd.',
            '%s has one mother recorded.' => 'Voor %s is een moeder geregistreerd.',
            '%s has one father recorded.' => 'Voor %s is een vader geregistreerd.',
            '%s has one parent of unknown sex recorded.' => 'Voor %s is een ouder van onbekend geslacht geregistreerd.',
            '%2$s has %1$d mother recorded.' . I18N::PLURAL . '%2$s has %1$d mothers recorded.'
                => 'Voor %2$s is %1$d moeder geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d moeders geregistreerd.',
            '%2$s has %1$d father recorded.' . I18N::PLURAL . '%2$s has %1$d fathers recorded.'
                => 'Voor %2$s is %1$d vader geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d vaders geregistreerd.',
            '%2$s has %1$d parent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d parents of unknown sex recorded.'
                => 'Voor %2$s is %1$d ouder van onbekend geslacht geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d ouders van onbekend geslacht geregistreerd.',
            '%2$s has %1$d father and ' . I18N::PLURAL . '%2$s has %1$d fathers and ' 
                => 'Voor %2$s zijn %1$d vader en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d vaders en ',
            '%d mother recorded (%d in total).' . I18N::PLURAL . '%d mothers recorded (%d in total).' 
                => '%d moeder geregistreerd (%d in totaal).' . I18N::PLURAL . '%d moeders geregistreerd (%d in totaal).',

            'Parents-in-law' => 'Schoonouders',
            '%s has no parents-in-law recorded.' => 'Voor %s zijn geen schoonouders geregistreerd.',
            '%s has one mother-in-law recorded.' => 'Voor %s is een schoonmoeder geregistreerd.',
            '%s has one father-in-law recorded.' => 'Voor %s is een schoonvader geregistreerd.',
            '%s has one parent-in-law of unknown sex recorded.' => 'Voor %s is een schoonouder van onbekend geslacht geregistreerd.',
            '%2$s has %1$d mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d mothers-in-law recorded.'
                => 'Voor %2$s is %1$d schoonmoeder geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoonmoeders geregistreerd.',
            '%2$s has %1$d father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d fathers-in-law recorded.'
                => 'Voor %2$s is %1$d schoonvader geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoonvaders geregistreerd.',
            '%2$s has %1$d parent-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d parents-in-law of unknown sex recorded.'
                => 'Voor %2$s is %1$d schoonouder van onbekend geslacht geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoonouders van onbekend geslacht geregistreerd.',
            '%2$s has %1$d father-in-law and ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law and '
                => 'Voor %2$s zijn %1$d schoonvader en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoonvaders en ',
            '%d mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d mothers-in-law recorded (%d in total).'
                => '%d schoonmoeder geregistreerd (%d in totaal).' . I18N::PLURAL . '%d schoonmoeder geregistreerd (%d in totaal).',

            'Co-parents-in-law' => 'Ouders van schoonkinderen',
            '%s has no co-parents-in-law recorded.' => 'Voor %s zijn geen ouders van schoonkinderen geregistreerd.',
            '%s has one co-mother-in-law recorded.' => 'Voor %s is een moeder van een schoonkind geregistreerd.',
            '%s has one co-father-in-law recorded.' => 'Voor %s is een vader van een schoonkind geregistreerd.',
            '%s has one co-parent-in-law of unknown sex recorded.' => 'Voor %s is een ouder (van onbekend geslacht) van een schoonkind geregistreerd.',
            '%2$s has %1$d co-mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law recorded.'
                => 'Voor %2$s is %1$d moeder van een schoonkind geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d moeders van schoonkinderen geregistreerd.',
            '%2$s has %1$d co-father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law recorded.'
                => 'Voor %2$s is %1$d vader van een schoonkind geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d vaders van schoonkinderen geregistreerd.',
            '%2$s has %1$d co-parent-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d co-parents-in-law of unknown sex recorded.'
                => 'Voor %2$s is %1$d ouder (van onbekend geslacht) van een schoonkind geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d ouders (van onbekend geslacht) van een schoonkind geregistreerd.',
            '%2$s has %1$d co-father-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law and ' 
                => 'Voor %2$s zijn %1$d vader en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d vaders en ',
            '%d co-mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-mothers-in-law recorded (%d in total).' 
                => '%d moeder van schoonkinderen geregistreerd (%d in totaal).' . I18N::PLURAL . '%d moeders van schoonkinderen geregistreerd (%d in totaal).',

            'Partners' => 'Partners',
            'Partner of ' => 'Partner van ',
            '%s has no partners recorded.' => 'Voor %s zijn geen partners geregistreerd.',
            '%s has one female partner recorded.' => 'Voor %s is een vrouwelijke partner geregistreerd.',
            '%s has one male partner recorded.' => 'Voor %s is een mannelijke partner geregistreerd.',
            '%s has one partner of unknown sex recorded.' => 'Voor %s is een partner van onbekend geslacht geregistreerd.',
            '%2$s has %1$d female partner recorded.' . I18N::PLURAL . '%2$s has %1$d female partners recorded.'
                => 'Voor %2$s is %1$d vrouwelijke partner geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d vrouwelijke partners geregistreerd.',
            '%2$s has %1$d male partner recorded.' . I18N::PLURAL . '%2$s has %1$d male partners recorded.'
                => 'Voor %2$s is %1$d mannelijke partner geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d mannelijke partners geregistreerd.',
            '%2$s has %1$d partner of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d partners of unknown sex recorded.'
                => 'Voor %2$s is %1$d partner van onbekend geslacht geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d partners van onbekend geslacht geregistreerd.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and ' 
                => 'Voor %2$s zijn %1$d mannelijke en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d mannelijke en ',
            '%2$s has %1$d female partner and ' . I18N::PLURAL . '%2$s has %1$d female partners and ' 
                => 'Voor %2$s zijn %1$d vrouwelijke partner en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d vrouwelijke partners en ',
            '%d female partner recorded (%d in total).' . I18N::PLURAL . '%d female partners recorded (%d in total).' 
                => '%d vrouwelijke partner geregistreerd (%d in totaal).' . I18N::PLURAL . '%d vrouwelijke partners geregistreerd (%d in totaal).',
            '%2$s has %1$d partner and ' . I18N::PLURAL . '%2$s has %1$d partners and ' 
                => 'Voor %2$s zijn %1$d partner en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d partners en ',
            '%d male partner of female partners recorded (%d in total).' . I18N::PLURAL . '%d male partners of female partners recorded (%d in total).'
                => '%d mannelijke partner van vrouwelijke partners geregistreerd (%d in totaal).' . I18N::PLURAL . '%d mannelijke partners van vrouwelijke partners geregistreerd (%d in totaal).',
            '%d female partner of male partners recorded (%d in total).' . I18N::PLURAL . '%d female partners of male partners recorded (%d in total).'
                => '%d vrouwelijke partner van mannelijke partners geregistreerd (%d in totaal).' . I18N::PLURAL . '%d vrouwelijke partners van mannelijke partners geregistreerd (%d in totaal).',

            'Partner chains' => 'Partnerketens',
            '%s has no members of a partner chain recorded.' => 'Voor %s zijn geen leden van een partnerketen geregistreerd.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and '
                => 'Voor %2$s zijn %1$d mannelijke partner en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d mannelijke partners en ',
            '%d female partner in this partner chain recorded (%d in total).' . I18N::PLURAL . '%d female partners in this partner chain recorded (%d in total).'
                =>'%d vrouwelijke partner in deze partnerketen geregistreerd (%d in totaal).' . I18N::PLURAL . '%d vrouwelijke partners in deze partnerketen geregistreerd (%d in totaal).',
            '%d female partner and ' . I18N::PLURAL . '%d female partners and '
                => '%d vrouwelijke partner en ' . I18N::PLURAL . '%d vrouwelijke partners en ',
            '%d partner of unknown sex in this partner chain recorded (%d in total).' . I18N::PLURAL . '%d partners of unknown sex in this partner chain recorded (%d in total).'
                => '%d partner van onbekend geslacht in deze partnerketen geregistreerd (%d in totaal).' . I18N::PLURAL . '%d partners van onbekend geslacht in deze partnerketen geregistreerd (%d in totaal).',
            'There are %d branches in the partner chain. ' => 'Er zijn %d takken in de partnerketen.',
            'The longest branch in the partner chain to %2$s consists of %1$d partners (including %3$s).' => 'De langste tak in de partnerketen naar %2$s bestaat uit %1$d partners (inclusief %3$s).',
            'The longest branch in the partner chain consists of %1$d partners (including %2$s).' => 'De langste tak in de partnerketen bestaat uit %1$d partners (inclusief %2$s).',

            'Siblings' => 'Broers en zussen',
            '%s has no siblings recorded.' => 'Voor %s zijn geen broers/zussen geregistreerd.',
            '%s has one sister recorded.' => 'Voor %s is een zus geregistreerd.',
            '%s has one brother recorded.' => 'Voor %s is een broer geregistreerd.',
            '%s has one sibling of unknown sex recorded.' => 'Voor %s is een broer/zus van onbekend geslacht geregistreerd.',
            '%2$s has %1$d sister recorded.' . I18N::PLURAL . '%2$s has %1$d sisters recorded.'
                => 'Voor %2$s is %1$d zus geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d zussen geregistreerd.',
            '%2$s has %1$d brother recorded.' . I18N::PLURAL . '%2$s has %1$d brothers recorded.'
                => 'Voor %2$s is %1$d broer geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d broers geregistreerd.',
            '%2$s has %1$d sibling of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d siblings of unknown sex recorded.'
                => 'Voor %2$s is %1$d een broer/zus van onbekend geslacht geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d een broers/zussen van onbekend geslacht geregistreerd.',
            '%2$s has %1$d brother and ' . I18N::PLURAL . '%2$s has %1$d brothers and ' 
                => 'Voor %2$s zijn %1$d broer en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d broers en ',
            '%d sister recorded (%d in total).' . I18N::PLURAL . '%d sisters recorded (%d in total).' 
                => '%d zus geregistreerd (%d in totaal).' . I18N::PLURAL . '%d zussen geregistreerd (%d in totaal).',
            '%2$s has %1$d sister and ' . I18N::PLURAL . '%2$s has %1$d sisters and '
                => 'Voor %2$s zijn %1$d zus en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d zussen en ',
            '%d sibling of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d siblings of unknown sex recorded (%d in total).'
                => '%d broer/zus van onbekend geslacht geregistreerd (%d in totaal).' . I18N::PLURAL . '%d broers/zussen van onbekend geslacht geregistreerd (%d in totaal).',
            '%2$s has %1$d brother, ' . I18N::PLURAL . '%2$s has %1$d brothers, '
                => 'Voor %2$s zijn %1$d broer, ' . I18N::PLURAL . 'Voor %2$s zijn %1$d broers, ',
            '%d sister, and ' . I18N::PLURAL . '%d sisters, and '
                => '%d zus en ' . I18N::PLURAL . '%d zussen en ',

            'Siblings-in-law' => 'Zwagers en schoonzussen',
            '%s has no siblings-in-law recorded.' => 'Voor %s zijn geen zwagers/schoonzussen geregistreerd.',
            '%s has one sister-in-law recorded.' => 'Voor %s is een schoonzus geregistreerd.',
            '%s has one brother-in-law recorded.' => 'Voor %s is een zwager geregistreerd.',
            '%s has one sibling-in-law of unknown sex recorded.' => 'Voor %s is een zwager/schoonzus van onbekend geslacht geregistreerd.',
            '%2$s has %1$d sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sisters-in-law recorded.'
                => 'Voor %2$s is %1$d schoonzus geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoonzussen geregistreerd.',
            '%2$s has %1$d brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d brothers-in-law recorded.'
                => 'Voor %2$s is %1$d zwager geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d zwagers geregistreerd.',
            '%2$s has %1$d sibling-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d siblings-in-law of unknown sex recorded.'
                => 'Voor %2$s is %1$d zwager/schoonzus van onbekend geslacht geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d zwagers/schoonzussen van onbekend geslacht geregistreerd.',
            '%2$s has %1$d brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law and ' 
                => 'Voor %2$s zijn %1$d zwager en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d zwagers en ',
            '%d sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d sisters-in-law recorded (%d in total).' 
                => '%d schoonzus geregistreerd (%d in totaal).' . I18N::PLURAL . '%d schoonzussen geregistreerd (%d in totaal).',
            '%2$s has %1$d sister-in-law and ' . I18N::PLURAL . '%2$s has %1$d sisters-in-law and '
                => 'Voor %2$s zijn %1$d schoonzus en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoonzussen en ',
            '%d sibling-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d siblings-in-law of unknown sex recorded (%d in total).'
                => '%d zwager/schoonzus van onbekend geslacht geregistreerd (%d in totaal).' . I18N::PLURAL . '%d zwagers/schoonzuszen van onbekend geslacht geregistreerd (%d in totaal).',
            '%2$s has %1$d brother-in-law, ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law, '
                => 'Voor %2$s zijn %1$d zwager, ' . I18N::PLURAL . 'Voor %2$s zijn %1$d zwagers, ',
            '%d sister-in-law, and ' . I18N::PLURAL . '%d sisters-in-law, and '
                => '%d schoonzus en ' . I18N::PLURAL . '%d schoonzussen en ',

            'Co-siblings-in-law' => 'Broers/zussen/partners van zwagers of schoonzussen',
            '%s has no co-siblings-in-law recorded.' => 'Voor %s zijn geen broers/zussen/partners van zwagers/schoonzussen geregistreerd.',
            '%s has one co-sister-in-law recorded.' => 'Voor %s is een zus/vrouwelijke partner van een zwager/schoonzus geregistreerd.',
            '%s has one co-brother-in-law recorded.' => 'Voor %s is een broer/mannelijke partner van een zwager/schoonzus geregistreerd.',
            '%s has one co-sibling-in-law of unknown sex recorded.' => 'Voor %s is een broer/zus/partner (van onbekend geslacht) van een zwager/schoonzus geregistreerd.',
            '%2$s has %1$d co-sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-sisters-in-law recorded.'
                => 'Voor %2$s is %1$d zus/vrouwelijke partner van een zwager/schoonzus geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d zussen/vrouwelijke partners van zwagers/schoonzussen geregistreerd.',
            '%2$s has %1$d co-brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law recorded.'
                => 'Voor %2$s is %1$d broer/mannelijke partner van een zwager/schoonzus geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d broers/mannelijke partners van zwagers/schoonzussen geregistreerd.',
            '%2$s has %1$d co-sibling-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d co-siblings-in-law of unknown sex recorded.'
                => 'Voor %2$s is %1$d broer/zus/partner (van onbekend geslacht) van een zwager/schoonzus geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d broers/zussen/partners (van onbekend geslacht) van een zwager/schoonzus geregistreerd.',
            '%2$s has %1$d co-brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law and ' 
                => 'Voor %2$s zijn %1$d broer/mannelijke partner en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d broers/mannelijke partners en ',
            '%d co-sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-sisters-in-law recorded (%d in total).' 
                => '%d zus/vrouwelijke partner van een zwager/schoonzus geregistreerd (%d in totaal).' . I18N::PLURAL . '%d zussen/vrouwelijke partners van zwagers/schoonzussen geregistreerd (%d in totaal).',
            '%2$s has %1$d co-sister-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-sisters-in-law and '
                => 'Voor %2$s zijn %1$d zus/vrouwelijke partner van een zwager/schoonzus en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d zussen/vrouwelijke partners van een zwager/schoonzus en ',
            '%d co-sibling-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d co-siblings-in-law of unknown sex recorded (%d in total).'
                => '%d broer/zus/partner (van onbekend geslacht) van een zwager/schoonzus geregistreerd (%d in totaal).' . I18N::PLURAL . '%d broers/zussen/partners (van onbekend geslacht) van een zwager/schoonzus geregistreerd (%d in totaal).',
            '%2$s has %1$d co-brother-in-law, ' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law, '
                => 'Voor %2$s zijn %1$d broer/mannelijke partner van een zwager/schoonzus, ' . I18N::PLURAL . 'Voor %2$s zijn %1$d broers/mannelijke partners van een zwager/schoonzus, ',
            '%d co-sister-in-law, and ' . I18N::PLURAL . '%d co-sisters-in-law, and '
                => '%d zus/vrouwelijke partner van een zwager/schoonzus en ' . I18N::PLURAL . '%d zussen/vrouwelijke partners van een zwager/schoonzus en ',

            'Cousins' => 'Volle neven en nichten (kinderen van oom of tante)',
            '%s has no first cousins recorded.' => 'Voor %s zijn geen volle neven/nichten geregistreerd.',
            '%s has one female first cousin recorded.' => 'Voor %s is een volle nicht geregistreerd.',
            '%s has one male first cousin recorded.' => 'Voor %s is een volle neef geregistreerd.',
            '%s has one first cousin of unknown sex recorded.' => 'Voor %s is een volle neef/nicht van onbekend geslacht geregistreerd.',
            '%2$s has %1$d female first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d female first cousins recorded.'
                => 'Voor %2$s is %1$d volle nicht geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d volle nichten geregistreerd.',
            '%2$s has %1$d male first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d male first cousins recorded.'
                => 'Voor %2$s is %1$d volle neef geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d volle neven geregistreerd.',
            '%2$s has %1$d first cousin of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d first cousins of unknown sex recorded.'
                => 'Voor %2$s is %1$d volle neef/nicht van onbekend geslacht geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d volle neven/nichten van onbekend geslacht geregistreerd.',
            '%2$s has %1$d male first cousin and ' . I18N::PLURAL . '%2$s has %1$d male first cousins and ' 
                => 'Voor %2$s zijn %1$d volle neef en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d volle neven en ',
            '%d female first cousin recorded (%d in total).' . I18N::PLURAL . '%d female first cousins recorded (%d in total).' 
                => '%d volle nicht geregistreerd (%d in totaal).' . I18N::PLURAL . '%d volle nichten geregistreerd (%d in totaal).',
            '%2$s has %1$d female first cousin and ' . I18N::PLURAL . '%2$s has %1$d female first cousins and '
                => 'Voor %2$s zijn %1$d volle nicht en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d volle nichten en ',
            '%d first cousin of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d first cousins of unknown sex recorded (%d in total).'
                => '%d volle neef/nicht van onbekend geslacht geregistreerd (%d in totaal).' . I18N::PLURAL . '%d volle neven/nichten van onbekend geslacht geregistreerd (%d in totaal).',
            '%2$s has %1$d male first cousin, ' . I18N::PLURAL . '%2$s has %1$d male first cousins, '
                => 'Voor %2$s zijn %1$d volle neef, ' . I18N::PLURAL . 'Voor %2$s zijn %1$d volle neven, ',
            '%d female first cousin, and ' . I18N::PLURAL . '%d female first cousins, and '
                => '%d volle nicht en ' . I18N::PLURAL . '%d volle nichten en ',

            'Nephews and Nieces' => 'Neefjes en nichtjes (kinderen van broer of zus)',
            '%s has no nephews or nieces recorded.' => 'Voor %s zijn geen neefjes/nichtjes (kinderen van broer/zus) geregistreerd.',
            '%s has one niece recorded.' => 'Voor %s is een nichtje geregistreerd.',
            '%s has one nephew recorded.' => 'Voor %s is een neefje geregistreerd.',
            '%s has one nephew or niece of unknown sex recorded.' => 'Voor %s is een neefje/nichtje van onbekend geslacht geregistreerd.',
            '%2$s has %1$d niece recorded.' . I18N::PLURAL . '%2$s has %1$d nieces recorded.'
                => 'Voor %2$s is %1$d nichtje geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d nichtjes geregistreerd.',
            '%2$s has %1$d nephew recorded.' . I18N::PLURAL . '%2$s has %1$d nephews recorded.'
                => 'Voor %2$s is %1$d neefje geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d neefjes geregistreerd.',
            '%2$s has %1$d nephew or niece of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d nephews or nieces of unknown sex recorded.'
            => 'Voor %2$s is %1$d neefje/nichtje van onbekend geslacht geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d neefjes/nichtje van onbekend geslacht geregistreerd.',
            '%2$s has %1$d nephew and ' . I18N::PLURAL . '%2$s has %1$d nephews and ' 
                => 'Voor %2$s zijn %1$d neefje en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d neefjes en ',
            '%d niece recorded (%d in total).' . I18N::PLURAL . '%d nieces recorded (%d in total).' 
                => '%d nichtje geregistreerd (%d in totaal).' . I18N::PLURAL . '%d nichtjes geregistreerd (%d in totaal).', 
            '%2$s has %1$d niece and ' . I18N::PLURAL . '%2$s has %1$d nieces and '
                => 'Voor %2$s zijn %1$d nichtje en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d nichtjes en ',
            '%d nephew or niece of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d nephews or nieces of unknown sex recorded (%d in total).'
                => '%d neefje/nichtje van onbekend geslacht geregistreerd (%d in totaal).' . I18N::PLURAL . '%d neefjes/nichtjes van onbekend geslacht geregistreerd (%d in totaal).',
            '%2$s has %1$d nephew, ' . I18N::PLURAL . '%2$s has %1$d nephews, '
                => 'Voor %2$s zijn %1$d neefje, ' . I18N::PLURAL . 'Voor %2$s zijn %1$d neefjes, ',
            '%d niece, and ' . I18N::PLURAL . '%d nieces, and '
                => '%d nichtje en ' . I18N::PLURAL . '%d nichtjes en ',

            'Children' => 'Kinderen',
            '%s has no children recorded.' => 'Voor %s zijn geen kinderen geregistreerd.',
            '%s has one daughter recorded.' => 'Voor %s is een dochter geregistreerd.',
            '%s has one son recorded.' => 'Voor %s is een zoon geregistreerd.',
            '%s has one child of unknown sex recorded.' => 'Voor %s is een kind van onbekend geslacht geregistreerd.',
            '%2$s has %1$d daughter recorded.' . I18N::PLURAL . '%2$s has %1$d daughters recorded.'
                => 'Voor %2$s is %1$d dochter geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d dochters geregistreerd.',
            '%2$s has %1$d son recorded.' . I18N::PLURAL . '%2$s has %1$d sons recorded.'
                => 'Voor %2$s is %1$d zoon geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d zonen geregistreerd.',
            '%2$s has %1$d child of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d children of unknown sex recorded.'
            => 'Voor %2$s is %1$d kind van onbekend geslacht geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d kinderen van onbekend geslacht geregistreerd.',
            '%2$s has %1$d son and ' . I18N::PLURAL . '%2$s has %1$d sons and ' 
                => 'Voor %2$s zijn %1$d zoon en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d zonen en ',
            '%d daughter recorded (%d in total).' . I18N::PLURAL . '%d daughters recorded (%d in total).' 
                => '%d dochter geregistreerd (%d in totaal).' . I18N::PLURAL . '%d dochters geregistreerd (%d in totaal).', 
            '%2$s has %1$d daughter and ' . I18N::PLURAL . '%2$s has %1$d daughters and '
                => 'Voor %2$s zijn %1$d dochter en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d dochters en ',
            '%d child of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d children of unknown sex recorded (%d in total).'
                => '%d kind van onbekend geslacht geregistreerd (%d in totaal).' . I18N::PLURAL . '%d kinderen van onbekend geslacht geregistreerd (%d in totaal).',
            '%2$s has %1$d son, ' . I18N::PLURAL . '%2$s has %1$d sons, '
                => 'Voor %2$s zijn %1$d zoon, ' . I18N::PLURAL . 'Voor %2$s zijn %1$d zonen, ',
            '%d daughter, and ' . I18N::PLURAL . '%d daughters, and '
                => '%d dochter en ' . I18N::PLURAL . '%d dochters en ',

            'Children-in-law' => 'Schoonkinderen',
            '%s has no children-in-law recorded.' => 'Voor %s zijn geen schoonkinderen geregistreerd.',
            '%s has one daughter-in-law recorded.' => 'Voor %s is een schoondochter geregistreerd.',
            '%s has one son-in-law recorded.' => 'Voor %s is een schoonzoon geregistreerd.',
            '%s has one child-in-law of unknown sex recorded.' => 'Voor %s is een schoonkind van onbekend geslacht geregistreerd.',
            '%2$s has %1$d daughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d daughters-in-law recorded.'
                => 'Voor %2$s is %1$d schoondochter geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoondochters geregistreerd.',
            '%2$s has %1$d son-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sons-in-law recorded.'
                => 'Voor %2$s is %1$d schoonzoon geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoonzonen geregistreerd.',
            '%2$s has %1$d child-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d children-in-law recorded.'
            => 'Voor %2$s is %1$d schoonkind van onbekend geslacht geregistreerd.' . I18N::PLURAL . 'Voor %2$s is %1$d schoonkinderen van onbekend geslacht geregistreerd.',
            '%2$s has %1$d son-in-law and ' . I18N::PLURAL . '%2$s has %1$d sons-in-law and ' 
                => 'Voor %2$s zijn %1$d schoonzoon en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoonzonen en ',
            '%d daughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d daughters-in-law recorded (%d in total).' 
                => '%d schoondochter geregistreerd (%d in totaal).' . I18N::PLURAL . '%d schoondochters geregistreerd (%d in totaal).', 
            '%2$s has %1$d daughter-in-law and ' . I18N::PLURAL . '%2$s has %1$d daughters-in-law and '
                => 'Voor %2$s zijn %1$d schoondochter en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoondochters en ',
            '%d child-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d children-in-law of unknown sex recorded (%d in total).'
                => '%d schoonkind van onbekend geslacht geregistreerd (%d in totaal).' . I18N::PLURAL . '%d schoonkinderen van onbekend geslacht geregistreerd (%d in totaal).',
            '%2$s has %1$d son-in-law, ' . I18N::PLURAL . '%2$s has %1$d sons-in-law, '
                => 'Voor %2$s zijn %1$d schoonzoon, ' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoonzonen, ',
            '%d daughter-in-law, and ' . I18N::PLURAL . '%d daughters-in-law, and '
                => '%d schoondochter en ' . I18N::PLURAL . '%d schoondochters en ',

            'Grandchildren' => 'Kleinkinderen',
            '%s has no grandchildren recorded.' => 'Voor %s zijn geen kleinkinderen geregistreerd.',
            '%s has one granddaughter recorded.' => 'Voor %s is een kleindochter geregistreerd.',
            '%s has one grandson recorded.' => 'Voor %s is een kleinzoon geregistreerd.',
            '%s has one grandchild of unknown sex recorded.' => 'Voor %s is een kleinkind van onbekend geslacht geregistreerd.',
            '%2$s has %1$d granddaughter recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters recorded.'
                => 'Voor %2$s is %1$d kleindochter geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d kleindochters geregistreerd.',
            '%2$s has %1$d grandson recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons recorded.'
                => 'Voor %2$s is %1$d kleinzoon geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d kleinzonen geregistreerd.',
            '%2$s has %1$d grandchild of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandchildren of unknown sex recorded.'
            => 'Voor %2$s is %1$d kleinkind van onbekend geslacht geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d kleinkinderen van onbekend geslacht geregistreerd.',
            '%2$s has %1$d grandson and ' . I18N::PLURAL . '%2$s has %1$d grandsons and ' 
                => 'Voor %2$s zijn %1$d kleinzoon en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d kleinzonen en ',
            '%d granddaughter recorded (%d in total).' . I18N::PLURAL . '%d granddaughters recorded (%d in total).' 
                => '%d kleindochter geregistreerd (%d in totaal).' . I18N::PLURAL . '%d kleindochters geregistreerd (%d in totaal).',
            '%2$s has %1$d granddaughter and ' . I18N::PLURAL . '%2$s has %1$d granddaughters and '
                => 'Voor %2$s zijn %1$d kleindochter en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d kleindochters en ',
            '%d grandchild of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandchildren of unknown sex recorded (%d in total).'
                => '%d kleinkind van onbekend geslacht geregistreerd (%d in totaal).' . I18N::PLURAL . '%d kleinkinderen van onbekend geslacht geregistreerd (%d in totaal).',
            '%2$s has %1$d grandson, ' . I18N::PLURAL . '%2$s has %1$d grandsons, '
                => 'Voor %2$s zijn %1$d kleinzoon, ' . I18N::PLURAL . 'Voor %2$s zijn %1$d kleinzonen, ',
            '%d granddaughter, and ' . I18N::PLURAL . '%d granddaughters, and '
                => '%d kleindochter en ' . I18N::PLURAL . '%d kleindochters en ',
        ];
    }

    /**
     * tbd
     *
     * @return array
     */
    public static function norwegianNynorskTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
        ];
    }

    /**
     * @return array
     */
    public static function slovakTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Širšia rodina',
            'A tab showing the extended family of an individual.' => 'Záložka širšej rodiny danej osoby.',
            'Are these parts of the extended family to be shown?' => 'Vyberte príslušníkov širšej rodiny, ktorí sa majú zobraziť.',
            'Show name of proband as short name or as full name?' => 'Má sa zobraziť skrátené, alebo plné meno probanda?',
            'The short name is based on the probands Rufname or nickname. If these are not avaialble, the first of the given names is used, if one is given. Otherwise the last name is used.' => 'Skrátené meno je buď tzv. Rufname, alebo prezývka. Ak tieto neexistujú, tak sa použije prvé krstné meno. Ak ani toto neexistuje, tak sa použije priezvisko.',
            'Show short name' => 'Zobraziť skrátené meno',
            'How should empty parts of extended family be presented?' => 'Ako sa majú zobraziť prázdne bloky?',
            'Show empty block' => 'Zobraziť prázdne bloky',
            'yes, always at standard location' => 'áno, vždy na bežnom mieste',
            'no, but collect messages about empty blocks at the end' => 'nie, zobraz správy o prázdnych blokoch na konci',
            'never' => 'nikdy',
            
            'He' => 'On',
            'She' => 'Ona',
            'He/she' => 'On/ona',
            'Mr.' => 'Pán',
            'Mrs.' => 'Pani',
            'No family available' => 'Nenašla sa žiadna rodina',
            'Parts of extended family without recorded information' => 'Časti širšej rodiny bez zaznamenaných informácií',
            '%s has no %s recorded.' => '%s nemá zaznamenané %s.',
            '%s has no %s, and no %s recorded.' => '%s nemá zaznamenané %s ani %s.',
            'Father\'s family (%d)' => 'Otcova rodina (%d)',
            'Mother\'s family (%d)' => 'Matkina rodina (%d)',
            'Father\'s and Mother\'s family (%d)' => 'Otcova a matkina rodina (%d)',

            'Grandparents' => 'Starí rodičia',
            '%s has no grandparents recorded.' => '%s nemá zaznamenaných žiadnych starých rodičov.',
            '%s has one grandmother recorded.' => '%s má zaznamenanú jednu starú mamu.',
            '%s has one grandfather recorded.' => '%s má zaznamenaného jedného starého otca.',
            '%s has one grandparent recorded.' => '%s má zaznamenaného jedného starého rodiča.',
            '%2$s has %1$d grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d grandmothers recorded.' => '%2$s má zaznamenanú %1$d starú mamu.' . I18N::PLURAL . '%2$s má zaznamenané %1$d staré mamy.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d starých mám.',
            '%2$s has %1$d grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d grandfathers recorded.' 
                => '%2$s má zaznamenaného %1$d starého otca.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d starých otcov.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d starých otcov.',
            '%2$s has %1$d grandfather and ' . I18N::PLURAL . '%2$s has %1$d grandfathers and ' 
                => '%2$s má zaznamenaného %1$d starého otca a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d starých otcov a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d starých otcov a ',
            '%d grandmother recorded (%d in total).' . I18N::PLURAL . '%d grandmothers recorded (%d in total).' 
                => '%d starú mamu (spolu %d).' . I18N::PLURAL . '%d staré mamy (spolu %d).' . I18N::PLURAL . '%d starých mám (spolu %d).',

            '%s has no parents recorded.' => '%s nemá zaznamenaných žiadnych rodičov.',
            '%s has one mother recorded.' => '%s má zaznamenanú jednu matku.',
            '%s has one father recorded.' => '%s má zaznamenaného jedného otca.',
            '%s has one parent recorded.' => '%s má jedného rodiča.',
            '%2$s has %1$d mother recorded.' . I18N::PLURAL . '%2$s has %1$d mothers recorded.' => '%2$s má zaznamenanú %1$d matku.' . I18N::PLURAL . '%2$s má zaznamenané %1$d matky.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d matiek.',
            '%2$s has %1$d father recorded.' . I18N::PLURAL . '%2$s has %1$d fathers recorded.' 
                => '%2$s má zaznamenaného %1$d otca.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d otcov.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d otcov.',
            '%2$s has %1$d father and ' . I18N::PLURAL . '%2$s has %1$d fathers and ' 
                => '%2$s má zaznamenaného %1$d otca a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d otcov a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d otcov a ',
            '%d mother recorded (%d in total).' . I18N::PLURAL . '%d mothers recorded (%d in total).' 
                => '%d matku (spolu %d).' . I18N::PLURAL . '%d matky (spolu %d).' . I18N::PLURAL . '%d matiek (spolu %d).',

            'Uncles and Aunts' => 'Strýkovia a tety',
            '%s has no uncles or aunts recorded.' => '%s nemá zaznamenaného žiadneho strýka alebo tetu.',
            '%s has one aunt recorded.' => '%s má zaznamenanú jednu tetu.',
            '%s has one uncle recorded.' => '%s má zaznamenaného jedného strýka.',
            '%s has one uncle or aunt recorded.' => '%s jedného strýka alebo tetu.',
            '%2$s has %1$d aunt recorded.' . I18N::PLURAL . '%2$s has %1$d aunts recorded.' => '%2$s má zaznamenanú %1$d tetu.' . I18N::PLURAL . '%2$s má zaznamenané %1$d tety.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d tiet.',
            '%2$s has %1$d uncle recorded.' . I18N::PLURAL . '%2$s has %1$d uncles recorded.' 
                => '%2$s má zaznamenaného %1$d strýka.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d strýkov.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d strýkov.',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and ' 
                => '%2$s má zaznamenaného %1$d strýka a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d strýkov a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d strýkov a ',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).' 
                => '%d tetu (spolu %d).' . I18N::PLURAL . '%d tety (spolu %d).' . I18N::PLURAL . '%d tiet (spolu %d).', 

            '%s has no siblings recorded.' => '%s nemá zaznamenaných žiadnych súrodencov.',
            '%s has one sister recorded.' => '%s má zaznamenanú jednu sestru.',
            '%s has one brother recorded.' => '%s má zaznamenaného jedného brata.',
            '%s has one brother or sister recorded.' => '%s má jedného súrodenca.',
            '%2$s has %1$d sister recorded.' . I18N::PLURAL . '%2$s has %1$d sisters recorded.' 
                => '%2$s má zaznamenanú %1$d dcéru.' . I18N::PLURAL . '%2$s má zaznamenané %1$d dcéry.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d dcér.',
            '%2$s has %1$d brother recorded.' . I18N::PLURAL . '%2$s has %1$d brothers recorded.' 
                => '%2$s má zaznamenaného %1$d brata.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d bratov.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d bratov.',
            '%2$s has %1$d brother and ' . I18N::PLURAL . '%2$s has %1$d brothers and ' 
                => '%2$s má zaznamenaného %1$d brata a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d bratov a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d bratov a ',
            '%d sister recorded (%d in total).' . I18N::PLURAL . '%d sisters recorded (%d in total).' 
                => '%d sestru (spolu %d).' . I18N::PLURAL . '%d sestry (spolu %d).' . I18N::PLURAL . '%d sestier (spolu %d).',

            'Partners' => 'Partneri',
            '%s has no partners recorded.' => '%s nemá zaznamenaného žiadneho partnera.',
            '%s has one female partner recorded.' => '%s má zaznamenanú jednu partnerku.',
            '%s has one male partner recorded.' => '%s má zaznamenaného jedného partnera.',
            '%s has one partner recorded.' => '%s má zaznamenaného jedného partnera.',
            '%2$s has %1$d female partner recorded.' . I18N::PLURAL . '%2$s has %1$d female partners recorded.' 
                => '%2$s má zaznamenanú %1$d partnerku.' . I18N::PLURAL . '%2$s má zaznamenané %1$d partnerky.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d partneriek.',
            '%2$s has %1$d male partner recorded.' . I18N::PLURAL . '%2$s has %1$d male partners recorded.' 
                => '%2$s má zaznamenaného %1$d partnera.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d partnerov.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d partnerov.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and ' 
                => '%2$s má zaznamenaného %1$d partnera a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d partnerov a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d partnerov a ',
            '%d female partner recorded (%d in total).' . I18N::PLURAL . '%d female partners recorded (%d in total).' 
                => '%d partnerku (spolu %d).' . I18N::PLURAL . '%d partnerky (spolu %d).' . I18N::PLURAL . '%d partneriek (spolu %d).',

            'Cousins' => 'Bratranci a sesternice',
            '%s has no first cousins recorded.' => '%s nemá zaznamenaných žiadnych prvostupňových bratrancov alebo sesternice.',
            '%s has one female first cousin recorded.' => '%s má zaznamenanú jednu prvostupňovú sesternicu.',
            '%s has one male first cousin recorded.' => '%s má zaznamenaného jedného prvostupňového bratranca.',
            '%s has one first cousin recorded.' => '%s má jedného prvostupňového bratranca alebo sesternicu.',
            '%2$s has %1$d female first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d female first cousins recorded.'
                => '%2$s má zaznamenanú %1$d prvostupňovú sesternicu.' . I18N::PLURAL . '%2$s má zaznamenané %1$d prvostupňové sesternice.' . I18N::PLURAL . '%2$s má zaznamenané %1$d prvostupňových sesterníc.',
            '%2$s has %1$d male first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d male first cousins recorded.' 
                => '%2$s má zaznamenaného %1$d prvostupňového bratranca.' . I18N::PLURAL . '%2$s má zaznamenaného %1$d prvostupňových bratrancov.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d prvostupňových bratrancov.',
            '%2$s has %1$d male first cousin and ' . I18N::PLURAL . '%2$s has %1$d male first cousins and ' 
                => '%2$s má zaznamenaného %1$d prvostupňového bratranca a ' . I18N::PLURAL . '%2$s má zaznamenaného %1$d prvostupňových bratrancov a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d prvostupňových bratrancov a ',
            '%d female first cousin recorded (%d in total).' . I18N::PLURAL . '%d female first cousins recorded (%d in total).' 
                => '%d prvostupňovú sesternicu (spolu %d).' . I18N::PLURAL . '%d prvostupňové sesternice (spolu %d).' . I18N::PLURAL . '%d prvostupňových sesterníc (spolu %d).',

            'Nephews and Nieces' => 'Synovci a netere',
            '%s has no nephews or nieces recorded.' => '%s nemá zaznamenaných žiadnych synovcov alebo netere.',
            '%s has one niece recorded.' => '%s má zaznamenanú jednu neter.',
            '%s has one nephew recorded.' => '%s má zaznamenaného jedného synovca.',
            '%s has one nephew or niece recorded.' => '%s má jedného synovca alebo jednu neter.',
            '%2$s has %1$d niece recorded.' . I18N::PLURAL . '%2$s has %1$d nieces recorded.'
                => '%2$s má zaznamenanú %1$d neter.' . I18N::PLURAL . '%2$s má zaznamenané %1$d netere.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d neterí.',
            '%2$s has %1$d nephew recorded.' . I18N::PLURAL . '%2$s has %1$d nephews recorded.' 
                => '%2$s má zaznamenaného %1$d synovca.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d synovcov.' . I18N::PLURAL . '%2$s zaznamenaných %1$d synovcov.',
            '%2$s has %1$d nephew and ' . I18N::PLURAL . '%2$s has %1$d nephews and ' 
                => '%2$s má zaznamenaného %1$d synovca a ' . I18N::PLURAL . '%2$s zaznamenaných %1$d synovcov a ' . I18N::PLURAL . '%2$s zaznamenaných %1$d synovcov a ',
            '%d niece recorded (%d in total).' . I18N::PLURAL . '%d nieces recorded (%d in total).' 
                => '%d neter (spolu %d).' . I18N::PLURAL . '%d netere (spolu %d).' . I18N::PLURAL . '%d neterí (spolu %d).',

            '%s has no children recorded.' => '%s nemá zaznamenané žiadne deti.',
            '%s has one daughter recorded.' => '%s má zaznamenanú jednu dcéru.',
            '%s has one son recorded.' => '%s má zaznamenaného jedného syna.',
            '%s has one child recorded.' => '%s má jedno dieťa.',
            '%2$s has %1$d daughter recorded.' . I18N::PLURAL . '%2$s has %1$d daughters recorded.'
                => '%2$s má zaznamenanú %1$d dcéru.' . I18N::PLURAL . '%2$s má zaznamenané %1$d dcéry.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d dcér.',
            '%2$s has %1$d son recorded.' . I18N::PLURAL . '%2$s has %1$d sons recorded.'
                => '%2$s má zaznamenaného %1$d syna.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d synov.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d synov.',
            '%2$s has %1$d son and ' . I18N::PLURAL . '%2$s has %1$d sons and '
                => '%2$s má zaznamenaného %1$d syna a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d synov a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d synov a ',
            '%d daughter recorded (%d in total).' . I18N::PLURAL . '%d daughters recorded (%d in total).'
                => '%d dcéru (spolu %d).' . I18N::PLURAL . '%d dcéry (spolu %d).' . I18N::PLURAL . '%d dcár (spolu %d).',
 
            'Grandchildren' => 'Vnúčatá',
            '%s has no grandchildren recorded.' => '%s nemá zaznamenané žiadne vnúča.',
            '%s has one granddaughter recorded.' => '%s má zaznamenanú jednu vnučku.',
            '%s has one grandson recorded.' => '%s má zaznamenaného jedného vnuka.',
            '%s has one grandchild recorded.' => '%s má zaznamenané jedno vnúča.',
            '%2$s has %1$d granddaughter recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters recorded.'
                => '%2$s má zaznamenanú %1$d vnučku.' . I18N::PLURAL . '%2$s má zaznamenané %1$d vnučky.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vnučiek.',
            '%2$s has %1$d grandson recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons recorded.' 
                => '%2$s má zaznamenaného %1$d vnuka.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vnukov.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vnukov.',
            '%2$s has %1$d grandson and ' . I18N::PLURAL . '%2$s has %1$d grandsons and ' 
                => '%2$s má zaznamenaného %1$d vnuka a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vnukov a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vnukov a ',
            '%d granddaughter recorded (%d in total).' . I18N::PLURAL . '%d granddaughters recorded (%d in total).'
                => '%d vnučku (spolu %d).' . I18N::PLURAL . '%d vnučky (spolu %d).' . I18N::PLURAL . '%d vnučiek (spolu %d).',
        ];
    }
  
    /**
     * tbd
     *
     * @return array
     */
    public static function swedishTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
        ];
    }
  
    /**
     * @return array
     */
    public static function ukrainianTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Розширена сім\'я',
            'A tab showing the extended family of an individual.' => 'Додає вкладку з розширеним виглядом родини для картки персони',
            'In which sequence should the parts of the extended family be shown?' => 'У якій послідовності будуть показані блоки розширеної сім\'ї?',
            'Family part' => 'Блоки сім\'ї',
            'How should empty parts of extended family be presented?' => 'Як відображати порожні блоки розширеної сім\'ї?',
            'Show empty block' => 'Показати пусті блоки',
            'yes, always at standard location' => 'так, завжди на звичайному місці',
            'no, but collect messages about empty blocks at the end' => 'ні, але збирати повідомлення про порожні блоки в кінці',
            'never' => 'ніколи',
            'Show options to filter the results (gender and alive/dead)?' => 'Показати параметри фільтрації результатів (стать, живий/мертвий)?',
            'Show filter options' => 'Показати параметри фільтрації',
            'Show name of proband as short name or as full name?' => 'Показувати коротке чи повне ім\'я об\'єкту (пробанду)?',
            'The short name is based on the probands Rufname or nickname. If these are not available, the first of the given names is used, if one is given. Otherwise the last name is used.' => 'Коротке ім`я базується на прізвиську або псевдонімі об`єкту. Якщо вони не є доступними, використовується перше з наявних імен. В іншому випадку використовується прізвище.',
            'Show short name' => 'Показати коротку форму імені',
            'Show labels in special situations?' => 'Показувати мітки для особливих ситуацій?',
            'Labels (or stickers) are used for example for adopted persons or foster children.' => 'Мітки (або наклейки) використовуються, наприклад, для усиновлених або прийомних дітей..',
            'Show labels' => 'Показувати мітки',
            'Use the compact design?' => 'Чи використовувати компактний дизайн?',
            'Use the compact design' => 'Застосувати компактний дизайн',
            'The compact design only shows the name and life span for each person. The enriched design also shows a photo (if this is activated for this tree) as well as birth and death information.' => 'Компактний дизайн показує лише ім`я та тривалість життя для кожної людини. Розширений дизайн також містить фотографію (якщо це дозволено для цього дерева), а також дати народження та смерті.',

            'don\'t use this filter' => 'не використовувати цей фільтр',
            'show only male persons' => 'показати тільки чоловіків',
            'show only female persons' => 'показати тільки фінок',
            'show only persons of unknown gender' => 'показати тільки персон з невідомою статтю',
            'show only alive persons' => 'показати тільки живих',
            'show only dead persons' => 'показати тільки померлих',
            'alive' => 'живий',
            'dead' => 'померлий',
            'a dead person' => 'жива людина',
            'a living person' => 'померла людина',
            'not a male person' => 'не є чоловіком',
            'not a female person' => 'не є жінкою',
            'not a person of unknown gender' => 'не є персоною з невідомою статтю',
		

            'twin' => 'близнюк',
            'triplet' => 'близнюк (трійня)',
            'quadruplet' => 'близнюк (четверо)',
            'quintuplet' => 'близнюк (п\'ятеро)',
            'sextuplet' => 'близнюк (шестеро)',
            'septuplet' => 'близнюк (семеро)',
            'octuplet' => 'близнюк (восьмеро)',
            'nonuplet' => 'близнюк (дев\'ятеро)',
            'decuplet' => 'близнюк (десятеро)',
            'Marriage' => 'Шлюб',
            'Ex-marriage' => 'Розвід',
            'Partnership' => 'Відносини',
            'Fiancée' => 'Заручини',
            ' with ' => ' із ',
            'Siblings of father' => 'Стриї і стрийни',
            'Siblings of mother' => 'Вуйки і вуйни',
            'Siblings-in-law of father' => 'Батькові шурини і своячениці',
            'Siblings-in-law of mother' => 'Дівери і зовиці матері',
            'Biological parents' => 'Рідні батьки',
            'Stepparents' => 'Прийомні батьки',
            'Parents-in-law of biological children' => 'Свати через рідних дітей',
            'Parents-in-law of stepchildren' => 'Свати через прийомних дітей',
            'Biological children' => 'Рідні діти',
            'Stepchildren' => 'Прийомні діти',
            'Stepchild' => 'Прийомна дитина',
            'Stepson' => 'Пасинок',
            'Stepdaughter' => 'Падчерка',
            'Partners of biological children' => 'Пртнери рідних дітей',
            'Partners of stepchildren' => 'Партнери прийомних дітей',
            'Biological grandchildren' => 'Рідні онуки',
            'Stepchildren of children' => 'Прийомні онуки від рідних дітей',
            'Children of stepchildren' => 'Онки від прийомних дітей',
            'Stepchildren of stepchildren' => 'Прийомні онуки від прийомних дітей',
            'Full siblings' => 'Рідні брати і сестри',
            'Half siblings' => 'Напіврідні брати і сестри',
            'Stepsiblings' => 'Зведені брати і сестри',
            'Siblings of partners' => 'Брати і сестри партнерів',
            'Partners of siblings' => 'Партнери братів і сестер',
            'Children of siblings' => 'Діти братів і сестер',
            'Siblings\' stepchildren' => 'Прийомні діти братів і сестер',
            'Children of siblings of partners' => 'Діти партнерів братів і сестер',
		
            'He' => 'йому',
            'She' => 'їй',
            'He/she' => 'йому/їй',
            'Mr.' => 'Пан',
            'Mrs.' => 'Пані',
            'No family available' => 'Не знайдено жодної сім\'ї.',
            'Parts of extended family without recorded information' => 'Частини розширеної сім\'ї, що не містять записаної інформації',
            '%s has no %s recorded.' => 'Для %s не записано %s.',
            '%s has no %s, and no %s recorded.' => 'Для %s не записано %s і %s.',
            'Father\'s family (%d)' => 'Сім\'я батька (%d)',
            'Mother\'s family (%d)' => 'Сім\'я матері (%d)',
            'Father\'s and Mother\'s family (%d)' => 'Сім\'я батька і матері (%d)',

            'Grandparents' => 'Бабусі і дідусі',
            '%s has no grandparents recorded.' => '%s не має жодного запису про бабусю чи дідуся.',
            '%s has one grandmother recorded.' => '%s має запис про одну бабусю.',
            '%s has one grandfather recorded.' => '%s має запис про одного дідуся.',
            '%s has one grandparent recorded.' => '%s має запис про одного дідуся чи бабусю.',
            '%2$s has %1$d grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d grandmothers recorded.' 
                => '%2$s має %1$d запис бабусі.' . I18N::PLURAL . '%2$s має %1$d записи бабусь.' . I18N::PLURAL . '%2$s має %1$d записів бабусь.',
            '%2$s has %1$d grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d grandfathers recorded.' 
                => '%2$s має %1$d запис дідуся.' . I18N::PLURAL . '%2$s має %1$d записи дідусів.' . I18N::PLURAL . '%2$s має %1$d записів дідусів.',
            '%2$s has %1$d grandfather and ' . I18N::PLURAL . '%2$s has %1$d grandfathers and ' 
                => '%2$s має %1$d запис дідуся та ' . I18N::PLURAL . '%2$s має %1$d записи дідусів і ' . I18N::PLURAL . '%2$s має %1$d записів дідусів і ',
            '%d grandmother recorded (%d in total).' . I18N::PLURAL . '%d grandmothers recorded (%d in total).' 
                => '%d бабусю (загалом %d).' . I18N::PLURAL . '%d бабусі (загалом %d).' . I18N::PLURAL . '%d бабусь (загалом %d).',

            'Parents' => 'Батьки',
            '%s has no parents recorded.' => '%s не має жодного запису про батьків.',
            '%s has one mother recorded.' => '%s має тільки запис матері.',
            '%s has one father recorded.' => '%s має тільки запис батька.',
            '%s has one parent recorded.' => '%s має запис про одного з батьків.',
            '%2$s has %1$d mother recorded.' . I18N::PLURAL . '%2$s has %1$d mothers recorded.'
                => '%2$s має %1$d запис про мати.' . I18N::PLURAL . '%2$s має %1$d записи про матерів.' . I18N::PLURAL . '%2$s має %1$d записів про матерів.',
            '%2$s has %1$d father recorded.' . I18N::PLURAL . '%2$s has %1$d fathers recorded.'
                => '%2$s має %1$d запис про батька.' . I18N::PLURAL . '%2$s має %1$d записи про батьків.' . I18N::PLURAL . '%2$s має %1$d записів про батьків.',
            '%2$s has %1$d father and ' . I18N::PLURAL . '%2$s has %1$d fathers and ' 
                => '%2$s має %1$d запис про батька та ' . I18N::PLURAL . '%2$s має %1$d записи про батьків і ' . I18N::PLURAL . '%2$s має %1$d записів про батьків і ',
            '%d mother recorded (%d in total).' . I18N::PLURAL . '%d mothers recorded (%d in total).' 
                => '%d мати (загалом %d).' . I18N::PLURAL . '%d матерів (загалом %d).' . I18N::PLURAL . '%d матерів (загалом %d).',

            'Parents-in-law' => 'Тесті і свекри',
            '%s has no parents-in-law recorded.' => '%s не має жодного запису про батьків.',
            '%s has one mother-in-law recorded.' => '%s має один запис про тещу або свекруху.',
            '%s has one father-in-law recorded.' => '%s має один запис про тестя або свекра',
            '%s has one parent-in-law recorded.' => '%s має запис про одного з батьків.',
            '%2$s has %1$d mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d mothers-in-law recorded.'
                => '%2$s має %1$d запис про тещу або свекруху.' . I18N::PLURAL . '%2$s має %1$d записи про тещ або свекрух.' . I18N::PLURAL . '%2$s має %1$d записів про тещ або свекрух.',
            '%2$s has %1$d father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d fathers-in-law recorded.'
                => '%2$s має %1$d запис про тестя або свекра.' . I18N::PLURAL . '%2$s має %1$d записи про тестів або свекрів.' . I18N::PLURAL . '%2$s має %1$d записів про тестів або свекрів.',
            '%2$s has %1$d father-in-law and ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law and ' 
                => '%2$s має %1$d запис про тестя або свекра і ' . I18N::PLURAL . '%2$s має %1$d записи про тестів або свекрів і ' . I18N::PLURAL . '%2$s має %1$d записів про тестів або свекрів і ',
            '%d mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d mothers-in-law recorded (%d in total).' 
                => '%d тещу або свекруху (загалом %d).' . I18N::PLURAL . '%d тещі або свекрухи (загалом %d).' . I18N::PLURAL . '%d тещ або свекрух (загалом %d).',

            'Co-parents-in-law' => 'Свати',
            '%s has no co-parents-in-law recorded.' => '%s не має жодного запису про сватів.',
            '%s has one co-mother-in-law recorded.' => '%s має один запис про сваху.',
            '%s has one co-father-in-law recorded.' => '%s має один запис про свата.',
            '%s has one co-parent-in-law recorded.' => '%s має один запис про свата або сваху.',
            '%2$s has %1$d co-mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law recorded.'
                => '%2$s має %1$d запис про сваху.' . I18N::PLURAL . '%2$s має %1$d записи про свах.' . I18N::PLURAL . '%2$s має %1$d записів про свах.',
            '%2$s has %1$d co-father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law recorded.'
                => '%2$s має %1$d запис про свата.' . I18N::PLURAL . '%2$s має %1$d записи про сватів.' . I18N::PLURAL . '%2$s має %1$d записів про сватів.',
            '%2$s has %1$d co-father-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law and ' 
                => '%2$s має %1$d запис про свата і ' . I18N::PLURAL . '%2$s має %1$d записи про сватів і ' . I18N::PLURAL . '%2$s має %1$d записів про сватів і ',
            '%d co-mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-mothers-in-law recorded (%d in total).' 
                => '%d сваху (загалом %d).' . I18N::PLURAL . '%d свахи (загалом %d).' . I18N::PLURAL . '%d свах (загалом %d).',
                        
            'Uncles and Aunts' => 'Дядьки і тітки',
            '%s has no uncles or aunts recorded.' => '%s не має жодного запису про дядьків і тіток.',
            '%s has one aunt recorded.' => '%s має запис про одну тітку.',
            '%s has one uncle recorded.' => '%s має запис про одного дядька.',
            '%s has one uncle or aunt recorded.' => '%s має запис про одного дядька чи тітку.',
            '%2$s has %1$d aunt recorded.' . I18N::PLURAL . '%2$s has %1$d aunts recorded.'
                => '%2$s має %1$d запис про тітку.' . I18N::PLURAL . '%2$s має %1$d записи про тіток.' . I18N::PLURAL . '%2$s має %1$d записів про тіток.',
            '%2$s has %1$d uncle recorded.' . I18N::PLURAL . '%2$s has %1$d uncles recorded.'
                => '%2$s має %1$d запис про дядька.' . I18N::PLURAL . '%2$s має %1$d записи про дядьків.' . I18N::PLURAL . '%2$s має %1$d записів про дядьків.',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and ' 
                => '%2$s має %1$d запис про дядька та ' . I18N::PLURAL . '%2$s має %1$d записи про дядьків і ' . I18N::PLURAL . '%2$s має %1$d записів про дядьків і ',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).' 
                => '%d тітку (загалом %d).' . I18N::PLURAL . '%d тіток (загалом %d).' . I18N::PLURAL . '%d тіток (загалом %d).', 

            'Uncles and Aunts by marriage' => 'Подружжя дядьків і тіток',
            '%s has no uncles or aunts by marriage recorded.' => '%s не має жодного запису про одруження дядьків і тіток.',
            '%s has one aunt by marriage recorded.' => '%s має запис про одну дядькову дружину.',
            '%s has one uncle by marriage recorded.' => '%s має запис про одного чоловіка тітки.',
            '%s has one uncle or aunt by marriage recorded.' => '%s має запис про одне одруження дядька чи тітки.',
            '%2$s has %1$d aunt by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d aunts by marriage recorded.'
                => '%2$s має %1$d запис про дядькову дружину.' . I18N::PLURAL . '%2$s має %1$d записи про дядькових дружин.'. I18N::PLURAL . '%2$s має %1$d записів про дядькових дружин.',
            '%2$s has %1$d uncle by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d uncles by marriage recorded.'
                => '%2$s має %1$d запис про чоловіка тітки.' . I18N::PLURAL . '%2$s має %1$d записи про чоловіків тіток.' . I18N::PLURAL . '%2$s має %1$d записів про чоловіків тіток.',
            '%2$s has %1$d uncle by marriage and ' . I18N::PLURAL . '%2$s has %1$d uncles by marriage and ' 
                => '%2$s має %1$d запис про чоловіка тітки і ' . I18N::PLURAL . '%2$s має %1$d записи про чоловіків тіток і ' . I18N::PLURAL . '%2$s має %1$d записів про чоловіків тіток і',
            '%d aunt by marriage recorded (%d in total).' . I18N::PLURAL . '%d aunts by marriage recorded (%d in total).' 
                => '%d дядину (загалом %d).' . I18N::PLURAL . '%d дядин (загалом %d).' . I18N::PLURAL . '%d дядин (загалом %d).',

            'Siblings' => 'Брати і сестри',
            '%s has no siblings recorded.' => '%s не має жодного запису про братів і сестер.',
            '%s has one sister recorded.' => '%s має запис про одну сестру.',
            '%s has one brother recorded.' => '%s має запис про одного брата.',
            '%s has one brother or sister recorded.' => '%s має запис про одну сестру або брата.',
            '%2$s has %1$d sister recorded.' . I18N::PLURAL . '%2$s has %1$d sisters recorded.'
                => '%2$s має %1$d запис про сестру.' . I18N::PLURAL . '%2$s має %1$d записи про сестер.' . I18N::PLURAL . '%2$s має %1$d записів про сестер.',
            '%2$s has %1$d brother recorded.' . I18N::PLURAL . '%2$s has %1$d brothers recorded.'
                => '%2$s має %1$d запис про брата.' . I18N::PLURAL . '%2$s має %1$d записи про братів.' . I18N::PLURAL . '%2$s має %1$d записів про братів.',
            '%2$s has %1$d brother and ' . I18N::PLURAL . '%2$s has %1$d brothers and ' 
                => '%2$s має %1$d запис про брата і ' . I18N::PLURAL . '%2$s має %1$d записи про братів і ' . I18N::PLURAL . '%2$s має %1$d записів про братів і ',
            '%d sister recorded (%d in total).' . I18N::PLURAL . '%d sisters recorded (%d in total).' 
                => '%d сестру (загалом %d).' . I18N::PLURAL . '%d сестер (загалом %d).' . I18N::PLURAL . '%d сестер (загалом %d).',
            
            'Siblings-in-law' => 'Брати та сестри подружжя',
            '%s has no siblings-in-law recorded.' => '%s не має записів про братів і сестер партнера.',
            '%s has one sister-in-law recorded.' => '%s має запис про одну зовицю чи своячку.',
            '%s has one brother-in-law recorded.' => '%s має запис про одного дівера чи шурина.',
            '%s has one sibling-in-law recorded.' => '%s має запис про одну сестру або брата партнера.',
            '%2$s has %1$d sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sisters-in-law recorded.'
                => '%2$s має %1$d запис про зовицю чи своячку.' . I18N::PLURAL . '%2$s має %1$d записи про зовиць чи своячок.' . I18N::PLURAL . '%2$s має %1$d записів про зовиць чи своячок.',
            '%2$s has %1$d brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d brothers-in-law recorded.'
                => '%2$s має %1$d запис про дівера чи шурина.' . I18N::PLURAL . '%2$s має %1$d записи про діверів чи шуринів.' . I18N::PLURAL . '%2$s має %1$d записів про діверів чи шуринів.',
            '%2$s has %1$d brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law and ' 
                => '%2$s має %1$d запис про дівера чи шурина і ' . I18N::PLURAL . '%2$s має %1$d записи про діверів чи шуринів і ' . I18N::PLURAL . '%2$s має %1$d записів про діверів чи шуринів і ',
            '%d sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d sisters-in-law recorded (%d in total).' 
                => '%d зовицю чи своячку (загалом %d).' . I18N::PLURAL . '%d зовиці чи своячки (загалом %d).' . I18N::PLURAL . '%d зовиць чи своячок (загалом %d).',
                                 
            'Partners' => 'Подружжя',
            'Partner of ' => 'Подружжя для ',
            '%s has no partners recorded.' => '%s не має жодного запису про одруження.',
            '%s has one female partner recorded.' => '%s має запис про одну дружину.',
            '%s has one male partner recorded.' => '%s має запис про одного чоловіка.',
            '%s has one partner recorded.' => '%s має запис про одного партнера.',
            '%2$s has %1$d female partner recorded.' . I18N::PLURAL . '%2$s has %1$d female partners recorded.'
                => '%2$s має %1$d запис про дружину.' . I18N::PLURAL . '%2$s має %1$d записи про дружин.' . I18N::PLURAL . '%2$s має %1$d записів про дружин.',
            '%2$s has %1$d male partner recorded.' . I18N::PLURAL . '%2$s has %1$d male partners recorded.'
                => '%2$s має %1$d запис про чоловіка.' . I18N::PLURAL . '%2$s має %1$d записи про чоловіків.' . I18N::PLURAL . '%2$s має %1$d записів про чоловіків.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and ' 
                => '%2$s має %1$d запис про чоловіка і ' . I18N::PLURAL . '%2$s має %1$d записи про чоловіків і ' . I18N::PLURAL . '%2$s має %1$d записів про чоловіків і ',
            '%2$s has %1$d female partner and ' . I18N::PLURAL . '%2$s has %1$d female partners and ' 
                => '%2$s має %1$d запис про дружину і ' . I18N::PLURAL . '%2$s має %1$d записи про дружин і ' . I18N::PLURAL . '%2$s має %1$d записів про дружин і ',
            '%d female partner recorded (%d in total).' . I18N::PLURAL . '%d female partners recorded (%d in total).' 
                => '%d дружину (загалом %d).' . I18N::PLURAL . '%d дружин (загалом %d).' . I18N::PLURAL . '%d дружин (загалом %d).',
            '%2$s has %1$d partner and ' . I18N::PLURAL . '%2$s has %1$d partners and ' 
                => '%2$s має %1$d запис про чоловіка і ' . I18N::PLURAL . '%2$s має %1$d записи про чоловіків і ' . I18N::PLURAL . '%2$s має %1$d записів про чоловіків і ',
            '%d male partner of female partners recorded (%d in total).' . I18N::PLURAL . '%d male partners of female partners recorded (%d in total).'
                => '%d чоловіка для дружин (загалом %d).' . I18N::PLURAL . '%d чоловіків для дружин (загалом %d).' . I18N::PLURAL . '%d чоловіків для дружин (загалом %d).',
            '%d female partner of male partners recorded (%d in total).' . I18N::PLURAL . '%d female partners of male partners recorded (%d in total).'
                => '%d дружину для чоловіків (загалом %d).' . I18N::PLURAL . '%d дружин для чоловіків (загалом %d).' . I18N::PLURAL . '%d дружин для чоловіків (загалом %d).',

            'Partner chains' => 'Низка партнерів',
            '%s has no members of a partner chain recorded.' => '%s не має записів учасників для утворення низки партнерів.', 
            'There are %d branches in the partner chain. ' => 'Низка партнерів має %d відгалужень.',
            'The longest branch in the partner chain to %2$s consists of %1$d partners (including %3$s).' => 'Найдовша гілка низки партнерів до %2$s складається з %1$d осіб (включаючи %3$s).',
            '%d female partner in this partner chain recorded (%d in total).' . I18N::PLURAL . '%d female partners in this partner chain recorded (%d in total).'
                =>'%d партнерку в цій низці партнерів (загалом %d).' . I18N::PLURAL . '%d партнерки в цій низці партнерів (загалом %d).' . I18N::PLURAL . '%d партнерок в цій низці партнерів (загалом %d).',

            'Cousins' => 'Двоюрідні брати і сестри',
            '%s has no first cousins recorded.' => '%s не має жодного запису про двоюрідних братів і сестер.',
            '%s has one female first cousin recorded.' => '%s має запис про одну двоюрідну сестру.',
            '%s has one male first cousin recorded.' => '%s має запис про одного двоюрідного брата.',
            '%s has one first cousin recorded.' => '%s має запис про одного двоюрідного брата чи сестру.',
            '%2$s has %1$d female first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d female first cousins recorded.'
                => '%2$s має %1$d запис про двоюрідну сестру.' . I18N::PLURAL . '%2$s має %1$d записи про двоюрідних сестер.' . I18N::PLURAL . '%2$s має %1$d записів про двоюрідних сестер.',
            '%2$s has %1$d male first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d male first cousins recorded.'
                => '%2$s має %1$d запис про двоюрідного брата.' . I18N::PLURAL . '%2$s має %1$d записи про двюрідних братів.' . I18N::PLURAL . '%2$s має %1$d записів про двюрідних братів.',
            '%2$s has %1$d male first cousin and ' . I18N::PLURAL . '%2$s has %1$d male first cousins and ' 
                => '%2$s має %1$d запис про двоюрідного брата і ' . I18N::PLURAL . '%2$s має %1$d записи про двоюрідних братів і ' . I18N::PLURAL . '%2$s має %1$d записів про двоюрідних братів і ',
            '%d female first cousin recorded (%d in total).' . I18N::PLURAL . '%d female first cousins recorded (%d in total).' 
                => '%d двоюрідну сестру (загалом %d).' . I18N::PLURAL . '%d двоюрідних сестер (загалом %d).' . I18N::PLURAL . '%d двоюрідних сестер (загалом %d).',
                
            'Nephews and Nieces' => 'Племінники та племінниці',
            '%s has no nephews or nieces recorded.' => '%s не має жодного запису про племінників чи племінниць.',
            '%s has one niece recorded.' => '%s має запис про одну племінницю.',
            '%s has one nephew recorded.' => '%s має запис про одного племінника.',
            '%s has one nephew or niece recorded.' => '%s має запис про одного племінника чи племінницю.',
            '%2$s has %1$d niece recorded.' . I18N::PLURAL . '%2$s has %1$d nieces recorded.'
                => '%2$s має %1$d запис про племінницю.' . I18N::PLURAL . '%2$s має %1$d записи про племінниць.' . I18N::PLURAL . '%2$s має %1$d записів про племінниць.',
            '%2$s has %1$d nephew recorded.' . I18N::PLURAL . '%2$s has %1$d nephews recorded.'
                => '%2$s має %1$d запис про племінника.' . I18N::PLURAL . '%2$s має %1$d записи про племінників.' . I18N::PLURAL . '%2$s має %1$d записів про племінників.',
            '%2$s has %1$d nephew and ' . I18N::PLURAL . '%2$s has %1$d nephews and ' 
                => '%2$s має %1$d запис про племінника та ' . I18N::PLURAL . '%2$s має %1$d записи про племінників і ' . I18N::PLURAL . '%2$s має %1$d записів про племінників і ',
            '%d niece recorded (%d in total).' . I18N::PLURAL . '%d nieces recorded (%d in total).' 
                => '%d племінницю (загалом %d).' . I18N::PLURAL . '%d племінниць (загалом %d).' . I18N::PLURAL . '%d племінниць (загалом %d).',

            'Children' => 'Діти',
            '%s has no children recorded.' => '%s не має жодного запису про дітей.',
            '%s has one daughter recorded.' => '%s має запис про одну дочку.',
            '%s has one son recorded.' => '%s має запис про одного сина.',
            '%s has one child recorded.' => '%s запис про одну дитину.',
            '%2$s has %1$d daughter recorded.' . I18N::PLURAL . '%2$s has %1$d daughters recorded.'
                => '%2$s має %1$d запис про дочку.' . I18N::PLURAL . '%2$s має %1$d записи про дочок.' . I18N::PLURAL . '%2$s має %1$d записів про дочок.',
            '%2$s has %1$d son recorded.' . I18N::PLURAL . '%2$s has %1$d sons recorded.'
                => '%2$s має %1$d запис про сина.' . I18N::PLURAL . '%2$s має %1$d записи про синів.' . I18N::PLURAL . '%2$s має %1$d записів про синів.',
            '%2$s has %1$d son and ' . I18N::PLURAL . '%2$s has %1$d sons and ' 
                => '%2$s має %1$d запис про сина та ' . I18N::PLURAL . '%2$s має %1$d записи про синів і ' . I18N::PLURAL . '%2$s має %1$d записів про синів і ',
            '%d daughter recorded (%d in total).' . I18N::PLURAL . '%d daughters recorded (%d in total).' 
                => '%d дочку (загалом %d).' . I18N::PLURAL . '%d дочок (загалом %d).' . I18N::PLURAL . '%d дочок (загалом %d).',

            'Children-in-law' => 'Зяті й невістки',
            '%s has no children-in-law recorded.' => '%s не має записів про зятів і невісток.',
            '%s has one daughter-in-law recorded.' => '%s має запис про одну невістку.',
            '%s has one son-in-law recorded.' => '%s має запис про одного зятя.',
            '%s has one child-in-law recorded.' => '%s має запис про одного зятя або невістку.',
            '%2$s has %1$d daughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d daughters-in-law recorded.'
                => '%2$s має %1$d запис про невістку.' . I18N::PLURAL . '%2$s має %1$d записи про невісток.' . I18N::PLURAL . '%2$s має %1$d записів про невісток.',
            '%2$s has %1$d son-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sons-in-law recorded.'
                => '%2$s має %1$d запис про зятя.' . I18N::PLURAL . '%2$s має %1$d записи про зятів.' . I18N::PLURAL . '%2$s має %1$d записів про зятів.',
            '%2$s has %1$d son-in-law and ' . I18N::PLURAL . '%2$s has %1$d sons-in-law and ' 
                => '%2$s має %1$d запис про зятя і ' . I18N::PLURAL . '%2$s має %1$d записи про зятів і ' . I18N::PLURAL . '%2$s має %1$d записів про зятів і ',
            '%d daughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d daughters-in-law recorded (%d in total).' 
                => '%d невістку (загалом %d).' . I18N::PLURAL . '%d невісток (загалом %d).' . I18N::PLURAL . '%d невісток (загалом %d).',

            'Grandchildren' => 'Онуки',
            '%s has no grandchildren recorded.' => '%s не має жодного запису про онуків.',
            '%s has one granddaughter recorded.' => '%s має запис про одну онуку.',
            '%s has one grandson recorded.' => '%s має запис про одного внука.',
            '%s has one grandchild recorded.' => '%s має запис про одного внука чи онуку.',
            '%2$s has %1$d granddaughter recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters recorded.'
                => '%2$s має %1$d запис про онуку.' . I18N::PLURAL . '%2$s має %1$d записи про онук.' . I18N::PLURAL . '%2$s має %1$d записів про онук.',
            '%2$s has %1$d grandson recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons recorded.' 
                => '%2$s має %1$d запис про внука.' . I18N::PLURAL . '%2$s має %1$d записи про внуків.' . I18N::PLURAL . '%2$s має %1$d записів про внуків.',
            '%2$s has %1$d grandson and ' . I18N::PLURAL . '%2$s has %1$d grandsons and ' 
                => '%2$s має %1$d запис про внука та ' . I18N::PLURAL . '%2$s має %1$d записи про внуків і ' . I18N::PLURAL . '%2$s має %1$d записів про внуків і ',
            '%d granddaughter recorded (%d in total).' . I18N::PLURAL . '%d granddaughters recorded (%d in total).'
                => '%d онуку (загалом %d).' . I18N::PLURAL . '%d онучок (загалом %d).' . I18N::PLURAL . '%d онучок (загалом %d).',
        ];
    }

    /**
     * @return array
     */
    public static function vietnameseTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Gia đình mở rộng',
            'A tab showing the extended family of an individual.' => 'Một bảng hiển thị thêm các thành phần gia đình mở rộng của một cá nhân.',
            'In which sequence should the parts of the extended family be shown?' => 'Thứ tự các thành phần trong gia đình mở rộng được hiển thị?',
            'Family part' => 'Thành phần gia đình',
            'Show name of proband as short name or as full name?' => 'Hiển thị tên dưới dạng tên ngắn hay tên đầy đủ?',
            'Show options to filter the results (gender and alive/dead)?' => 'Hiển thị các tùy chọn để lọc kết quả (giới tính và còn sống / đã mất)?',
            'Show filter options' => 'Hiển thị các tùy chọn bộ lọc',
            'Filter results (should be made available to be used by user instead of admin):' => 'Lọc kết quả (nên được cung cấp để người dùng sử dụng thay vì quản trị viên)',
            'Filter by gender' => 'Lọc theo giới tính',
            'Filter by alive/dead' => 'Lọc theo còn sống / đã mất',
            'How should empty parts of extended family be presented?' => 'Các thành phần gia đình không có thông tin được trình bày như thế nào?',
            'Show empty block' => 'Hiển thị thành phần gia đình không có thông tin',
            'yes, always at standard location' => 'Luôn hiển thị',
            'no, but collect messages about empty blocks at the end' => 'Không, nhưng thu thập thông báo về các khối trống ở cuối',
            'never' => 'Không hiển thị',
            'The short name is based on the probands Rufname or nickname. If these are not available, the first of the given names is used, if one is given. Otherwise the last name is used.' => 'Tên viết tắt dựa hoặc biệt danh. Nếu chúng không có sẵn, tên đầu tiên trong số các tên đã cho sẽ được sử dụng, nếu một tên được đưa ra. Nếu không, họ sẽ được sử dụng.',
            'Show short name' => 'Hiển thị tên rút gọn', 
            'Show labels in special situations?' => 'Hiển thị nhãn trong các trường hợp đặc biệt?',
            'Labels (or stickers) are used for example for adopted persons or foster children.' => 'Nhãn (hoặc nhãn dán) được sử dụng chẳng hạn cho người được nhận nuôi hoặc cha/mẹ kế. ',
            'Show labels' => 'Hiển thị nhãn dán',
            'Use the compact design?' => 'Hiển thị các thông tin rút gọn?',
            'Use the compact design' => 'Áp dụng hiển thị thông tin rút gọn',
            'The compact design only shows the name and life span for each person. The enriched design also shows a photo (if this is activated for this tree) as well as birth and death information.' => 'Hiển thị rút gọn chỉ ghi tên, năm sinh năm mất cho mỗi người. Hiển thị đầy đủ sẽ bao gồm một bức ảnh (nếu điều này được kích hoạt cho cây gia đình này) cũng như thông tin về ngày sinh, nơi sinh và ngày mất, nơi mất của một cá nhân.',

            'don\'t use this filter' => 'không sử dụng bộ lọc này',
            'show only male persons' => 'Chỉ hiển thị giới tính nam',
            'show only female persons' => 'Chỉ hiển thị giới tính nữ',
            'show only persons of unknown gender' => 'Chỉ hiển thị những người có giới tính không xác định',
            'show only alive persons' => 'Chỉ hiển thị những người còn sống',
            'show only dead persons' => 'Chỉ hiển thị những người đã mất',
            'alive' => 'Chỉ hiển thị người còn sống',
            'dead' => 'Chỉ hiện thì người đã mất',
            'a dead person' => 'một người đã mất',
            'a living person' => 'một người còn sống',
            'not a male person' => 'không có người giới tính nam',
            'not a female person' => 'không có người giới tính nữ',
            'not a person of unknown gender' => 'không có người không xác định giới tính',

            'twin' => 'sinh đôi',
            'triplet' => 'sinh ba',
            'quadruplet' => 'sinh bốn',
            'quintuplet' => 'sinh năm',
            'sextuplet' => 'sinh sáu',
            'septuplet' => 'sinh bảy',
            'octuplet' => 'sinh tám',
            'nonuplet' => 'sinh chín',
            'decuplet' => 'sinh mười',

            'Marriage' => 'Kết hôn',
            'Ex-marriage' => 'Kết hôn lại',
            'Partnership' => 'Quan hệ hôn nhân',
            'Fiancée' => 'Hôn ước',
            ' with ' => ' với ',
            'Biological parents of father' => 'Ông bà nội',
            'Biological parents of mother' => 'Ông bà ngoại',
            'Biological parents of parent' => 'Ông bà',
            'Stepparents of father' => 'Bố mẹ kế của bố',
            'Stepparents of mother' => 'Bố mẹ kế của mẹ',
            'Stepparents of parent' => 'Bố mẹ kế của bố mẹ',
            'Parents of stepparents' => 'Bố mẹ của bố mẹ kế',
            'Siblings of father' => 'Anh chị em của bố',
            'Siblings of mother' => 'Anh chị em của mẹ',
            'Siblings-in-law of father' => 'Anh chị em dâu rể của bố',
            'Siblings-in-law of mother' => 'Anh chị em dâu rể của mẹ',
            'Biological parents' => 'Bố mẹ',
            'Stepparents' => 'Bố/Mẹ kế',
            'Parents-in-law of biological children' => 'Bố mẹ chồng của con đẻ',
            'Parents-in-law of stepchildren' => 'Bố mẹ chồng của con ghẻ',
            'Full siblings' => 'Anh chị em ruột',
            'Half siblings' => 'Anh chị em cùng cha khác mẹ/cùng mẹ khác cha',
            'Stepsiblings' => 'Anh chị em kế',
            'Children of full siblings of father' => 'Anh chị em cùng cha',
            'Children of full siblings of mother' => 'Anh chị em cụng mẹ',
            'Children of full siblings of parent' => 'Anh chị em cùng cha mẹ',
            'Children of half siblings of father' => 'Anh chị em cùng cha khác mẹ',
            'Children of half siblings of mother' => 'Anh chị em cùng mẹ khác cha',
            'Children of half siblings of parent' => 'Anh chị em cùng cha mẹ',
            'Siblings of partners' => 'Anh, chị, em ruột của chồng (vợ)',
            'Partners of siblings' => 'Vợ/chồng của anh chị em',
            'Children of siblings' => 'Con của anh chị em ruột',
            'Siblings\' stepchildren' => 'Anh chị em là con riêng',
            'Children of siblings of partners' => 'Con của anh, chị, em ruột của chồng/vợ',
            'Biological children' => 'Con',
            'Stepchildren' => 'Con ghẻ',
            'Stepchild' => 'Con riêng',
            'Stepson' => 'Con trai riêng',
            'Stepdaughter' => 'Con gái riêng',
            'Partners of biological children' => 'Bạn đời của con ruột',
            'Partners of stepchildren' => 'Bạn đời của con riêng',
            'Biological grandchildren' => 'Cháu',
            'Stepchildren of children' => 'Con ghẻ của con',
            'Children of stepchildren' => 'Con của con riêng',
            'Stepchildren of stepchildren' => 'Con riêng của con riêng',

            'He' => 'Anh',
            'She' => 'Cô',
            'He/she' => 'Anh/Cô',
            'Mr.' => 'Ông',
            'Mrs.' => 'Bà',
            'No family available' => 'Không có thông tin về gia đình',
            'Parts of extended family without recorded information' => 'Các mối quan hệ khác trong gia đình không có thông tin được ghi lại',
            '%s has no %s recorded.' => '%s không có %s thông tin được ghi lại.',
            '%s has no %s, and no %s recorded.' => '%s không có %s và không có %s thông tin được ghi lại.',
            'Father\'s family (%d)' => 'Gia đình bên Bố (%d)',
            'Mother\'s family (%d)' => 'Gia đình bên Mẹ (%d)',
            'Father\'s and Mother\'s family (%d)' => 'Gia đình của Bố và Mẹ (%d)',

            'Grandparents' => 'Ông bà',
            '%s has no grandparents recorded.' => '%s không có thông tin về ông bà.',
            '%s has one grandmother recorded.' => '%s có một người bà.',
            '%s has one grandfather recorded.' => '%s có một người ông.',
            '%s has one grandparent recorded.' => '%s có ông bà.',
            '%2$s has %1$d grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d grandmothers recorded.'
                => '%2$s có %1$d bà nội.',
            '%2$s has %1$d grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d grandfathers recorded.'
                => '%2$s có %1$d ông nội.',
            '%2$s has %1$d grandfather and ' . I18N::PLURAL . '%2$s has %1$d grandfathers and ' 
                => '%2$s có %1$d ông nội và ',
            '%d grandmother recorded (%d in total).' . I18N::PLURAL . '%d grandmothers recorded (%d in total).' 
                => '%d bà nội.',//có thể thay bằng '%d bà nội (tổng %d).' để xem có bao nhiêu ông và bà

            'Uncles and Aunts' => 'Bác trai, bác gái, chú và cô',
            '%s has no uncles or aunts recorded.' => '%s không có thông tin về bác / cô chú.',
            '%s has one aunt recorded.' => '%s có một bác gái hoặc cô.',
            '%s has one uncle recorded.' => '%s có một bác trai hoặc chú.',
            '%s has one uncle or aunt recorded.' => '%s có một bác trai/bác gái hoặc cô/chú.',
            '%2$s has %1$d aunt recorded.' . I18N::PLURAL . '%2$s has %1$d aunts recorded.'
                => '%2$s có %1$d người là bác gái hoặc cô.',
            '%2$s has %1$d uncle recorded.' . I18N::PLURAL . '%2$s has %1$d uncles recorded.'
                => '%2$s có %1$d người là chú bác.',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and ' 
                => '%2$s có %1$d bác trai hoặc chú và ',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).' 
                => '%d bác gái hoặc cô (có tất cả là %d người).',

            'Uncles and Aunts by marriage' => 'Các bác rể/chú rể và các bác dâu/thím dâu',
            '%s has no uncles or aunts by marriage recorded.' => '%s Không có bác rể/chú rể hoặc bác/thím dâu nào.',
            '%s has one aunt by marriage recorded.' => '%s có một bác dâu hoặc thím dâu.',
            '%s has one uncle by marriage recorded.' => '%s có một bác rể hoặc chú rể.',
            '%s has one uncle or aunt by marriage recorded.' => '%s có một bác rể/chú rể hoặc bác dâu/thím dâu.',
            '%2$s has %1$d aunt by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d aunts by marriage recorded.'
                => '%2$s có %1$d bác dâu/thím dâu.',
            '%2$s has %1$d uncle by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d uncles by marriage recorded.'
                => '%2$s có %1$d bác rể/chú rể.',
            '%2$s has %1$d uncle by marriage and ' . I18N::PLURAL . '%2$s has %1$d uncles by marriage and ' 
                => '%2$s có %1$d bác rể/chú rể và ',
            '%d aunt by marriage recorded (%d in total).' . I18N::PLURAL . '%d aunts by marriage recorded (%d in total).' 
                => '%d bác dâu/thím dâu (có tất cả là %d người).',

            'Parents' => 'Bố mẹ',
            '%s has no parents recorded.' => '%s không có thông tin về bố mẹ.',
            '%s has one mother recorded.' => '%s có một người mẹ.',
            '%s has one father recorded.' => '%s có một người bố.',
            '%s has one parent recorded.' => '%s có một ông bà.',
            '%2$s has %1$d mother recorded.' . I18N::PLURAL . '%2$s has %1$d mothers recorded.' 
                => '%2$s có %1$d người mẹ.',
            '%2$s has %1$d father recorded.' . I18N::PLURAL . '%2$s has %1$d fathers recorded.' 
                => '%2$s có %1$d người bố.',
            '%2$s has %1$d father and ' . I18N::PLURAL . '%2$s has %1$d fathers and ' 
                => '%2$s có %1$d người bố và ',
            '%d mother recorded (%d in total).' . I18N::PLURAL . '%d mothers recorded (%d in total).' 
                => '%d người mẹ.',//có thể thay bằng '%d người mẹ (tổng %d).' để xem có bao nhiêu bố, mẹ

            'Parents-in-law' => 'Bố mẹ chồng',
            '%s has no parents-in-law recorded.' => '%s không có thông tin về bố mẹ chồng.',
            '%s has one mother-in-law recorded.' => '%s có một người mẹ chồng.',
            '%s has one father-in-law recorded.' => '%s có một người bố chồng.',
            '%s has one parent-in-law recorded.' => '%s có bố mẹ chồng.',
            '%2$s has %1$d mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d mothers-in-law recorded.'
                => '%2$s có %1$d mẹ chồng.',
            '%2$s has %1$d father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d fathers-in-law recorded.'
                => '%2$s có %1$d bố chồng.',
            '%2$s has %1$d father-in-law and ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law and ' 
                => '%2$s có %1$d bố chồng và ',
            '%d mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d mothers-in-law recorded (%d in total).' 
                => '%d mẹ chồng (có tất cả là %d người).',

            'Co-parents-in-law' => 'Thông gia',
            '%s has no co-parents-in-law recorded.' => '%s không có thông tin về gia đình thông gia.',
            '%s has one co-mother-in-law recorded.' => '%s có một bà thông gia.',
            '%s has one co-father-in-law recorded.' => '%s có một ông thông gia.',
            '%s has one co-parent-in-law recorded.' => '%s có ông bà thông gia.',
            '%2$s has %1$d co-mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law recorded.'
                => '%2$s có %1$d bà thông gia.',
            '%2$s has %1$d co-father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law recorded.'
                => '%2$s có %1$d ông thông gia.',
            '%2$s has %1$d co-father-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law and ' 
                => '%2$s có %1$d ông thông gia và ',
            '%d co-mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-mothers-in-law recorded (%d in total).' 
                => '%d bà thông gia (có tất cả là %d người).',

            'Siblings' => 'Anh chị em ruột',
            '%s has no siblings recorded.' => '%s không có thông tin về anh chị em ruột.',
            '%s has one sister recorded.' => '%s có một chị gái hoặc em gái.',
            '%s has one brother recorded.' => '%s có một anh trai hoặc em trai.',
            '%s has one brother or sister recorded.' => '%s có môt anh em trai hoặc một chị em gái.',
            '%2$s has %1$d sister recorded.' . I18N::PLURAL . '%2$s has %1$d sisters recorded.'
                => '%2$s có %1$d chị em gái.',
            '%2$s has %1$d brother recorded.' . I18N::PLURAL . '%2$s has %1$d brothers recorded.'
                => '%2$s có %1$d người anh em trai.',
            '%2$s has %1$d brother and ' . I18N::PLURAL . '%2$s has %1$d brothers and ' 
                => '%2$s có %1$d anh em trai và ',
            '%d sister recorded (%d in total).' . I18N::PLURAL . '%d sisters recorded (%d in total).' 
                => '%d chị em gái (có tất cả là %d người).', 

            'Siblings-in-law' => 'Anh em rể và chị em dâu',
            '%s has no siblings-in-law recorded.' => '%s không có anh em rể hoặc chị em dâu.',
            '%s has one sister-in-law recorded.' => '%s có một người chị dâu hoặc em dâu.',
            '%s has one brother-in-law recorded.' => '%s có một người anh rể hoặc em rể .',
            '%s has one sibling-in-law recorded.' => '%s có một anh em rể hoặc chị em dâu.',
            '%2$s has %1$d sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sisters-in-law recorded.'
                => '%2$s có %1$d chị em dâu.',
            '%2$s has %1$d brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d brothers-in-law recorded.'
                => '%2$s có %1$d anh em rể.',
            '%2$s has %1$d brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law and ' 
                => '%2$s có %1$d anh em rể và',
            '%d sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d sisters-in-law recorded (%d in total).' 
                => '%d chị em dâu (có tất cả là %d người).',
                                
            'Partners' => 'Vợ chồng',
            'Partner of ' => 'Vợ (chồng) của ',
            '%s has no partners recorded.' => '%s không có thông tin về vợ/chồng.',
            '%s has one female partner recorded.' => '%s có một người vợ.',
            '%s has one male partner recorded.' => '%s có một người chồng.',
            '%s has one partner recorded.' => '%s có một vợ/chồng.',
            '%2$s has %1$d female partner recorded.' . I18N::PLURAL . '%2$s has %1$d female partners recorded.'
                => '%2$s có %1$d người vợ.',
            '%2$s has %1$d male partner recorded.' . I18N::PLURAL . '%2$s has %1$d male partners recorded.'
                => '%2$s có %1$d một người chồng.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and ' 
                => '%2$s có %1$d một người chồng và ',
            '%2$s has %1$d female partner and ' . I18N::PLURAL . '%2$s has %1$d female partners and ' 
                => '%2$s có %1$d một người vợ và ',
            '%d female partner recorded (%d in total).' . I18N::PLURAL . '%d female partners recorded (%d in total).' 
                => '%d một người vợ (%d người).',
            '%2$s has %1$d partner and ' . I18N::PLURAL . '%2$s has %1$d partners and ' 
                => '%2$s có %1$d một người vợ/chồng và ',
            '%d male partner of female partners recorded (%d in total).' . I18N::PLURAL . '%d male partners of female partners recorded (%d in total).'
                => '%d chồng của những người vợ (có tất cả là %d người).',
            '%d female partner of male partners recorded (%d in total).' . I18N::PLURAL . '%d female partners of male partners recorded (%d in total).'
                => '%d vợ của những người chồng (có tất cả là %d người).',

            'Partner chains' => 'Chuỗi đối tác',
            '%s has no members of a partner chain recorded.' => '%s không có thành viên nào của chuỗi đối tác.', 
            'There are %d branches in the partner chain. ' => 'Có %d nhánh trong chuỗi đối tác.',
            'The longest branch in the partner chain to %2$s consists of %1$d partners (including %3$s).' => 'Nhánh dài nhất trong chuỗi đối tác đến %2$s bao gồm %1$d đối tác (kể cả %3$s).',
            '%d female partner in this partner chain recorded (%d in total).' . I18N::PLURAL . '%d female partners in this partner chain recorded (%d in total).'
                =>'%d đối tác nữ trong chuỗi đối tác này (có tất cả là %d người).',
           
            'Cousins' => 'Anh chị em họ',
            '%s has no first cousins recorded.' => '%s không có thông tin về anh em họ.',
            '%s has one female first cousin recorded.' => '%s có một chị em họ.',
            '%s has one male first cousin recorded.' => '%s có một anh em họ.',
            '%s has one first cousin recorded.' => '%s có một anh em họ.',
            '%2$s has %1$d female first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d female first cousins recorded.'
                => '%2$s có %1$d chị họ/em gái họ.',
            '%2$s has %1$d male first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d male first cousins recorded.'
                => '%2$s có %1$d anh/em trai họ.',
            '%2$s has %1$d male first cousin and ' . I18N::PLURAL . '%2$s has %1$d male first cousins and '
                => '%2$s có %1$d anh/em trai họ và ',
            '%d female first cousin recorded (%d in total).' . I18N::PLURAL . '%d female first cousins recorded (%d in total).'
                => '%d chị/em gái họ (có tất cả là %d người).',

            'Nephews and Nieces' => 'Cháu (Là con của anh em trai ruột)',
            '%s has no nephews or nieces recorded.' => '%s không có thông tin về con của anh chị em ruột.',
            '%s has one niece recorded.' => '%s có một cháu gái.',
            '%s has one nephew recorded.' => '%s có một cháu trai.',
            '%s has one nephew or niece recorded.' => '%s có một cháu trai hoặc một cháu gái.',
            '%2$s has %1$d niece recorded.' . I18N::PLURAL . '%2$s has %1$d nieces recorded.'
                => '%2$s có %1$d một cháu gái.',
            '%2$s has %1$d nephew recorded.' . I18N::PLURAL . '%2$s has %1$d nephews recorded.'
                => '%2$s có %1$d một cháu trai.',
            '%2$s has %1$d nephew and ' . I18N::PLURAL . '%2$s has %1$d nephews and '
                => '%2$s có %1$d cháu trai và',
            '%d niece recorded (%d in total).' . I18N::PLURAL . '%d nieces recorded (%d in total).'
                => '%d cháu gái có tất cả là (có có tất cả là %d người).',

            'Children' => 'Con',
            '%s has no children recorded.' => '%s không có thông tin về con cái.',
            '%s has one daughter recorded.' => '%s có một con gái.',
            '%s has one son recorded.' => '%s có một con trai.',
            '%s has one child recorded.' => '%s có một người con được.',
            '%2$s has %1$d daughter recorded.' . I18N::PLURAL . '%2$s has %1$d daughters recorded.'
                => '%2$s có %1$d con gái.',
            '%2$s has %1$d son recorded.' . I18N::PLURAL . '%2$s has %1$d sons recorded.'
                => '%2$s có %1$d con trai.',
            '%2$s has %1$d son and ' . I18N::PLURAL . '%2$s has %1$d sons and '
                => '%2$s có %1$d con trai và ',
            '%d daughter recorded (%d in total).' . I18N::PLURAL . '%d daughters recorded (%d in total).'
                => '%d con gái (có tất cả là %d người con).',

            'Children-in-law' => 'Con dâu và con rể',
            '%s has no children-in-law recorded.' => '%s không có thông tin về con dâu và con rể.',
            '%s has one daughter-in-law recorded.' => '%s có một con dâu.',
            '%s has one son-in-law recorded.' => '%s có một con rể.',
            '%s has one child-in-law recorded.' => '%s có con dâu hoặc con rể.',
            '%2$s has %1$d daughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d daughters-in-law recorded.'
                => '%2$s có %1$d con dâu.',
            '%2$s has %1$d son-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sons-in-law recorded.'
                => '%2$s có %1$d con rể.',
            '%2$s has %1$d son-in-law and ' . I18N::PLURAL . '%2$s has %1$d sons-in-law and '
                => '%2$s có %1$d con rể và ',
            '%d daughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d daughters-in-law recorded (%d in total).'
                => '%d con dâu (có tất cả là %d người).',

            'Grandchildren' => 'Cháu nội',
            '%s has no grandchildren recorded.' => '%s không có thông tin về cháu.',
            '%s has one granddaughter recorded.' => '%s có một cháu gái.',
            '%s has one grandson recorded.' => '%s có một cháu trai.',
            '%s has one grandchild recorded.' => '%s có một cháu.',
            '%2$s has %1$d granddaughter recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters recorded.'
                => '%2$s có %1$d cháu gái.',
            '%2$s has %1$d grandson recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons recorded.'
                => '%2$s có %1$d cháu trai.',
            '%2$s has %1$d grandson and ' . I18N::PLURAL . '%2$s has %1$d grandsons and '
                => '%2$s có %1$d cháu trai và ',
            '%d granddaughter recorded (%d in total).' . I18N::PLURAL . '%d granddaughters recorded (%d in total).'
                => '%d cháu gái (có tất cả là %d người).',
        ];
    }
         
    /**
     * tbd
     *
     * @return array
     */
    public static function chineseSimplifiedTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => '大家庭',
            'Grandparents' => '祖父母',
        ];
    }
    
    /**
     * tbd
     *
     * @return array
     */
    public static function chineseTraditionalTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => '大家庭',
            'Grandparents' => '祖父母',
        ];
    }
}
