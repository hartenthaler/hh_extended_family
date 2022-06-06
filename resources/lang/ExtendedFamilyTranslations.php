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
 * tbd
 * ---
 * Umstellung der Übersetzungen per Weblate oder po/mo prüfen (siehe issue #117)
 * Übersetzungen für italian einbauen, sobald diese zugeliefert wurde
 * weitere fehlende Übersetzungen organisieren
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
    public static function catalanTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Fam&iacute;lia extensa',
            'A tab showing the extended family of an individual.' => 'Aquesta pestanya mostra tots els vincles familiars d\'una persona',
            'In which sequence should the parts of the extended family be shown?' => 'En quin ordre s\'han de mostrar les parts de la Fam&iacute;lia Extensa?',
            'Family part' => 'Blocs de la fam&iacute;lia',
            'Show name of proband as short name or as full name?' => 'Ha de mostrar-se una forma abreujada o el nom complet de la persona?',
            'Show options to filter the results (gender and alive/dead)?' => 'Mostrar opcions per a filtrar els resultats (g&egrave;nere i viu/mort)?',
            'Show filter options' => 'Mostrar els filtres',
            'How should empty parts of extended family be presented?' => 'Com vols que es mostren els blocs buits en la pestanya fam&iacute;lia extensa?',
            'Show empty block' => 'Vols que es mostren els blocs sense informaci&oacute;',
            'yes, always at standard location' => 'S&iacute;.  Mostra blocs sense informaci&oacute; en la seva posici&oacute; ordin&agrave;ria',
            'no, but collect messages about empty blocks at the end' => 'No mostrar blocs sense informaci&oacute;,per&ograve; recopila una descripci&oacute; dels blocs que falten al final',
            'never' => 'No mostrar els blocs sense informaci&oacute;',
            'The short name is based on the probands Rufname or nickname. If these are not available, the first of the given names is used, if one is given. Otherwise the last name is used.' => 'El nom curt es basa en els malnoms. Si aquests no estan disponibles, s\'utilitza el primer dels noms de pila, si es d&oacute;na algun. En cas contrari, s\'utilitza el cognom.',
            'Show short name' => 'Mostrar nom curt',
            'Show labels in special situations?' => 'Mostrar etiquetes en situacions especials?',
            'Labels (or stickers) are used for example for adopted persons or foster children.' => 'Les etiquetes s\'utilitzen, per exemple, per a persones adoptades o nens d\'acolliment. ',
            'Show labels' => 'Mostrar etiquetes',
            'Use the compact design?' => 'Usar el disseny compacte?',
            'Use the compact design' => 'Usar el disseny compacte',
            'The compact design only shows the name and life span for each person. The enriched design also shows a photo (if this is activated for this tree) as well as birth and death information.' => 'El disseny compacte sol mostra el nom, data de naixement i data de la mort de cada persona. El disseny enriquit tamb&eacute; mostra una foto (si tens fotos en el perfil dels familiars en l\'arbre) aix&iacute; com informaci&oacute; sobre el naixement i la mort.',
            'Show parameters of extended family part?' => 'Mostrar par&agrave;metres de la familia extensa?',
            'Display of additional information for each part of the extended family, such as the generation shift and the coefficient of relationship, which is a measure of the degree of consanguinity.' => 'Visualitzaci&oacute; informaci&oacute; addicional per a cada membre de la familia extensa, aix&iacute; com el moviment generacional i el coeficient de parentiu mesurat amb grau de consanguinitat.',
            'Show parameters' => 'Mostrar par&agrave;metres',

            'generation +%s' => 'Generació +%s',
            'same generation' => 'Mateixa Generació',
            'generation %s' => 'Generació +%s',
            'relationship coefficient: %.1f' => 'Coeficient %.1f',
            'no blood relationship' => 'sense relaci&oacute; de consanguinitat',

            'don\'t use this filter' => 'No utilitzar aquest filtre',
            'show only male persons' => 'Mostrar nom&eacute;s homes',
            'show only female persons' => 'Mostrar nom&eacute;s dones',
            'show only persons of unknown gender' => 'Mostrar nom&eacute;s persones de g&egrave;nere desconegut',
            'show only alive persons' => 'Mostrar nom&eacute;s persones vives',
            'show only dead persons' => 'Mostrar nom&eacute;s persones difuntes',
            'alive' => 'Viu',
            'dead' => 'Difunt',
            'a dead person' => 'una persona difunta',
            'a living person' => 'una persona viva',
            'not a male person' => 'No t&eacute; un home',
            'not a female person' => 'No t&eacute; una dona',
            'not a person of unknown gender' => 'No t&eacute; una persona de g&egrave;nere desconegut',

            'twin' => 'Bess&oacute;',
            'triplet' => 'Trigemin',
            'quadruplet' => 'quadrigemin',
            'quintuplet' => 'Quintigemin',
            'sextuplet' => 'Sextigemin',
            'septuplet' => 'Septigemin',
            'octuplet' => 'Octigemin',
            'nonuplet' => 'Nonagemin',
            'decuplet' => 'Decigemin',
            'stillborn' => 'nascut mort',
            'died as infant' => 'Va morir quan era nen',
            'linkage challenged' => 'Disputa per a ser reconegut',
            'linkage disproven' => 'No reconegut',
            'linkage proven' => 'Reconegut',

            'Marriage' => 'Matrimoni',
            'Ex-marriage' => 'Ex-matrimoni',
            'Partnership' => 'c&ograve;njuge',
            'Fiancée' => 'Núvia',
            ' with ' => ' amb ',

            'Biological grandparents of father' => 'Avis biol&ograve;gics del pare',
            'Biological grandparents of mother' => 'Avis biol&ograve;gics de la mare',
            'Biological grandparents of parent' => 'Avis biol&ograve;gics dels pares',
            'Stepparents of biological parent of father' => 'Padrastre del pare biol&ograve;gic',
            'Stepparents of biological parent of mother' => 'Padrastres del pare biol&ograve;gic de la mare',
            'Stepparents of biological grandparent' => 'Padrastres de l\'avi biol&ograve;gic',
            'Parents of stepparent of father' => 'Pares del padrastre o de la madrastra',
            'Parents of stepparent of mother' => 'Pares del padrastre de la mare',
            'Parents of stepparent of parent' => 'Pares del padrastre de la mare',
            'Grandparents of stepparent' => 'Avis dels padrastres',
            'Biological great-grandparents' => 'Besavis biol&ograve;gics',
            'Biological parents of father' => 'Avis biol&ograve;gics per part del pare',
            'Biological parents of mother' => 'Avis biol&ograve;gics per part de la mare',
            'Biological parents of parent' => 'Pares biol&ograve;gics',
            'Stepparents of father' => 'Padrastres del pare',
            'Stepparents of mother' => 'Padrastres de la mare',
            'Stepparents of parent' => 'Padrastres dels pares',
            'Parents of stepparent' => 'Pares de padrastres',
            'Siblings of father' => 'Germans del pare',
            'Siblings of mother' => 'Germans de la mare',
            'Full siblings of biological parents' => 'Relaci&oacute; completa de germans dels pares biol&ograve;gics',
            'Siblings-in-law of father' => 'Germans pol&iacute;tics (cunyats pol&iacute;tics) del pare',
            'Siblings-in-law of mother' => 'Germans pol&iacute;tics (cunyats pol&iacute;tics) de la mare',
            'Biological parents' => 'Pares biol&ograve;gics',
            'Stepparents' => 'Padrastres',
            'Parents-in-law of biological children' => 'Sogres de fills/filles biol&ograve;gics',
            'Parents-in-law of stepchildren' => 'Consogres de fillastres',
            'Full siblings' => 'Tots els germans',
            'Half siblings' => 'Cunyats i cunyades',
            'Stepsiblings' => 'Germanastres',
            'Children of full siblings of father' => 'Cosins i cosines per part del pare',
            'Children of full siblings of mother' => 'Cosins i cosines per part de la mare',
            'Children of full siblings of parent' => 'Cosins i cosines per part dels pares',
            'Children of half siblings of father' => 'Fills de germanastres del pare del padre',
            'Children of half siblings of mother' => 'Fills de germanastres de la mare',
            'Children of half siblings of parent' => 'Fills de germanastres dels pares',
            'Siblings of partners' => 'Cunyat/cunyades del c&ograve;njuge',
            'Partners of siblings' => 'c&ograve;njuges dels germans/es ',
            'Siblings of siblings-in-law' => 'Concunyats/concunyades',
            'Partners of siblings-in-law' => 'Concunyats de cunyats i cunyades',
            'Children of full siblings of biological parents' => 'Relaci&oacute; de fills de germans de pares biol&ograve;gics ',
            'Children of siblings' => 'Fills de germans',
            'Children of full siblings' => 'Fills de germans majors',
            'Siblings\' stepchildren' => 'Fillastres de germans',
            'Children of siblings of partners' => 'Fills dels germans del c&ograve;njuge (Nebots)',
            'Biological children' => 'Fills biol&ograve;gics',
            'Stepchildren' => 'Fillastres',
            'Stepchild' => 'Fillastres',
            'Stepson' => 'Fillastre',
            'Stepdaughter' => 'Fillastra',
            'Partners of biological children' => 'c&ograve;njuge dels fills biol&ograve;gics (Gendre/Nora)',
            'Partners of stepchildren' => 'c&ograve;njuge de fillastres',
            'Biological grandchildren' => 'Nets biol&ograve;gics',
            'Stepchildren of children' => 'Fillastres',
            'Children of stepchildren' => 'Fills de fillastres',
            'Stepchildren of stepchildren' => 'Fillastre/a de fillastres',
            'Partners of biological grandchildren' => 'Parelles dels nets biol&ograve;gics',
            'Partners of stepchildren of children' => 'Parelles dels fills dels nets',
            'Partners of children of stepchildren' => 'Parelles dels fills dels fillastres',
            'Partners of stepchildren of stepchildren' => 'Parelles dels fillastres',

            'He' => 'ell',
            'She' => 'ella',
            'He/she' => 'Ell/ella',
            'Mr.' => 'Sr.',
            'Mrs.' => 'Sra.',
            'No family available' => 'No hi ha familia disponible',
            'Summary for the shown extended family' => 'Resum per a la familia extensa que es mostra',
            'The extended family of %1$s has one member.' . I18N::PLURAL . 'La familia extensa de %1$s té 2$d membres.'
            => 'La familia extensa de %1$s té 2$d membre.' . I18N::PLURAL . 'La familia extensa de %1$s t&eacute; 2$d membres.',
            '%s has no %s recorded.' => '%s no t&eacute; registrats.',
            '%s has no %s, and no %s recorded.' => '%s no t&eacute;cap %s ni cap %s registrats.',

            'Father\'s family (%d)' => 'familia del pare (%d)',
            'Mother\'s family (%d)' => 'familia de la mare (%d)',
            'Father\'s and Mother\'s family (%d)' => 'familia del pare y de la mare (%d)',
            'Grandparents %1$s (%2$s) of stepfather %3$s' => 'Avis %1$s (%2$s) del padrastre %3$s',
            'Grandparents %1$s (%2$s) of stepmother %3$s' => 'Avis %1$s (%2$s) de la madrastra %3$s',
            'Grandparents %1$s (%2$s) of stepparent %3$s' => 'Avis %1$s (%2$s) del padrastre %3$s',
            'Stepparents %1$s (%2$s) of %3$s' => 'Padrastres %1$s (%2$s) de %3$s',
            'Parents %1$s (%2$s) of stepfather %3$s' => 'Pares %1$s (%2$s) del padrastre %3$s',
            'Parents %1$s (%2$s) of stepmother %3$s' => 'Pares %1$s (%2$s) de la madrastra %3$s',
            'Parents %1$s (%2$s) of stepparent %3$s' => 'Pares %1$s (%2$s) del padrastre %3$s',
            'Parents %1$s of %2$s' => 'Pares %1$s de %2$s',
            'Parents %1$s (%2$s) of %3$s' => 'Pares %1$s (%2$s) de %3$s',
            'Partners of %s' => 'C򮹵ge de %s',
            'Brother %1$s of partner %2$s' => 'Germ&agrave; 1$s de c&ograve;njuge %2$s',
            'Sister %1$s of partner %2$s' => 'Germana %1$s de c&ograve;njuge %2$s',
            'Sibling %1$s of partner %2$s' => 'Germans %1$s de c&ograve;njuge %2$s',

            'Great-grandparents' => 'Besavis',
            '%s has no great-grandparents recorded.' => '%s no té besavis registrats.',
            '%s has one great-grandmother recorded.' => '%s t&eacute; una bes&agrave;via registrada',
            '%s has one great-grandfather recorded.' => '%s t&eacute; un besavi registrat.',
            '%s has one great-grandparent of unknown sex recorded.' => '%s t&eacute; un/a besavi/bes&agrave;via registrat/registrada.',
            '%2$s has %1$d great-grandmother recorded.' . I18N::PLURAL . '%2$s t&eacute; %1$d bes&agrave;vies registrades.'
            => '%2$s t&eacute; %1$d bes&agrave;via.' . I18N::PLURAL . '%2$s t&eacute; %1$d bes&agrave;vies registrades.',
            '%2$s has %1$d great-grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandfathers recorded.'
            => '%2$s t&eacute; %1$d besavi registrat.' . I18N::PLURAL . '%2$s t&eacute; %1$d besavis registrats.',
            '%2$s has %1$d great-grandparent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandparents of unknown sex recorded.'
            => '%2$s t&eacute; %1$d besavi/bes&agrave;via registrat/da.' . I18N::PLURAL . '%2$s t&eacute; %1$d besavis/es registrats/des.',
            '%2$s has %1$d great-grandfather and ' . I18N::PLURAL . '%2$s has %1$d great-grandfathers and '
            => '%2$s t&eacute; %1$d besavi i ' . I18N::PLURAL . '%2$s t&eacute; %1$d besavis i ',
            '%d great-grandmother recorded (%d in total).' . I18N::PLURAL . '%d great-grandmothers recorded (%d in total).'
            => '%d bes&agrave;via resgistrat/da (%d del total).' . I18N::PLURAL . '%d bes&agrave;vies registrades (%d del total).',
            '%2$s has %1$d great-grandmother and ' . I18N::PLURAL . '%2$s has %1$d great-grandmothers and '
            => '%2$s t&eacute; %1$d bes&agrave;via i ' . I18N::PLURAL . '%2$s t&eacute; %1$d bes&agrave;vies i ',
            '%d great-grandparent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d great-grandparents of unknown sex recorded (%d in total).'
            => '%d t&eacute; besavi/bes&agrave;via (%d en total).' . I18N::PLURAL . '%d son besavis/es registrats(%d en total).',
            '%2$s has %1$d great-grandfather, ' . I18N::PLURAL . '%2$s has %1$d great-grandfathers, '
            => '%2$s t&eacute; %1$d besavi, ' . I18N::PLURAL . '%2$s t&eacute; %1$d besavis, ',
            '%d great-grandmother, and ' . I18N::PLURAL . '%d great-grandmothers, and '
            => '%d t&eacute;bes&agrave;via i ' . I18N::PLURAL . '%d son los besavis i ',

            'Grandparents' => 'Avis',
            '%s has no grandparents recorded.' => '%s no té avis registrats.',
            '%s has one grandmother recorded.' => '%s t&eacute; uºna &agrave;via registrada.',
            '%s has one grandfather recorded.' => '%s t&eacute; un avi registrat.',
            '%s has one grandparent of unknown sex recorded.' => '%s t&eacute; registrat un avi/a.',
            '%2$s has %1$d grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d grandmothers recorded.'
            => '%2$s t&eacute; %1$d  &agrave;via registrada.' . I18N::PLURAL . '%2$s t&eacute; %1$d &agrave;vies registrades.',
            '%2$s has %1$d grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d grandfathers recorded.'
            => '%2$s t&eacute; %1$d avi registrat.' . I18N::PLURAL . '%2$s t&eacute; %1$d avis registrats.',
            '%2$s has %1$d grandparent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandparents of unknown sex recorded.'
            => '%2$s t&eacute; %1$d avi/a.' . I18N::PLURAL . '%2$s t&eacute; %1$d avis/&agrave;vies registrats/registrades.',
            '%2$s has %1$d grandfather and ' . I18N::PLURAL . '%2$s has %1$d grandfathers and '
            => '%2$s t&eacute; %1$d avi i ' . I18N::PLURAL . '%2$s t&eacute; %1$d avis i ',
            '%d grandmother recorded (%d in total).' . I18N::PLURAL . '%d grandmothers recorded (%d in total).'
            => '%d  &agrave;via registrada (%d en total).' . I18N::PLURAL . '%d &agrave;vies registrades (%d en total).',
            '%2$s has %1$d grandmother and ' . I18N::PLURAL . '%2$s has %1$d grandmothers and '
            => '%2$s t&eacute; %1$d  &agrave;via i ' . I18N::PLURAL . '%2$s son %1$d &agrave;vies i ',
            '%d grandparent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandparents of unknown sex recorded (%d in total).'
            => '%d avi/a registrats (%d en total).' . I18N::PLURAL . '%d avis/&agrave;vies registrats/registrades (%d en total).',
            '%2$s has %1$d grandfather, ' . I18N::PLURAL . '%2$s has %1$d grandfathers, '
            => '%2$s t&eacute; %1$d avi, ' . I18N::PLURAL . '%2$s t&eacute; %1$d avis, ',
            '%d grandmother, and ' . I18N::PLURAL . '%d grandmothers, and '
            => '%d  &agrave;via i ' . I18N::PLURAL . '%d &agrave;vies i ',

            'Uncles and Aunts' => 'Oncles i Ties',
            '%s has no uncles or aunts recorded.' => '%s no t&eacute; oncles registrats.',
            '%s has one aunt recorded.' => '%s t&eacute; una tia registrada.',
            '%s has one uncle recorded.' => '%s t&eacute; un oncle registrat.',
            '%s has one uncle or aunt of unknown sex recorded.' => '%s t&eacute; un oncle o tia registrat/da.',
            '%2$s has %1$d aunt recorded.' . I18N::PLURAL . '%2$s has %1$d aunts recorded.'
            => '%2$s t&eacute; %1$d tia registrada.' . I18N::PLURAL . '%2$s t&eacute; %1$d ties registrades.',
            '%2$s has %1$d uncle recorded.' . I18N::PLURAL . '%2$s has %1$d uncles recorded.'
            => '%2$s t&eacute; %1$d oncle registrat.' . I18N::PLURAL . '%2$s t&eacute; %1$d oncles registrats.',
            '%2$s has %1$d uncle or aunt of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d uncles or aunts of unknown sex recorded.'
            => '%2$s t&eacute;%1$d  tia registrat/a.' . I18N::PLURAL . '%2$s t&eacute; %1$d oncles/ties registrats/registrades.',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and '
            => '%2$s t&eacute; %1$d oncle i ' . I18N::PLURAL . '%2$s t&eacute; %1$d oncles i ',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).'
            => '%d tia registrada (%d en total).' . I18N::PLURAL . '%d ties registrades (%d en total).',
            '%2$s has %1$d aunt and ' . I18N::PLURAL . '%2$s has %1$d aunts and '
            => '%2$s t&eacute; %1$d tia i ' . I18N::PLURAL . '%2$s t&eacute; %1$d ties i ',
            '%d uncle or aunt of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d uncles or aunts of unknown sex recorded (%d in total).'
            => '%d oncle/tia registrat/registrada (%d en total).' . I18N::PLURAL . '%d oncles/ties registrats/registrades(%d en total).',
            '%2$s has %1$d uncle, ' . I18N::PLURAL . '%2$s has %1$d uncles, '
            => '%2$s t&eacute; %1$d oncle' . I18N::PLURAL . '%2$s t&eacute; %1$d oncles ',
            '%d aunt, and ' . I18N::PLURAL . '%d aunts, and '
            => '%d tia i ' . I18N::PLURAL . '%d ties i',

            'Uncles and Aunts by marriage' => 'Oncles i Ties pol&iacute;tics/ques',
            '%s has no uncles or aunts by marriage recorded.' => '%s no t&eacute; oncles ni ties pol&iacute;tics/ques registrats/des.',
            '%s has one aunt by marriage recorded.' => '%s t&eacute; una tia pol&iacute;tica registrada.',
            '%s has one uncle by marriage recorded.' => '%s t&eacute; un oncle pol&iacute;tic registrat.',
            '%s has one uncle or aunt by marriage of unknown sex recorded.' => '%s t&eacute; un oncle o tia pol&iacute;ticc/a registrat/da.',
            '%2$s has %1$d aunt by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d aunts by marriage recorded.'
            => '%2$s t&eacute; %1$d tia pol&iacute;tica registrada.' . I18N::PLURAL . '%2$s t&eacute; %1$d ties pol&iacute;tiques registrades.',
            '%2$s has %1$d uncle by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d uncles by marriage recorded.'
            => '%2$s t&eacute; %1$d oncle pol&iacute;tic registrat.' . I18N::PLURAL . '%2$s t&eacute; %1$d oncles pol&iacute;tics registrats.',
            '%2$s has %1$d uncle or aunt by marriage of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d uncles or aunts by marriage of unknown sex recorded.'
            => '%2$s t&eacute; %1$d oncle o tia pol&iacute;tica.' . I18N::PLURAL . '%2$s t&eacute; %1$d oncles o ties pol&iacute;tics/ques registrats.',
            '%2$s has %1$d uncle by marriage and ' . I18N::PLURAL . '%2$s has %1$d uncles by marriage and '
            => '%2$s t&eacute; %1$d oncle pol&iacute;tic i ' . I18N::PLURAL . '%2$s t&eacute; %1$d oncles pol&iacute;tics i ',
            '%d aunt by marriage recorded (%d in total).' . I18N::PLURAL . '%d aunts by marriage recorded (%d in total).'
            => '%d tia pol&iacute;tica registrada (%d en total).' . I18N::PLURAL . '%d ties pol&iacute;tiques registrades (%d en total).',
            '%2$s has %1$d aunt by marriage and ' . I18N::PLURAL . '%2$s has %1$d aunts by marriage and '
            => '%2$s t&eacute; %1$d tia pol&iacute;tica i ' . I18N::PLURAL . '%2$s t&eacute; %1$d ties pol&iacute;tiques i ',
            '%d uncle or aunt by marriage of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d uncles or aunts by marriage of unknown sex recorded (%d in total).'
            => '%d oncle o tia pol&iacute;tica registrats (%d en total).' . I18N::PLURAL . '%d oncles o ties pol&iacute;tiques resgistrades (%d en total).',
            '%2$s has %1$d uncle by marriage, ' . I18N::PLURAL . '%2$s has %1$d uncles by marriage, '
            => '%2$s t&eacute; %1$d oncle pol&iacute;tic, ' . I18N::PLURAL . '%2$s t&eacute; %1$d oncles pol&iacute;tics ',
            '%d aunt by marriage, and ' . I18N::PLURAL . '%d aunts by marriage, and '
            => '%d tia pol&iacute;tica i ' . I18N::PLURAL . '%d ties pol&iacute;tiques i  ',

            'Parents' => 'Pares i Mares',
            '%s has no parents recorded.' => '%s no t&eacute; pares registrats.',
            '%s has one mother recorded.' => '%s t&eacute; una mare registrada.',
            '%s has one father recorded.' => '%s t&eacute; un pare registrat.',
            '%s has one parent of unknown sex recorded.' => 't&eacute; registrat un progenitor/a.',
            '%2$s has %1$d mother recorded.' . I18N::PLURAL . '%2$s has %1$d mothers recorded.'
            => '%2$s t&eacute; %1$d mare registrada.' . I18N::PLURAL . '%2$s t&eacute; %1$d mares registradas.',
            '%2$s has %1$d father recorded.' . I18N::PLURAL . '%2$s has %1$d fathers recorded.'
            => '%2$s t&eacute; %1$d pare registrat.' . I18N::PLURAL . '%2$s t&eacute; %1$d pares registrats.',
            '%2$s has %1$d parent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d parents of unknown sex recorded.'
            => '%2$s t&eacute; %1$d pare/mare registrat/da.' . I18N::PLURAL . '%2$s t&eacute; %1$d pares/mares registrats/registrades.',
            '%2$s has %1$d father and ' . I18N::PLURAL . '%2$s has %1$d fathers and '
            => '%2$s t&eacute; %1$d pare i ' . I18N::PLURAL . '%2$s t&eacute; %1$d pares i ',
            '%d mother recorded (%d in total).' . I18N::PLURAL . '%d mothers recorded (%d in total).'
            => '%d mare registrats (%d en total).' . I18N::PLURAL . '%d mares registrades (%d en total).',
            '%2$s has %1$d mother and ' . I18N::PLURAL . '%2$s has %1$d mothers and '
            => '%2$s t&eacute; %1$d mare i ' . I18N::PLURAL . '%2$s t&eacute; %1$d mares i ',
            '%d parent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d parents of unknown sex recorded (%d in total).'
            => '%d pare/mare registrat/da (%d en total).' . I18N::PLURAL . '%d pares/mares registrats/registrades (%d en total).',
            '%2$s has %1$d father, ' . I18N::PLURAL . '%2$s has %1$d fathers, '
            => '%2$s t&eacute; %1$d pare, ' . I18N::PLURAL . '%2$s t&eacute; %1$d pares, ',
            '%d mother, and ' . I18N::PLURAL . '%d mothers, and '
            => '%d la mare i ' . I18N::PLURAL . '%d las mares i ',

            'Parents-in-law' => 'Sogres',
            '%s has no parents-in-law recorded.' => '%s no t&eacute; sogres registrats.',
            '%s has one mother-in-law recorded.' => '%s t&eacute; una sogra registrada.',
            '%s has one father-in-law recorded.' => '%s t&eacute; un sogre registrat.',
            '%s has one parent-in-law of unknown sex recorded.' => '%s t&eacute; un sogre/a registrat/da.',
            '%2$s has %1$d mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d mothers-in-law recorded.'
            => '%2$s t&eacute; %1$d sogra registrada.' . I18N::PLURAL . '%2$s t&eacute; %1$d sogres registrades.',
            '%2$s has %1$d father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d fathers-in-law recorded.'
            => '%2$s t&eacute; %1$d sogre registrat.' . I18N::PLURAL . '%2$s t&eacute; %1$d sogres registrats.',
            '%2$s has %1$d parent-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d parents-in-law of unknown sex recorded.'
            => '%2$s t&eacute; %1$d sogre/a registrat/da.' . I18N::PLURAL . '%2$s t&eacute; %1$d sogres registrats/registrades.',
            '%2$s has %1$d father-in-law and ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law and '
            => '%2$s t&eacute; %1$d sogre i ' . I18N::PLURAL . '%2$s t&eacute; %1$d sogres i ',
            '%d mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d mothers-in-law recorded (%d in total).'
            => '%d sogra registrats (%d en total).' . I18N::PLURAL . '%d sogres registrades (%d en total).',
            '%2$s has %1$d mother-in-law and ' . I18N::PLURAL . '%2$s has %1$d mothers-in-law and '
            => '%2$s t&eacute; %1$d sogra registrada i ' . I18N::PLURAL . '%2$s t&eacute; %1$d sogres i ',
            '%d parent-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d parents-in-law of unknown sex recorded (%d in total).'
            => '%d sogre/a registrat/da (%d en total).' . I18N::PLURAL . '%d sogres registrats/registrades (%d en total).',
            '%2$s has %1$d father-in-law, ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law, '
            => '%2$s t&eacute; %1$d sogre registrat, ' . I18N::PLURAL . '%2$s t&eacute; %1$d sogres registrats,',
            '%d mother-in-law, and ' . I18N::PLURAL . '%d mothers-in-law, and '
            => '%d es sogra i ' . I18N::PLURAL . '%d t&eacute; %1$d sogres i ',

            'Co-parents-in-law' => 'Consogres',
            '%s has no co-parents-in-law recorded.' => '%s no t&eacute; consogres registrats.',
            '%s has one co-mother-in-law recorded.' => '%s t&eacute; una consogra registrada.',
            '%s has one co-father-in-law recorded.' => '%s t&eacute; un consogre registrat.',
            '%s has one co-parent-in-law of unknown sex recorded.' => 't&eacute; registrat un consogre/a.',
            '%2$s has %1$d co-mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law recorded.'
            => '%2$s t&eacute; %1$d consogra registrada.' . I18N::PLURAL . '%2$s t&eacute; %1$d consogres registrats/des.',
            '%2$s has %1$d co-father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law recorded.'
            => '%2$s t&eacute; %1$d consogre registrat.' . I18N::PLURAL . '%2$s t&eacute; %1$d consogres registrats.',
            '%2$s has %1$d co-parent-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d co-parents-in-law of unknown sex recorded.'
            => '%2$s t&eacute; registrat %1$d consogre/a.' . I18N::PLURAL . '%2$s t&eacute; registrats %1$d consogres.',
            '%2$s has %1$d co-father-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law and '
            => '%2$s t&eacute; %1$d consogre i ' . I18N::PLURAL . '%2$s t&eacute; %1$d consogres i ',
            '%d co-mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-mothers-in-law recorded (%d in total).'
            => '%d consogra registrats (%d en total).' . I18N::PLURAL . '%d consogres registrades (%d en total).',
            '%2$s has %1$d co-mother-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law and '
            => '%2$s t&eacute; %1$d consogra i ' . I18N::PLURAL . '%2$s t&eacute; %1$d consogres i ',
            '%d co-parent-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d co-parents-in-law of unknown sex recorded (%d in total).'
            => '%d consogre/a registrat/da (%d en total).' . I18N::PLURAL . '%d consogres registrats(%d en total).',
            '%2$s has %1$d co-father-in-law, ' . I18N::PLURAL . '%2$ has %1$d co-fathers-in-law, '
            => '%2$s t&eacute; %1$d consogre, ' . I18N::PLURAL . '%2$s t&eacute; %1$d consogres, ',
            '%d co-mother-in-law, and ' . I18N::PLURAL . '%d co-mothers-in-law, and '
            => '%d consogra i ' . I18N::PLURAL . '%d consogres i ',

            'Partners' => 'C&ograve;njuge',
            'Partner of ' => 'C&ograve;njuge ',
            '%s has no partners recorded.' => '%s no t&eacute; c&ograve;njuge registrat.',
            '%s has one female partner recorded.' => '%s t&eacute; una c&ograve;njuge registrada.',
            '%s has one male partner recorded.' => '%s t&eacute; una c&ograve;njuge registrada.',
            '%s has one partner of unknown sex recorded.' => '%s t&eacute; registrada un c&ograve;njuge de sexe no identificat.',
            '%2$s has %1$d female partner recorded.' . I18N::PLURAL . '%2$s has %1$d female partners recorded.'
            => '%2$s t&eacute; %1$d c&ograve;njuge registrat.' . I18N::PLURAL . '%2$s t&eacute; %1$d conjugues registrats.',
            '%2$s has %1$d male partner recorded.' . I18N::PLURAL . '%2$s has %1$d male partners recorded.'
            => '%2$s t&eacute; %1$d c&ograve;njuge registrada.' . I18N::PLURAL . '%2$s t&eacute; %1$d conjugues registrades.',
            '%2$s has %1$d partner of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d partners of unknown sex recorded.'
            => '%2$s t&eacute; registrada a %1$d com a parella.' . I18N::PLURAL . '%2$s t&eacute; registradrs %1$d com a parelles.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and '
            => '%2$s t&eacute; %1$d c&ograve;njuge i ' . I18N::PLURAL . '%2$s t&eacute; %1$d conjugues i ',
            '%2$s has %1$d female partner and ' . I18N::PLURAL . '%2$s has %1$d female partners and '
            => '%2$s t&eacute; %1$d c&ograve;njuge i ' . I18N::PLURAL . '%2$s t&eacute; %1$d conjugues i ',
            '%d female partner recorded (%d in total).' . I18N::PLURAL . '%d female partners recorded (%d in total).'
            => '%d C&ograve;njuge registrada (%d en total).' . I18N::PLURAL . '%d conjugues registrades (%d en total).',
            '%2$s has %1$d partner and ' . I18N::PLURAL . '%2$s has %1$d partners and '
            => '%2$s t&eacute; %1$d c&ograve;njuge i ' . I18N::PLURAL . '%2$s t&eacute; %1$d conjugues i ',
            '%d male partner of female partners recorded (%d in total).' . I18N::PLURAL . '%d male partners of female partners recorded (%d in total).'
            => '%d c&ograve;njuge (amb sexe no identificat) registrat/da (%d en total).' . I18N::PLURAL . '%d conjugues registrats/registrades (%d en total).',
            '%d female partner of male partners recorded (%d in total).' . I18N::PLURAL . '%d female partners of male partners recorded (%d in total).'
            => '%d c&ograve;njuge (amb sexe no identificat) registrat (%d en total).' . I18N::PLURAL . '%d conjugues (amb sexes no identificats) registrats (%d en total).',

            'Partner chains' => 'Xarxa de membres familiars',
            '%s has no members of a partner chain recorded.' => '%s no t&eacute; registrats membres en la xarxa familiar.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and '
            => '%2$s t&eacute; %1$d com a parella masculina i ' . I18N::PLURAL . '%2$s t&eacute; %1$d com a parelles masculines i ',
            '%d female partner in this partner chain recorded (%d in total).' . I18N::PLURAL . '%d female partners in this partner chain recorded (%d in total).'
            => '%d t&eacute; parella femenina registrada (%d en total).' . I18N::PLURAL . '%d parelles femenines de parelles registrades (%d en total).',
            '%d female partner and ' . I18N::PLURAL . '%d female partners and '
            => '%d parella femenina i ' . I18N::PLURAL . '%d parelles femenines i ',
            '%d partner of unknown sex in this partner chain recorded (%d in total).' . I18N::PLURAL . '%d partners of unknown sex in this partner chain recorded (%d in total).'
            => '%d parella en aquesta xarxa de parelles registrades (%d).' . I18N::PLURAL . '%d parelles en aquesta xarxa de parelles registrades (%d en total).',
            '%2$s has %1$d female partner and ' . I18N::PLURAL . '%2$s has %1$d female partners and '
            => '%2$s t&eacute; %1$d parella femenina i ' . I18N::PLURAL . '%2$s t&eacute; %1$d parelles femenines i ',
            '%d partner of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d partners of unknown sex recorded (%d in total).'
            => '%d parella registrada (%d en total ).' . I18N::PLURAL . '%d parelles registrades (%d en total).',
            '%2$s has %1$d male partner, ' . I18N::PLURAL . '%2$s has %1$d male partners, '
            => '%2$s t&eacute; %1$d parella masculina, ' . I18N::PLURAL . '%2$s t&eacute; %1$d parelles masculines, ',
            '%d female partner, and ' . I18N::PLURAL . '%d female partners, and '
            => '%d parella femenina i ' . I18N::PLURAL . '%d parelles femenines i ',
            'There are %d branches in the partner chain. ' => 'Hi ha branques a la cadena de membres.',
            'The longest branch in the partner chain to %2$s consists of %1$d partners (including %3$s).' => 'Hi ha branques a la cadena de membres',
            'The longest branch in the partner chain consists of %1$d partners (including %2$s).' => 'La branca m&eacute;s llarga de la cadena de membres estࠦormada per %1$d individus (incloent %2$s)).',

            'Siblings' => 'Germans i Germanes',
            '%s has no siblings recorded.' => '%s no t&eacute; germans/es registrats/des.',
            '%s has one sister recorded.' => '%s t&eacute; una germana registrada.',
            '%s has one brother recorded.' => '%s t&eacute; un  germ&agrave; registrat.',
            '%s has one sibling of unknown sex recorded.' => '%s t&eacute; un/a germ&agrave;/na registrats/des',
            '%2$s has %1$d sister recorded.' . I18N::PLURAL . '%2$s has %1$d sisters recorded.'
            => '%2$s t&eacute; %1$d germana registrada.' . I18N::PLURAL . '%2$s t&eacute; %1$d germanes registrades.',
            '%2$s has %1$d brother recorded.' . I18N::PLURAL . '%2$s has %1$d brothers recorded.'
            => '%2$s t&eacute; %1$d germ&agrave; registrat.' . I18N::PLURAL . '%2$s t&eacute; %1$d germans registrats.',
            '%2$s has %1$d sibling of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d siblings of unknown sex recorded.'
            => '%2$s t&eacute; %1$d de germ&agrave;/na.' . I18N::PLURAL . '%2$s t&eacute; %1$d germans/es registrats/des.',
            '%2$s has %1$d brother and ' . I18N::PLURAL . '%2$s has %1$d brothers and '
            => '%2$s t&eacute; %1$d germgerm&agrave; i ' . I18N::PLURAL . '%2$s t&eacute; %1$d germans i ',
            '%d sister recorded (%d in total).' . I18N::PLURAL . '%d sisters recorded (%d in total).'
            => '%d germana registrada (%d en total).' . I18N::PLURAL . '%d germanes registrades (%d en total).',
            '%2$s has %1$d sister and ' . I18N::PLURAL . '%2$s has %1$d sisters and '
            => '%2$s t&eacute; %1$d germana i ' . I18N::PLURAL . '%2$s t&eacute; %1$d germanes i ',
            '%d sibling of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d siblings of unknown sex recorded (%d in total).'
            => '%d germ&agrave;/na registrat/registrada (%d en total).' . I18N::PLURAL . '%d germans/nes registrats/des (%d en total).',
            '%2$s has %1$d brother, ' . I18N::PLURAL . '%2$s has %1$d brothers, '
            => '%2$s t&eacute; %1$d de germ&agrave;' . I18N::PLURAL . '%2$s t&eacute; %1$d germans, ',
            '%d sister, and ' . I18N::PLURAL . '%d sisters, and '
            => '%d germana i ' . I18N::PLURAL . '%d germanes i ',

            'Siblings-in-law' => 'Cunyats i Cunyades',
            '%s has no siblings-in-law recorded.' => '%s no t&eacute; cunyats/des registrats/des.',
            '%s has one sister-in-law recorded.' => '%s t&eacute; una cunyada registrada.',
            '%s has one brother-in-law recorded.' => '%s un cunyat registrat.',
            '%s has one sibling-in-law of unknown sex recorded.' => '%s t&eacute; un cunyat/da registrat/da.',
            '%2$s has %1$d sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sisters-in-law recorded.'
            => '%2$s t&eacute; %1$d cunyada registrada.' . I18N::PLURAL . '%2$s t&eacute; %1$d cumyades registrats.',
            '%2$s has %1$d brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d brothers-in-law recorded.'
            => '%2$s t&eacute; %1$d cunyat registrat.' . I18N::PLURAL . '%2$s t&eacute; %1$d cunyats registrats.',
            '%2$s has %1$d sibling-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d siblings-in-law of unknown sex recorded.'
            => '%2$s t&eacute; %1$d cunyat/da registrats.' . I18N::PLURAL . '%2$s t&eacute; %1$d cunyats/des registrats/des.',
            '%2$s has %1$d brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law and '
            => '%2$s t&eacute; %1$d cunyat i ' . I18N::PLURAL . '%2$s t&eacute; %1$d cunyats i ',
            '%d sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d sisters-in-law recorded (%d in total).'
            => '%d cunyada registrats (%d en total).' . I18N::PLURAL . '%d cunyades registrades (%d en total).',
            '%2$s has %1$d sister-in-law and ' . I18N::PLURAL . '%2$s has %1$d sisters-in-law and '
            => '%2$s t&eacute; %1$d cunyada i ' . I18N::PLURAL . '%2$s t&eacute; %1$d cunyades i ',
            '%d sibling-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d siblings-in-law of unknown sex recorded (%d in total).'
            => '%d cunyat/da registratats (%d en total).' . I18N::PLURAL . '%d cunyats/des registrats/des (%d en total).',
            '%2$s has %1$d brother-in-law, ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law, '
            => '%2$s t&eacute; %1$d cunyat, ' . I18N::PLURAL . '%2$s t&eacute; %1$d cunyats, ',
            '%d sister-in-law, and ' . I18N::PLURAL . '%d sisters-in-law, and '
            => '%d cunyada, i ' . I18N::PLURAL . '%d cunyades, i ',

            'Co-siblings-in-law' => 'Concunyats i Concunyades',
            '%s has no co-siblings-in-law recorded.' => '%s no t&eacute; concunyats/des registrats/des.',
            '%s has one co-sister-in-law recorded.' => '%s t&eacute; una concunyada registrada.',
            '%s has one co-brother-in-law recorded.' => '%s un concunyat registrat.',
            '%s has one co-sibling-in-law of unknown sex recorded.' => '%s t&eacute; un concunyat/ada registrat/da.',
            '%2$s has %1$d co-sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-sisters-in-law recorded.'
            => '%2$s t&eacute; %1$d concunyada registrada.' . I18N::PLURAL . '%2$s t&eacute; %1$d concunyades registrades.',
            '%2$s has %1$d co-brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law recorded.'
            => '%2$s t&eacute; %1$d concunyat registrat.' . I18N::PLURAL . '%2$s t&eacute; %1$d concunyats registrats.',
            '%2$s has %1$d co-sibling-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d co-siblings-in-law of unknown sex recorded.'
            => '%2$s t&eacute; %1$d concunyat/ada registrat.' . I18N::PLURAL . '%2$s t&eacute; %1$d concunyats/des registrats.',
            '%2$s has %1$d co-brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law and '
            => '%2$s t&eacute; %1$d concunyat i ' . I18N::PLURAL . '%2$s t&eacute; %1$d concunyats i ',
            '%d co-sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-sisters-in-law recorded (%d in total).'
            => '%d concunyada registrats (%d en total).' . I18N::PLURAL . '%d concunyades registrades (%d en total).',
            '%2$s has %1$d co-sister-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-sisters-in-law and '
            => '%2$s t&eacute; %1$d concunyada i ' . I18N::PLURAL . '%2$s t&eacute; %1$d concunyades i ',
            '%d co-sibling-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d co-siblings-in-law of unknown sex recorded (%d in total).'
            => '%d concunyat/ada registrat/ada (%d en total).' . I18N::PLURAL . '%d concunyats/des registrats/des (%d en total).',
            '%2$s has %1$d co-brother-in-law, ' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law, '
            => '%2$s t&eacute; %1$d concunyat, ' . I18N::PLURAL . '%2$s t&eacute; %1$d concunyats, ',
            '%d co-sister-in-law, and ' . I18N::PLURAL . '%d co-sisters-in-law, and '
            => '%d concunyada, i ' . I18N::PLURAL . '%d concunyades, i ',

            'Cousins' => 'Cosins i Cosines',
            '%s has no first cousins recorded.' => '%s no t&eacute; cosins ni cosines registrats/des.',
            '%s has one female first cousin recorded.' => '%s t&eacute; una cosina registrada.',
            '%s has one male first cousin recorded.' => '%s t&eacute; un cos&iacute; registrat.',
            '%s has one first cousin of unknown sex recorded.' => '%s t&eacute; un cos&iacute;/na registrat/ada.',
            '%2$s has %1$d female first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d female first cousins recorded.'
            => '%2$s t&eacute; %1$d cosina registrada.' . I18N::PLURAL . '%2$s t&eacute; %1$d cosines registrades.',
            '%2$s has %1$d male first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d male first cousins recorded.'
            => '%2$s t&eacute; %1$d cos&iacute; registrat.' . I18N::PLURAL . '%2$s t&eacute; %1$d cosins registrats.',
            '%2$s has %1$d first cousin of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d first cousins of unknown sex recorded.'
            => '%2$s t&eacute; registrat %1$d com cosina germ&agrave;/na.' . I18N::PLURAL . '%2$s t&eacute; registrats %1$d cosins/es germans/es',
            '%2$s has %1$d male first cousin and ' . I18N::PLURAL . '%2$s has %1$d male first cousins and '
            => '%2$s t&eacute; %1$d coscos&iacute;' . I18N::PLURAL . '%2$s t&eacute; %1$d cosins i ',
            '%d female first cousin recorded (%d in total).' . I18N::PLURAL . '%d female first cousins recorded (%d in total).'
            => '%d cosina registrats (%d en total).' . I18N::PLURAL . '%d cosines registrades (%d en total).',
            '%2$s has %1$d female first cousin and ' . I18N::PLURAL . '%2$s has %1$d female first cousins and '
            => '%2$s t&eacute; %1$d cosina germana i ' . I18N::PLURAL . '%2$s t&eacute; %1$d cosines germanes i ',
            '%d first cousin of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d first cousins of unknown sex recorded (%d in total).'
            => '%d cos&iacute;/na germ&agrave;/na registrat/rada(%d en total).' . I18N::PLURAL . '%d cosins/cosines germans/es registrats/des (%d en total).',
            '%2$s has %1$d male first cousin, ' . I18N::PLURAL . '%2$s has %1$d male first cousins, '
            => '%2$s t&eacute; %1$d coscos&iacute; germà ' . I18N::PLURAL . '%2$s t&eacute; %1$d cosins germans, ',
            '%d female first cousin, and ' . I18N::PLURAL . '%d female first cousins, and '
            => '%d cosina germana, i ' . I18N::PLURAL . '%d cosines germanes, i ',

            'Nephews and Nieces' => 'Nebots i Nebodes',
            '%s has no nephews or nieces recorded.' => '%s no t&eacute;nebots ni nebodes registrats/des.',
            '%s has one niece recorded.' => '%s t&eacute; una neboda registrada.',
            '%s has one nephew recorded.' => '%s t&eacute;un nebot registrat.',
            '%s has one nephew or niece of unknown sex recorded.' => '%s t&eacute; una nebot/da registrat/da.',
            '%2$s has %1$d niece recorded.' . I18N::PLURAL . '%2$s has %1$d nieces recorded.'
            => '%2$s t&eacute; %1$d neboda registrada.' . I18N::PLURAL . '%2$s t&eacute; %1$d nebodes registradas.',
            '%2$s has %1$d nephew recorded.' . I18N::PLURAL . '%2$s has %1$d nephews recorded.'
            => '%2$s t&eacute; %1$d nebot registrat.' . I18N::PLURAL . '%2$s t&eacute; %1$d nebots registrats.',
            '%2$s has %1$d nephew or niece of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d nephews or nieces of unknown sex recorded.'
            => '%2$s t&eacute; %1$d nebot/da.' . I18N::PLURAL . '%2$s t&eacute; %1$d nebots/des registrats.',
            '%2$s has %1$d nephew and ' . I18N::PLURAL . '%2$s has %1$d nephews and '
            => '%2$s t&eacute; %1$d nebot i ' . I18N::PLURAL . '%2$s t&eacute; %1$d nebots i ',
            '%d niece recorded (%d in total).' . I18N::PLURAL . '%d nieces recorded (%d in total).'
            => '%d neboda registrats (%d en total).' . I18N::PLURAL . '%d nebodes registrades (%d en total).',
            '%2$s has %1$d niece and ' . I18N::PLURAL . '%2$s has %1$d nieces and '
            => '%2$s t&eacute; %1$d neboda i ' . I18N::PLURAL . '%2$s t&eacute; %1$d nebodes i ',
            '%d nephew or niece of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d nephews or nieces of unknown sex recorded (%d in total).'
            => '%d nebot/da registrats (%d en total).' . I18N::PLURAL . '%d nebots/des registrades (%d en total).',
            '%2$s has %1$d nephew, ' . I18N::PLURAL . '%2$s has %1$d nephews, '
            => '%2$s t&eacute; %1$d nebot, ' . I18N::PLURAL . '%2$s t&eacute; %1$d nebots, ',
            '%d niece, and ' . I18N::PLURAL . '%d nieces, and '
            => '%d neboda, i ' . I18N::PLURAL . '%d nebodes, i ',

            'Children' => 'Fills i Filles',
            '%s has no children recorded.' => '%s no t&eacute; fills registrats.',
            '%s has one daughter recorded.' => '%s t&eacute; una filla registrada.',
            '%s has one son recorded.' => '%s t&eacute; un fill registrat.',
            '%s has one child of unknown sex recorded.' => '%s t&eacute; un fill/a registrat/ada.',
            '%2$s has %1$d daughter recorded.' . I18N::PLURAL . '%2$s has %1$d daughters recorded.'
            => '%2$s t&eacute; %1$d filla registrada.' . I18N::PLURAL . '%2$s t&eacute; %1$d filles registrades.',
            '%2$s has %1$d son recorded.' . I18N::PLURAL . '%2$s has %1$d sons recorded.'
            => '%2$s t&eacute; %1$d fill registrat.' . I18N::PLURAL . '%2$s t&eacute; %1$d fills registrats.',
            '%2$s has %1$d child of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d children of unknown sex recorded.'
            => '%2$s t&eacute; %1$d fill/a.' . I18N::PLURAL . '%2$s t&eacute; %1$d fills/es registrats/registrades.',
            '%2$s has %1$d son and ' . I18N::PLURAL . '%2$s has %1$d sons and '
            => '%2$s t&eacute; %1$d fill i ' . I18N::PLURAL . '%2$s t&eacute; %1$d fills i ',
            '%d daughter recorded (%d in total).' . I18N::PLURAL . '%d daughters recorded (%d in total).'
            => '%d filla registrats (%d en total).' . I18N::PLURAL . '%d filles registrades (%d en total).',
            '%2$s has %1$d daughter and ' . I18N::PLURAL . '%2$s has %1$d daughters and '
            => '%2$s tine %1$d filla i ' . I18N::PLURAL . '%2$s t&eacute; %1$d filles i ',
            '%d child of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d children of unknown sex recorded (%d in total).'
            => '%d xiquet/a registrat/ada (%d en total).' . I18N::PLURAL . '%d xiquets/tes registrats/des (%d en total).',
            '%2$s has %1$d son, ' . I18N::PLURAL . '%2$s has %1$d sons, '
            => '%2$s t&eacute; %1$d fill, ' . I18N::PLURAL . '%2$s t&eacute; %1$d fills, ',
            '%d daughter, and ' . I18N::PLURAL . '%d daughters, and '
            => '%d filla, i ' . I18N::PLURAL . '%d filles, i ',

            'Children-in-law' => 'fills pol&iacute;tics',
            '%s has no children-in-law recorded.' => '%s no t&eacute; fills pol&iacute;tics registrats.',
            '%s has one daughter-in-law recorded.' => '%s t&eacute; una filla pol&iacute;tica registrada.',
            '%s has one son-in-law recorded.' => '%s t&eacute; un fill pol&iacute;tic registrat.',
            '%s has one child-in-law of unknown sex recorded.' => '%s t&eacute; un fill/a pol&iacute;tic/a registrat/da.',
            '%2$s has %1$d daughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d daughters-in-law recorded.'
            => '%2$s t&eacute; %1$d filla pol&iacute;tica registrada.' . I18N::PLURAL . '%2$s t&eacute; %1$d filles pol&iacute;tiques registrades.',
            '%2$s has %1$d son-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sons-in-law recorded.'
            => '%2$s tine %1$d fill pol&iacute;tic registrat.' . I18N::PLURAL . '%2$s tine %1$d fills pol&iacute;tics registrats.',
            '%2$s has %1$d child-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d children-in-law recorded.'
            => '%2$s t&eacute; %1$d fill/a pol&iacute;tic/a registrat/da.' . I18N::PLURAL . '%2$s t&eacute; %1$d fills/es pol&iacute;tics/ques registrats/des.',
            '%2$s has %1$d son-in-law and ' . I18N::PLURAL . '%2$s has %1$d sons-in-law and '
            => '%2$s t&eacute; %1$d fill pol&iacute;tic i ' . I18N::PLURAL . '%2$s t&eacute; %1$d fills pol&iacute;tics i ',
            '%d daughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d daughters-in-law recorded (%d in total).'
            => '%d filla pol&iacute;tica registrada (%d en total).' . I18N::PLURAL . '%d filles pol&iacute;tiques registrades (%d en total).',
            '%2$s has %1$d daughter-in-law and ' . I18N::PLURAL . '%2$s has %1$d daughters-in-law and '
            => '%2$s t&eacute; %1$d nora i ' . I18N::PLURAL . '%2$s t&eacute; %1$d nores i ',
            '%d child-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d children-in-law of unknown sex recorded (%d in total).'
            => '%d gendre/nora registrat/da (%d en total).' . I18N::PLURAL . '%d gendres/nores registrats/des (%d en total).',
            '%2$s has %1$d son-in-law, ' . I18N::PLURAL . '%2$s has %1$d sons-in-law, '
            => '%2$s es %1$d gendre, ' . I18N::PLURAL . '%2$s son %1$d gendres, ',
            '%d daughter-in-law, and ' . I18N::PLURAL . '%d daughters-in-law, and '
            => '%d n nora i ' . I18N::PLURAL . '%d nores i ',

            'Grandchildren' => 'Nets i Netes',
            '%s has no grandchildren recorded.' => '%s no t&eacute; nets registrats.',
            '%s has one granddaughter recorded.' => '%s t&eacute; una neta registrada.',
            '%s has one grandson recorded.' => '%s t&eacute; un net registrat.',
            '%s has one grandchild of unknown sex recorded.' => '%s t&eacute; un net o neta registrat/registrada.',
            '%2$s has %1$d granddaughter recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters recorded.'
            => '%2$s ist %1$d neta registrada.' . I18N::PLURAL . '%2$s t&eacute; %1$d netes registrades.',
            '%2$s has %1$d grandson recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons recorded.'
            => '%2$s ist %1$d net registrat.' . I18N::PLURAL . '%2$s t&eacute; %1$d nets registrats.',
            '%2$s has %1$d grandchild of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandchildren of unknown sex recorded.'
            => '%2$s t&eacute; %1$d net/a registratregistrada.' . I18N::PLURAL . '%2$s t&eacute; %1$d nets/netes registrats/registrades.',
            '%2$s has %1$d grandson and ' . I18N::PLURAL . '%2$s has %1$d grandsons and '
            => '%2$s t&eacute; %1$d net i ' . I18N::PLURAL . '%2$s t&eacute; %1$d nets i ',
            '%d granddaughter recorded (%d in total).' . I18N::PLURAL . '%d granddaughters recorded (%d in total).'
            => '%d neta registrada (%d en total).' . I18N::PLURAL . '%d netes registrades (%d en total).',
            '%2$s has %1$d granddaughter and ' . I18N::PLURAL . '%2$s has %1$d granddaughters and '
            => '%2$s t&eacute; %1$d neta i ' . I18N::PLURAL . '%2$s t&eacute; %1$d netes i ',
            '%d grandchild of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandchildren of unknown sex recorded (%d in total).'
            => '%d net/a registrat/registrada (%d en total).' . I18N::PLURAL . '%d nets/netes registrats/registrades (%d en total).',
            '%2$s has %1$d grandson, ' . I18N::PLURAL . '%2$s has %1$d grandsons, '
            => '%2$s t&eacute; %1$d net, ' . I18N::PLURAL . '%2$s t&eacute; %1$d nets, ',
            '%d granddaughter, and ' . I18N::PLURAL . '%d granddaughters, and '
            => '%d neta i ' . I18N::PLURAL . '%d netes i ',

            'Grandchildren-in-law' => 'nets/es pol&iacute;tics/ques',
            '%s has no grandchildren-in-law recorded.' => '%s no apareixen nets pol&iacute;tics.',
            '%s has one granddaughter-in-law recorded.' => '%s neta política registrada.',
            '%s has one grandson-in-law recorded.' => '%s t&eacute; registrat un net polític.',
            '%s has one grandchild-in-law of unknown sex recorded.' => '%s net/a polític/a registrat/da.',
            '%2$s has %1$d granddaughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters-in-law recorded.'
            => '%2$s t&eacute; %1$d neta política registrada.' . I18N::PLURAL . '%2$s t&eacute; %1$d netes pol&iacute;tiques registrats.',
            '%2$s has %1$d grandson-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons-in-law recorded.'
            => '%2$s t&eacute; %1$d net pol&iacute;tic registrat.' . I18N::PLURAL . '%2$s t&eacute; %1$d nets pol&iacute;tics registrats.',
            '%2$s has %1$d grandchild-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandchildren-in-law of unknown sex recorded.'
            => '%2$s t&eacute; %1$d net/a pol&iacute;tic/a registrat/registrada.' . I18N::PLURAL . '%2$s t&eacute; %1$d nets/es pol&iacute;tics/ques registrats/des.',
            '%2$s has %1$d grandson-in-law and ' . I18N::PLURAL . '%2$s has %1$d grandsons-in-law and '
            => '%2$s t&eacute; %1$d net pol&iacute;tic i ' . I18N::PLURAL . '%2$s t&eacute; %1$d nets pol&iacute;tics i ',
            '%d granddaughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d granddaughters-in-law recorded (%d in total).'
            => '%d neta pol&iacute;tica registrada (%d en total).' . I18N::PLURAL . '%d netes polítiques registrades (%d en total).',
            '%2$s has %1$d granddaughter-in-law and ' . I18N::PLURAL . '%2$s has %1$d granddaughters-in-law and '
            => '%2$s t&eacute; %1$d neta pol&iacute;tica i ' . I18N::PLURAL . '%2$s t&eacute; %1$d netes pol&iacute;tiques i ',
            '%d grandchild-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandchildren-in-law of unknown sex recorded (%d in total).'
            => '%d net/neta pol&iacute;tic/a registrat/da (%d en total).' . I18N::PLURAL . '%d nets/es pol&iacute;cs/ques registrats/des (%d en total).',
            '%2$s has %1$d grandson-in-law, ' . I18N::PLURAL . '%2$s has %1$d grandsons-in-law, '
            => '%2$s t&eacute; %1$d net pol&iacute;tic, ' . I18N::PLURAL . '%2$s t&eacute; %1$d nets pol&iacute;cs, ',
            '%d granddaughter-in-law, and ' . I18N::PLURAL . '%d granddaughters-in-law, and '
            => '%d neta pol&iacute;tica i ' . I18N::PLURAL . '%d netes pol&iacute;tiques i ',
        ];
    }

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
            'Show parameters of extended family part?' => 'Mají se zobrazit parametry části širší rodiny?',
            'Display of additional information for each part of the extended family, such as the generation shift and the coefficient of relationship, which is a measure of the degree of consanguinity.' => 'Zobrazovat doplňující informace ke každé části širší rodiny, jako jsou posun generací a koeficient příbuznosti, který je mírou pokrevního příbuzenství.',
            'Show parameters' => 'Zobrazovat parametry',

            'generation +%s' => 'generace +%s',
            'same generation' => 'stejná generace',
            'generation %s' => 'generace %s',
            'relationship coefficient: %.1f' => 'Koeficient příbuznosti: %.1f',
            'no blood relationship' => 'nepokrevní příbuzenství',

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
            'Biological grandparents of father' => 'Vlastní prarodiče otce',
            'Biological grandparents of mother' => 'Vlastní prarodiče matky',
            'Biological grandparents of parent' => 'Vlastní prarodiče rodiče',
            'Stepparents of biological parent of father' => 'Nevlastní rodiče vlastního rodiče otce',
            'Stepparents of biological parent of mother' => 'Nevlastní rodiče vlastního rodiče matky',
            'Stepparents of biological grandparent' => 'Nevlastní rodiče vlastního prarodiče',
            'Parents of stepparent of father' => 'Rodiče nevlastního rodiče otce',
            'Parents of stepparent of mother' => 'Rodiče nevlastního rodiče matky',
            'Parents of stepparent of parent' => 'Rodiče nevlastního rodiče rodiče',
            'Grandparents of stepparent' => 'Prarodiče nevlastního rodiče',
            'Biological great-grandparents' => 'Vlastní praprarodiče',
            'Biological parents of father' => 'Vlastní rodiče otce',
            'Biological parents of mother' => 'Vlastní rodiče matky',
            'Biological parents of parent' => 'Vlastní rodiče jednoho z rodičů',
            'Stepparents of father' => 'Nevlastní rodiče otce',
            'Stepparents of mother' => 'Nevlastní rodiče matky',
            'Stepparents of parent' => 'Nevlastní rodiče rodiče',
            'Parents of stepparent' => 'Rodiče nevlastního rodiče',
            'Biological grandparents' => 'Vlastní prarodiče',
            'Siblings of father' => 'Sourozenci otce',
            'Siblings of mother' => 'Sourozenci matky',
            'Full siblings of biological parents' => 'Vlastní sourozenci vlastních rodičů',
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
            'Children of full siblings of biological parents' => 'Děti vlastních sourozenců vlastních rodičů',
            'Children of siblings' => 'Děti sourozenců',
            'Children of full siblings' => 'Děti vlastních sourozenců',
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
            '%s has no %s recorded.' => 'Pro osobu \'%s\' chybí záznamy %s.',
            '%s has no %s, and no %s recorded.' => 'Pro osobu \'%s\' chybí záznamy %s a %s.',
            'Summary for the shown extended family' => 'Summary for the shown extended family',
            'The extended family of %1$s has one member.' . I18N::PLURAL . 'The extended family of %1$s has %2$d members.'
            => 'The extended family of %1$s has one member.' . I18N::PLURAL . 'The extended family of %1$s has %2$d members.',

            'Father\'s family (%d)' => 'Otcova rodina (%d)',
            'Mother\'s family (%d)' => 'Matčina rodina (%d)',
            'Father\'s and Mother\'s family (%d)' => 'Otcova a matčina rodina (%d)',
            'Grandparents %1$s (%2$s) of stepfather %3$s' => 'Prarodiče %1$s (%2$s) nevlastního otce %3$s',
            'Grandparents %1$s (%2$s) of stepmother %3$s' => 'Prarodiče %1$s (%2$s) nevlastní matky %3$s',
            'Grandparents %1$s (%2$s) of stepparent %3$s' => 'Prarodiče %1$s (%2$s) nevlastního rodiče %3$s',
            'Stepparents %1$s (%2$s) of %3$s' => 'Nevlastní rodiče %1$s (%2$s) osoby \'%3$s\'',
            'Parents %1$s (%2$s) of stepfather %3$s' => 'Rodiče %1$s (%2$s) nevlastního otce %3$s',
            'Parents %1$s (%2$s) of stepmother %3$s' => 'Rodiče %1$s (%2$s) nevlastní matky %3$s',
            'Parents %1$s (%2$s) of stepparent %3$s' => 'Rodiče %1$s (%2$s) nevlastního rodiče %3$s',
            'Parents %1$s of %2$s' => 'Rodiče %1$s osoby \'%2$s\'',
            'Parents %1$s (%2$s) of %3$s' => 'Rodiče %1$s (%2$s) osoby \'%3$s\'',
            'Partners of %s' => 'Partneři osoby \'%s\'',
            'Brother %1$s of partner %2$s' => 'Bratr %1$s partnera %2$s',
            'Sister %1$s of partner %2$s' => 'Sestra %1$s partnera %2$s',
            'Sibling %1$s of partner %2$s' => 'Sourozenec %1$s partnera %2$s',

            'Great-grandparents' => 'Praprarodiče',
            '%s has no great-grandparents recorded.' => '%s nemá zaznamenané žádné praprarodiče.',
            '%s has one great-grandmother recorded.' => '%s má zaznamenanou jednu prabábu.',
            '%s has one great-grandfather recorded.' => '%s má zaznamenaného jednoho praděda.',
            '%s has one great-grandparent of unknown sex recorded.' => '%s má zaznamenaného jednoho praprarodiče neznámého pohlaví.',
            '%2$s has %1$d great-grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandmothers recorded.'
                => '%2$s má zaznamenanou %1$d prabábu.' . I18N::PLURAL . '%2$s má zaznamenané %1$d prabáby.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d prabab.',
            '%2$s has %1$d great-grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandfathers recorded.'
                => '%2$s má zaznamenaného %1$d praděda.' . I18N::PLURAL . '%2$s má zaznamenané %1$d pradědy.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d pradědů.',
            '%2$s has %1$d great-grandparent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandparents of unknown sex recorded.'
                => '%2$s má zaznamenaného %1$d praprarodiče neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenané %1$d praprarodiče neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d praprarodičú neznámého pohlaví.',
            '%2$s has %1$d great-grandfather and ' . I18N::PLURAL . '%2$s has %1$d great-grandfathers and '
                => '%2$s má zaznamenaného %1$d praděda a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d pradědy a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d pradědů a ',
            '%d great-grandmother recorded (%d in total).' . I18N::PLURAL . '%d great-grandmothers recorded (%d in total).'
                => '%d prabábu (celkem %d).' . I18N::PLURAL . '%d prabáby (celkem %d).' . I18N::PLURAL . '%d prabab (celkem %d).',
            '%2$s has %1$d great-grandmother and ' . I18N::PLURAL . '%2$s has %1$d great-grandmothers and '
                => '%2$s má zaznamenanou %1$d prabábu a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d prabáby a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d prabab a ',
            '%d great-grandparent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d great-grandparents of unknown sex recorded (%d in total).'
                => '%d praprarodiče neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d praprarodiče neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d praprarodičů neznámého pohlaví (celkem %d).',
            '%2$s has %1$d great-grandfather, ' . I18N::PLURAL . '%2$s has %1$d great-grandfathers, '
                => '%2$s má %1$d praděda, ' . I18N::PLURAL . '%2$s má %1$d pradědy, ' . I18N::PLURAL . '%2$s má %1$d pradědů, ',
            '%d great-grandmother, and ' . I18N::PLURAL . '%d great-grandmothers, and '
                => '%d prabábu, a ' . I18N::PLURAL . '%d prabáby, a ' . I18N::PLURAL . '%d prabab, a ',

            'Grandparents' => 'Prarodiče',
            '%s has no grandparents recorded.' => '%s nemá zaznamenané žádné prarodiče.',
            '%s has one grandmother recorded.' => '%s má zaznamenanou jednu bábu.',
            '%s has one grandfather recorded.' => '%s má zaznamenaného jednoho děda.',
            '%s has one grandparent of unknown sex recorded.' => '%s má zaznamenaného jednoho prarodiče neznámého pohlaví.',
            '%2$s has %1$d grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d grandmothers recorded.' => '%2$s má zaznamenanou %1$d bábu.' . I18N::PLURAL . '%2$s má zaznamenané %1$d báby.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d bab.',
            '%2$s has %1$d grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d grandfathers recorded.'
                => '%2$s má zaznamenaného %1$d děda.' . I18N::PLURAL . '%2$s má zaznamenané %1$d dědy.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d dědů.',
            '%2$s has %1$d grandparent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandparents of unknown sex recorded.'
                => '%2$s má zaznamenaného %1$d prarodiče neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenané %1$d prarodiče neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d prarodičú neznámého pohlaví.',
            '%2$s has %1$d grandfather and ' . I18N::PLURAL . '%2$s has %1$d grandfathers and '
                => '%2$s má zaznamenaného %1$d děda a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d dědy a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d dědů a ',
            '%d grandmother recorded (%d in total).' . I18N::PLURAL . '%d grandmothers recorded (%d in total).'
                => '%d bábu (celkem %d).' . I18N::PLURAL . '%d báby (celkem %d).' . I18N::PLURAL . '%d bab (celkem %d).',
            '%2$s has %1$d grandmother and ' . I18N::PLURAL . '%2$s has %1$d grandmothers and '
                => '%2$s má zaznamenanou %1$d bábu a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d báby a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d bab a ',
            '%d grandparent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandparents of unknown sex recorded (%d in total).'
                => '%d prarodiče neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d prarodiče neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d prarodičů neznámého pohlaví (celkem %d).',
            '%2$s has %1$d grandfather, ' . I18N::PLURAL . '%2$s has %1$d grandfathers, '
                => '%2$s má %1$d děda, ' . I18N::PLURAL . '%2$s má %1$d dědy, ' . I18N::PLURAL . '%2$s má %1$d dědů, ',
            '%d grandmother, and ' . I18N::PLURAL . '%d grandmothers, and '
                => '%d bábu, a ' . I18N::PLURAL . '%d báby, a ' . I18N::PLURAL . '%d bab, a ',

            'Uncles and Aunts' => 'Strýcové a tety',
            '%s has no uncles or aunts recorded.' => '%s zde nemá zaznamenané žádné strýce ani tety.',
            '%s has one aunt recorded.' => '%s má zaznamenanou jednu tetu.',
            '%s has one uncle recorded.' => '%s má zaznamenaného jednoho strýce.',
            '%s has one uncle or aunt of unknown sex recorded.' => '%s má zaznamenaného jednoho strýce nebo jednu tetu neznámého pohlaví.',
            '%2$s has %1$d aunt recorded.' . I18N::PLURAL . '%2$s has %1$d aunts recorded.' => '%2$s má zaznamenanou %1$d tetu.' . I18N::PLURAL . '%2$s má zaznamenané %1$d tety.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d tet.',
            '%2$s has %1$d uncle recorded.' . I18N::PLURAL . '%2$s has %1$d uncles recorded.'
                => '%2$s má zaznamenaného %1$d strýce.' . I18N::PLURAL . '%2$s má zaznamenané %1$d strýce.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d strýců.',
            '%2$s has %1$d uncle or aunt of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d uncles or aunts of unknown sex recorded.'
                => '%2$s má zaznamenaného %1$d strýce nebo tetu neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenané %1$d strýce nebo tety neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d strýců nebo tet neznámého pohlaví.',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and '
                => '%2$s má zaznamenaného %1$d strýce a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d strýce a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d strýců a ',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).'
                => '%d tetu (celkem %d).' . I18N::PLURAL . '%d tety (celkem %d).' . I18N::PLURAL . '%d tet (celkem %d).',
            '%2$s has %1$d aunt and ' . I18N::PLURAL . '%2$s has %1$d aunts and '
                => '%2$s má zaznamenanou %1$d tetu a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d tety a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d tet a ',
            '%d uncle or aunt of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d uncles or aunts of unknown sex recorded (%d in total).'
                => '%d strýce nebo tetu neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d strýce nebo tety neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d strýců nebo tet neznámého pohlaví (celkem %d).',
            '%2$s has %1$d uncle, ' . I18N::PLURAL . '%2$s has %1$d uncles, '
                => '%2$s má %1$d strýce, ' . I18N::PLURAL . '%2$s má %1$d strýce, ' . I18N::PLURAL . '%2$s má %1$d strýců, ',
            '%d aunt, and ' . I18N::PLURAL . '%d aunts, and '
                => '%d tetu, a ' . I18N::PLURAL . '%d tety, a ' . I18N::PLURAL . '%d tet, a ',

            'Uncles and Aunts by marriage' => 'Vyženění/vyvdaní strýcové a tety',
            '%s has no uncles or aunts by marriage recorded.' => '%s nemá zaznamenané žádné vyženěné/vyvdané strýce ani tety.',
            '%s has one aunt by marriage recorded.' => '%s má zaznamenanou jednu vyženěnou/vyvdanou tetu.',
            '%s has one uncle by marriage recorded.' => '%s má zaznamenaného jednoho vyženěného/vyvdaného strýce.',
            '%s has one uncle or aunt by marriage of unknown sex recorded.' => '%s má zaznamenaného jednoho vyženěného/vyvdaného strýce nebo jednu vyženěnou/vyvdanou tetu naznámého pohlaví.',
            '%2$s has %1$d aunt by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d aunts by marriage recorded.'
                => '%2$s má zaznamenanou %1$d vyženěnou/vyvdanou tetu.' . I18N::PLURAL . '%2$s má zaznamenané %1$d vyženěné/vyvdané tety.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vyženěných/vyvdaných tet.',
            '%2$s has %1$d uncle by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d uncles by marriage recorded.'
                => '%2$s má zaznamenaného %1$d vyženěného/vyvdaného strýce.' . I18N::PLURAL . '%2$s má zaznamenané %1$d vyženěné/vyvdané strýce.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vyženěných/vyvdaných strýců.',
            '%2$s has %1$d uncle or aunt by marriage of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d uncles or aunts by marriage of unknown sex recorded.'
                => '%2$s má zaznamenaného %1$d vyženěného/vyvdaného strýce nebo vyženěnou/vyvdanou tetu neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenané %1$d vyženěné/vyvdané strýce nebo vyženěné/vyvdané tety neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vyženěných/vyvdaných strýců nebo vyženěných/vyvdaných tet neznámého pohlaví.',
            '%2$s has %1$d uncle by marriage and ' . I18N::PLURAL . '%2$s has %1$d uncles by marriage and '
                => '%2$s má zaznamenaného %1$d vyženěného/vyvdaného strýce a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d vyženěné/vyvdané strýce a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vyženěných/vyvdaných strýců a ',
            '%d aunt by marriage recorded (%d in total).' . I18N::PLURAL . '%d aunts by marriage recorded (%d in total).'
                => '%d vyženěnou/vyvdanou tetu (celkem %d).' . I18N::PLURAL . '%d vyženěné/vyvdané tety (celkem %d).' . I18N::PLURAL . '%d vyženěných/vyvdaných tet (celkem %d).',
            '%2$s has %1$d aunt by marriage and ' . I18N::PLURAL . '%2$s has %1$d aunts by marriage and '
                => '%2$s má zaznamenanou %1$d vyženěnou/vyvdanou tetu a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d vyženěné/vyvdané tety a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vyženěných/vyvdaných tet a ',
            '%d uncle or aunt by marriage of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d uncles or aunts by marriage of unknown sex recorded (%d in total).'
                => '%d vyženěného/vyvdaného strýce nebo tetu neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d vyženěné/vyvdané strýce nebo tety neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d vyženěných/vyvdaných strýců nebo tet neznámého pohlaví (celkem %d).',
            '%2$s has %1$d uncle by marriage, ' . I18N::PLURAL . '%2$s has %1$d uncles by marriage, '
                => '%2$s má %1$d vyženěného/vyvdaného strýce, ' . I18N::PLURAL . '%2$s má %1$d vyženěné/vyvdané strýce, ' . I18N::PLURAL . '%2$s má %1$d vyženěných/vyvdaných strýců, ',
            '%d aunt by marriage, and ' . I18N::PLURAL . '%d aunts by marriage, and '
                => '%d vyženěnou/vyvdanou tetu, a ' . I18N::PLURAL . '%d vyženěné/vyvdané tety, a ' . I18N::PLURAL . '%d vyženěných/vyvdaných tet, a ',

            'Parents' => 'Rodiče',
            '%s has no parents recorded.' => '%s nemá zaznamenané žádné rodiče.',
            '%s has one mother recorded.' => '%s má zaznamenanou jednu matku.',
            '%s has one father recorded.' => '%s má zaznamenaného jednoho otce.',
            '%s has one parent of unknown sex recorded.' => '%s má zaznamenaného jednoho rodiče neznámého pohlaví.',
            '%2$s has %1$d mother recorded.' . I18N::PLURAL . '%2$s has %1$d mothers recorded.' => '%2$s má zaznamenanou %1$d matku.' . I18N::PLURAL . '%2$s má zaznamenané %1$d matky.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d matek.',
            '%2$s has %1$d father recorded.' . I18N::PLURAL . '%2$s has %1$d fathers recorded.'
                => '%2$s má zaznamenaného %1$d otce.' . I18N::PLURAL . '%2$s má zaznamenané %1$d otce.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d otců.',
            '%2$s has %1$d father and ' . I18N::PLURAL . '%2$s has %1$d fathers and '
                => '%2$s má zaznamenaného %1$d otce a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d otce a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d otců a ',
            '%2$s has %1$d parent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d parents of unknown sex recorded.'
                => '%2$s má zaznamenaného %1$d rodiče neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenané %1$d rodiče neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d rodičú neznámého pohlaví.',
            '%d mother recorded (%d in total).' . I18N::PLURAL . '%d mothers recorded (%d in total).'
                => '%d matku (celkem %d).' . I18N::PLURAL . '%d matky (celkem %d).' . I18N::PLURAL . '%d matek (celkem %d).',
            '%2$s has %1$d mother and ' . I18N::PLURAL . '%2$s has %1$d mothers and '
                => '%2$s má zaznamenanou %1$d matku a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d matky a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d matek a ',
            '%d parent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d parents of unknown sex recorded (%d in total).'
                => '%d rodiče neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d rodiče neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d rodičů neznámého pohlaví (celkem %d).',
            '%2$s has %1$d father, ' . I18N::PLURAL . '%2$s has %1$d fathers, '
                => '%2$s má %1$d otce, ' . I18N::PLURAL . '%2$s má %1$d otce, ' . I18N::PLURAL . '%2$s má %1$d otců, ',
            '%d mother, and ' . I18N::PLURAL . '%d mothers, and '
                => '%d matku, a ' . I18N::PLURAL . '%d matky, a ' . I18N::PLURAL . '%d matek, a ',

            'Parents-in-law' => 'Tcháni a tchyně',
            '%s has no parents-in-law recorded.' => '%s zde nemá zaznamenaného žádného tchána ani tchyni.',
            '%s has one mother-in-law recorded.' => '%s má zaznamenanou jednu tchyni.',
            '%s has one father-in-law recorded.' => '%s má zaznamenaného jednoho tchána.',
            '%s has one parent-in-law of unknown sex recorded.' => '%s má zaznamenaného jednoho tchána či tchyni neznámého pohlaví.',
            '%2$s has %1$d mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d mothers-in-law recorded.' => '%2$s má zaznamenanou %1$d tchyni.' . I18N::PLURAL . '%2$s má zaznamenané %1$d tchyně.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d tchyní.',
            '%2$s has %1$d father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d fathers-in-law recorded.'
                => '%2$s má zaznamenaného %1$d tchána.' . I18N::PLURAL . '%2$s má zaznamenané %1$d tchány.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d tchánů.',
            '%2$s has %1$d parent-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d parents-in-law of unknown sex recorded.'
                => '%2$s má zaznamenaného %1$d tchána či tchyni neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenané %1$d tchány či tchyně neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d tchánů či tchyní neznámého pohlaví.',
            '%2$s has %1$d father-in-law and ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law and '
                => '%2$s má zaznamenaného %1$d tchána a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d tchány a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d tchánů a ',
            '%d mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d mothers-in-law recorded (%d in total).'
                => '%d tchyni (celkem %d).' . I18N::PLURAL . '%d tchyně (celkem %d).' . I18N::PLURAL . '%d tchyní (celkem %d).',
            '%2$s has %1$d mother-in-law and ' . I18N::PLURAL . '%2$s has %1$d mothers-in-law and '
                => '%2$s má zaznamenanou %1$d tchyni a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d tchyně a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d tchyní a ',
            '%d parent-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d parents-in-law of unknown sex recorded (%d in total).'
                => '%d tchána či tchyni neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d tchány či tchyně neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d tchánů či tchyní neznámého pohlaví (celkem %d).',
            '%2$s has %1$d father-in-law, ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law, '
                => '%2$s má %1$d tchána, ' . I18N::PLURAL . '%2$s má %1$d tchány, ' . I18N::PLURAL . '%2$s má %1$d tchánů, ',
            '%d mother-in-law, and ' . I18N::PLURAL . '%d mothers-in-law, and '
                => '%d tchyni, a ' . I18N::PLURAL . '%d tchyně, a ' . I18N::PLURAL . '%d tchyní, a ',

            'Co-parents-in-law' => 'Tcháni a tchyně dětí (spolutcháni a spolutchyně)',
            '%s has no co-parents-in-law recorded.' => '%s nemá zaznamenané žádné spolutchány ani spolutchyně.',
            '%s has one co-mother-in-law recorded.' => '%s má zaznamenanou jednu spolutchyni.',
            '%s has one co-father-in-law recorded.' => '%s má zaznamenaného jednoho spolutchána.',
            '%s has one co-parent-in-law of unknown sex recorded.' => '%s má zaznamenaného jednoho spolutchána či spolutchyni neznámého pohlaví.',
            '%2$s has %1$d co-mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law recorded.'
                => '%2$s má zaznamenanou %1$d spolutchyni.' . I18N::PLURAL . '%2$s má zaznamenané %1$d spolutchyně.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d spolutchyní.',
            '%2$s has %1$d co-parent-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d co-parents-in-law of unknown sex recorded.'
                => '%2$s má zaznamenaného %1$d spolutchána či spolutchyni neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenané %1$d spolutchány či spolutchyně neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d spolutchánů či spolutchyní neznámého pohlaví.',
            '%2$s has %1$d co-father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law recorded.'
                => '%2$s má zaznamenaného %1$d spolutchána.' . I18N::PLURAL . '%2$s má zaznamenané %1$d spolutchány.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d spolutchánů.',
            '%2$s has %1$d co-father-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law and '
                => '%2$s má zaznamenaného %1$d spolutchána a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d spolutchány a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d spolutchánů a ',
            '%d co-mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-mothers-in-law recorded (%d in total).'
                => '%d spolutchyni (celkem %d).' . I18N::PLURAL . '%d spolutchyně (celkem %d).' . I18N::PLURAL . '%d spolutchyní (celkem %d).',
            '%2$s has %1$d co-mother-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law and '
                => '%2$s má zaznamenanou %1$d spolutchyni a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d spolutchyně a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d spolutchyní a ',
            '%d co-parent-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d co-parents-in-law of unknown sex recorded (%d in total).'
                => '%d spolutchána či spolutchyni neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d spolutchány či spolutchyně neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d spolutchánů či spolutchyní neznámého pohlaví (celkem %d).',
            '%2$s has %1$d co-father-in-law, ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law, '
                => '%2$s má %1$d spolutchána, ' . I18N::PLURAL . '%2$s má %1$d spolutchány, ' . I18N::PLURAL . '%2$s má %1$d spolutchánů, ',
            '%d co-mother-in-law, and ' . I18N::PLURAL . '%d co-mothers-in-law, and '
                => '%d spolutchyni, a ' . I18N::PLURAL . '%d spolutchyně, a ' . I18N::PLURAL . '%d spolutchyní, a ',

            'Partners' => 'Partneři',
            'Partner of ' => 'Partner osoby ',
            '%s has no partners recorded.' => '%s zde nemá zaznamenaného žádného partnera.',
            '%s has one female partner recorded.' => '%s má zaznamenanou jednu partnerku.',
            '%s has one male partner recorded.' => '%s má zaznamenaného jednoho partnera.',
            '%s has one partner of unknown sex recorded.' => '%s má zaznamenaného jednoho partnera neznámého pohlaví.',
            '%2$s has %1$d female partner recorded.' . I18N::PLURAL . '%2$s has %1$d female partners recorded.' => '%2$s má zaznamenanou %1$d partnerku.' . I18N::PLURAL . '%2$s má zaznamenané %1$d partnerky.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d partnerek.',
            '%2$s has %1$d male partner recorded.' . I18N::PLURAL . '%2$s has %1$d male partners recorded.'
                => '%2$s má zaznamenaného %1$d partnera.' . I18N::PLURAL . '%2$s má zaznamenané %1$d partnery.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d partnerů.',
            '%2$s has %1$d partner of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d partners of unknown sex recorded.'
                => '%2$s má zaznamenaného %1$d partnera neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenané %1$d partnery neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d partnerů neznámého pohlaví.',
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
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and '
                => '%2$s má zaznamenaného %1$d partnera a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d partnery a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d partnerů a ',
            '%1$d female partner in this partner chain recorded (%2$d in total, including %3$s).' . I18N::PLURAL . '%d female partners in this partner chain recorded (%2$d in total, including %3$s).'
                => '%1$d partnerku v tomto řetězci (celkem %2$d, incl. %3$s).' . I18N::PLURAL . '%d partnerky v tomto řetězci (celkem %2$d, incl. %3$s).' . I18N::PLURAL . '%d partnerek v tomto řetězci (celkem %2$d, incl. %3$s).',
            '%d female partner and ' . I18N::PLURAL . '%d female partners and '
                => '%d partnerku, a ' . I18N::PLURAL . '%d partnerky, a ' . I18N::PLURAL . '%d partnerek, a ',
            '%1$d partner of unknown sex in this partner chain recorded (%2$d in total, including %3$s).' . I18N::PLURAL . '%d partners of unknown sex in this partner chain recorded (%2$d in total, including %3$s).'
                => '%1$d partnera neznámého pohlaví v tomto řetězci (celkem %2$d, incl. %3$s).' . I18N::PLURAL . '%d partnery neznámého pohlaví v tomto řetězci (celkem %2$d, incl. %3$s).' . I18N::PLURAL . '%d partnerů neznámého pohlaví v tomto řetězci (celkem %2$d, incl. %3$s).',
            '%2$s has %1$d female partner and ' . I18N::PLURAL . '%2$s has %1$d female partners and '
                => '%2$s má zaznamenanou %1$d partnerku a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d partnerky a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d partnerek a ',
            '%2$s has %1$d male partner, ' . I18N::PLURAL . '%2$s has %1$d male partners, '
                => '%2$s má %1$d partnera, ' . I18N::PLURAL . '%2$s má %1$d partnery, ' . I18N::PLURAL . '%2$s má %1$d partnerů, ',
            '%d female partner, and ' . I18N::PLURAL . '%d female partners, and '
                => '%d partnerku, a ' . I18N::PLURAL . '%d partnerky, a ' . I18N::PLURAL . '%d partnerek, a ',
            'There are %d branches in the partner chain. ' => 'V řetězci partnerů jsou %d linie.',
            'The longest branch in the partner chain to %2$s consists of %1$d partners (including %3$s).' => 'Nejdelší linie v řetězci k osobě \'%2$s\' sestává z %1$d partnerů (včetně osoby \'%3$s\').',
            'The longest branch in the partner chain consists of %1$d partners (including %2$s).' => 'Nejdelší linie v řetězci partnerů sestává z %1$d partnerů (včetně osoby \'%2$s\').',

            'Siblings' => 'Sourozenci',
            '%s has no siblings recorded.' => '%s zde nemá zaznamenané žádné sourozence.',
            '%s has one sister recorded.' => '%s má zaznamenanou jednu sestru.',
            '%s has one brother recorded.' => '%s má zaznamenaného jednoho bratra.',
            '%s has one sibling of unknown sex recorded.' => '%s má zaznamenaného jednoho sourozence neznámého pohlaví.',
            '%2$s has %1$d sister recorded.' . I18N::PLURAL . '%2$s has %1$d sisters recorded.' => '%2$s má zaznamenanou %1$d sestru.' . I18N::PLURAL . '%2$s má zaznamenané %1$d sestry.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d sester.',
            '%2$s has %1$d brother recorded.' . I18N::PLURAL . '%2$s has %1$d brothers recorded.'
                => '%2$s má zaznamenaného %1$d bratra.' . I18N::PLURAL . '%2$s má zaznamenané %1$d bratry.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d bratrů.',
            '%2$s has %1$d sibling of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d siblings of unknown sex recorded.'
                => '%2$s má zaznamenaného %1$d sourozence neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenané %1$d sourozence neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d sourozenců neznámého pohlaví.',
            '%2$s has %1$d brother and ' . I18N::PLURAL . '%2$s has %1$d brothers and '
                => '%2$s má zaznamenaného %1$d bratra a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d bratry a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d bratrů a ',
            '%d sister recorded (%d in total).' . I18N::PLURAL . '%d sisters recorded (%d in total).'
                => '%d sestru (celkem %d).' . I18N::PLURAL . '%d sestry (celkem %d).' . I18N::PLURAL . '%d sester (celkem %d).',

            '%2$s has %1$d sister and ' . I18N::PLURAL . '%2$s has %1$d sisters and '
                => '%2$s má zaznamenanou %1$d sestru a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d sestry a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d sester a ',
            '%d sibling of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d siblings of unknown sex recorded (%d in total).'
                => '%d sourozence neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d sourozence neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d sourozenců neznámého pohlaví (celkem %d).',
            '%2$s has %1$d brother, ' . I18N::PLURAL . '%2$s has %1$d brothers, '
                => '%2$s má %1$d bratra, ' . I18N::PLURAL . '%2$s má %1$d bratry, ' . I18N::PLURAL . '%2$s má %1$d bratrů, ',
            '%d sister, and ' . I18N::PLURAL . '%d sisters, and '
                => '%d sestru, a ' . I18N::PLURAL . '%d sestry, a ' . I18N::PLURAL . '%d sester, a ',

            'Siblings-in-law' => 'Švagři a švagrové',
            '%s has no siblings-in-law recorded.' => '%s nemá zaznamenané žádné švagry ani švagrové.',
            '%s has one sister-in-law recorded.' => '%s má zaznamenanou jednu švagrovou.',
            '%s has one brother-in-law recorded.' => '%s má zaznamenaného jednoho švagra.',
            '%s has one sibling-in-law of unknown sex recorded.' => '%s má zaznamenaného jednoho švagra či švagrovou neznámého pohlaví.',
            '%2$s has %1$d sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sisters-in-law recorded.'
                => '%2$s má zaznamenanou %1$d švagrovou.' . I18N::PLURAL . '%2$s má zaznamenané %1$d švagrové.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d švagrových.',
            '%2$s has %1$d brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d brothers-in-law recorded.'
                => '%2$s má zaznamenaného %1$d švagra.' . I18N::PLURAL . '%2$s má zaznamenané %1$d švagry.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d švagrů.',
            '%2$s has %1$d sibling-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d siblings-in-law of unknown sex recorded.'
                => '%2$s má zaznamenaného %1$d švagra či švagrovou neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenané %1$d švagry či švagrové neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d švagrů či švagrových neznámého pohlaví.',
            '%2$s has %1$d brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law and '
                => '%2$s má zaznamenaného %1$d švagra a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d švagry a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d švagrů a ',
            '%d sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d sisters-in-law recorded (%d in total).'
                => '%d švagrovou (celkem %d).' . I18N::PLURAL . '%d švagrové (celkem %d).' . I18N::PLURAL . '%d švagrových (celkem %d).',
            '%2$s has %1$d sister-in-law and ' . I18N::PLURAL . '%2$s has %1$d sisters-in-law and '
                => '%2$s má zaznamenanou %1$d švagrovou a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d švagrové a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d švagrových a ',
            '%d sibling-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d siblings-in-law of unknown sex recorded (%d in total).'
                => '%d švagra či švagrovou neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d švagry či švagrové neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d švagrů či švagrových neznámého pohlaví (celkem %d).',
            '%2$s has %1$d brother-in-law, ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law, '
                => '%2$s má %1$d švagra, ' . I18N::PLURAL . '%2$s má %1$d švagry, ' . I18N::PLURAL . '%2$s má %1$d švagrů, ',
            '%d sister-in-law, and ' . I18N::PLURAL . '%d sisters-in-law, and '
                => '%d švagrovou, a ' . I18N::PLURAL . '%d švagrové, a ' . I18N::PLURAL . '%d švagrových, a ',

            'Co-siblings-in-law' => 'Partneři a sourozenci švagrů a švagrových<br>(spolušvagři a spolušvagrové)',
            '%s has no co-siblings-in-law recorded.' => '%s nemá zaznamenané žádné spolušvagry ani spolušvagrové.',
            '%s has one co-sister-in-law recorded.' => '%s má zaznamenanou jednu spolušvagrovou.',
            '%s has one co-brother-in-law recorded.' => '%s má zaznamenaného jednoho spolušvagra.',
            '%s has one co-sibling-in-law of unknown sex recorded.' => '%s má zaznamenaného jednoho spolušvagra či spolušvagrovou neznámého pohlaví.',
            '%2$s has %1$d co-sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-sisters-in-law recorded.'
                => '%2$s má zaznamenanou %1$d spolušvagrovou.' . I18N::PLURAL . '%2$s má zaznamenané %1$d spolušvagrové.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d spolušvagrových.',
            '%2$s has %1$d co-brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law recorded.'
                => '%2$s má zaznamenaného %1$d spolušvagra.' . I18N::PLURAL . '%2$s má zaznamenané %1$d spolušvagry.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d spolušvagrů.',
            '%2$s has %1$d co-sibling-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d co-siblings-in-law of unknown sex recorded.'
                => '%2$s má zaznamenaného %1$d spolušvagra či spolušvagrovou neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenané %1$d spolušvagry či spolušvagrové neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d spolušvagrů či spolušvagrových neznámého pohlaví.',
            '%2$s has %1$d co-brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law and '
                => '%2$s má zaznamenaného %1$d spolušvagra a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d spolušvagry a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d spolušvagrů a ',
            '%d co-sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-sisters-in-law recorded (%d in total).'
                => '%d spolušvagrovou (celkem %d).' . I18N::PLURAL . '%d spolušvagrové (celkem %d).' . I18N::PLURAL . '%d spolušvagrových (celkem %d).',
            '%2$s has %1$d co-sister-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-sisters-in-law and '
                => '%2$s má zaznamenanou %1$d spolušvagrovou a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d spolušvagrové a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d spolušvagrových a ',
            '%d co-sibling-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d co-siblings-in-law of unknown sex recorded (%d in total).'
                => '%d spolušvagra či spolušvagrovou neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d spolušvagry či spolušvagrové neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d spolušvagrů či spolušvagrových neznámého pohlaví (celkem %d).',
            '%2$s has %1$d co-brother-in-law, ' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law, '
                => '%2$s má %1$d spolušvagra, ' . I18N::PLURAL . '%2$s má %1$d spolušvagry, ' . I18N::PLURAL . '%2$s má %1$d spolušvagrů, ',
            '%d co-sister-in-law, and ' . I18N::PLURAL . '%d co-sisters-in-law, and '
                => '%d spolušvagrovou, a ' . I18N::PLURAL . '%d spolušvagrové, a ' . I18N::PLURAL . '%d spolušvagrových, a ',

            'Cousins' => 'Bratranci a sestřenice',
            '%s has no first cousins recorded.' => '%s nemá zaznamenané žádné bratrance ani sestřenice.',
            '%s has one female first cousin recorded.' => '%s má zaznamenanou jednu sestřenici.',
            '%s has one male first cousin recorded.' => '%s má zaznamenaného jednoho bratrance.',
            '%s has one first cousin of unknown sex recorded.' => '%s má zaznamenaného jednoho bratrance či sestřenici neznámého pohlaví.',
            '%2$s has %1$d female first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d female first cousins recorded.' => '%2$s má zaznamenanou %1$d sestřenici.' . I18N::PLURAL . '%2$s má zaznamenané %1$d sestřenice.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d sestřenic.',
            '%2$s has %1$d male first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d male first cousins recorded.'
                => '%2$s má zaznamenaného %1$d bratrance.' . I18N::PLURAL . '%2$s má zaznamenané %1$d bratrance.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d bratranců.',
            '%2$s has %1$d first cousin of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d first cousins of unknown sex recorded.'
                => '%2$s má zaznamenaného %1$d bratrance či sestřenici neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenané %1$d bratrance či sestřenice neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d bratranců či sestřenic neznámého pohlaví.',
            '%2$s has %1$d male first cousin and ' . I18N::PLURAL . '%2$s has %1$d male first cousins and '
                => '%2$s má zaznamenaného %1$d bratrance a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d bratrance a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d bratranců a ',
            '%d female first cousin recorded (%d in total).' . I18N::PLURAL . '%d female first cousins recorded (%d in total).'
                => '%d sestřenici (celkem %d).' . I18N::PLURAL . '%d sestřenice (celkem %d).' . I18N::PLURAL . '%d sestřenic (celkem %d).',
            '%2$s has %1$d female first cousin and ' . I18N::PLURAL . '%2$s has %1$d female first cousins and '
                => '%2$s má zaznamenanou %1$d sestřenici a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d sestřenice a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d sestřenic a ',
            '%d first cousin of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d first cousins of unknown sex recorded (%d in total).'
                => '%d bratrance či sestřenici neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d bratrance či sestřenice neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d bratranců či sestřenic neznámého pohlaví (celkem %d).',
            '%2$s has %1$d male first cousin, ' . I18N::PLURAL . '%2$s has %1$d male first cousins, '
                => '%2$s má %1$d bratrance, ' . I18N::PLURAL . '%2$s má %1$d bratrance, ' . I18N::PLURAL . '%2$s má %1$d bratranců, ',
            '%d female first cousin, and ' . I18N::PLURAL . '%d female first cousins, and '
                => '%d sestřenici, a ' . I18N::PLURAL . '%d sestřenice, a ' . I18N::PLURAL . '%d sestřenic, a ',

            'Nephews and Nieces' => 'Synovci a neteře',
            '%s has no nephews or nieces recorded.' => '%s nemá zaznamenané žádné synovce ani neteře.',
            '%s has one niece recorded.' => '%s má zaznamenanou jednu neteř.',
            '%s has one nephew recorded.' => '%s má zaznamenaného jednoho synovce.',
            '%s has one nephew or niece of unknown sex recorded.' => '%s má zaznamenaného jednoho synovce či neteř neznámého pohlaví.',
            '%2$s has %1$d niece recorded.' . I18N::PLURAL . '%2$s has %1$d nieces recorded.' => '%2$s má zaznamenanou %1$d sestřenici.' . I18N::PLURAL . '%2$s má zaznamenané %1$d sestřenice.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d sestřenic.',
            '%2$s has %1$d nephew recorded.' . I18N::PLURAL . '%2$s has %1$d nephews recorded.'
                => '%2$s má zaznamenaného %1$d synovce.' . I18N::PLURAL . '%2$s má zaznamenané %1$d synovce.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d synovců.',
            '%2$s has %1$d nephew or niece of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d nephews or nieces of unknown sex recorded.'
                => '%2$s má zaznamenaného %1$d synovce či neteř neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenané %1$d synovce či neteře neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d synovců či neteří neznámého pohlaví.',
            '%2$s has %1$d nephew and ' . I18N::PLURAL . '%2$s has %1$d nephews and '
                => '%2$s má zaznamenaného %1$d synovce a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d synovce a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d synovců a ',
            '%d niece recorded (%d in total).' . I18N::PLURAL . '%d nieces recorded (%d in total).'
                => '%d neteř (celkem %d).' . I18N::PLURAL . '%d neteře (celkem %d).' . I18N::PLURAL . '%d neteří (celkem %d).',
            '%2$s has %1$d niece and ' . I18N::PLURAL . '%2$s has %1$d nieces and '
                => '%2$s má zaznamenanou %1$d neteř a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d neteře a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d neteří a ',
            '%d nephew or niece of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d nephews or nieces of unknown sex recorded (%d in total).'
                => '%d synovce či neteř neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d synovce či neteře neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d synovců či neteří neznámého pohlaví (celkem %d).',
            '%2$s has %1$d nephew, ' . I18N::PLURAL . '%2$s has %1$d nephews, '
                => '%2$s má %1$d synovce, ' . I18N::PLURAL . '%2$s má %1$d synovce, ' . I18N::PLURAL . '%2$s má %1$d synovců, ',
            '%d niece, and ' . I18N::PLURAL . '%d nieces, and '
                => '%d neteř, a ' . I18N::PLURAL . '%d neteře, a ' . I18N::PLURAL . '%d neteří, a ',

            'Children' => 'Děti',
            '%s has no children recorded.' => '%s nemá zaznamenané žádné děti.',
            '%s has one daughter recorded.' => '%s má zaznamenanou jednu dceru.',
            '%s has one son recorded.' => '%s má zaznamenaného jednoho syna.',
            '%s has one child of unknown sex recorded.' => '%s má zaznamenané jedno dítě neznámého pohlaví.',
            '%2$s has %1$d daughter recorded.' . I18N::PLURAL . '%2$s has %1$d daughters recorded.' => '%2$s má zaznamenanou %1$d dceru.' . I18N::PLURAL . '%2$s má zaznamenané %1$d dcery.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d dcer.',
            '%2$s has %1$d son recorded.' . I18N::PLURAL . '%2$s has %1$d sons recorded.'
                => '%2$s má zaznamenaného %1$d syna.' . I18N::PLURAL . '%2$s má zaznamenané %1$d syny.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d synů.',
            '%2$s has %1$d child of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d children of unknown sex recorded.'
                => '%2$s má zaznamenaného %1$d dítě neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenané %1$d děti neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d dětí neznámého pohlaví.',
            '%2$s has %1$d son and ' . I18N::PLURAL . '%2$s has %1$d sons and '
                => '%2$s má zaznamenaného %1$d syna a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d syny a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d synů a ',
            '%d daughter recorded (%d in total).' . I18N::PLURAL . '%d daughters recorded (%d in total).'
                => '%d dceru (celkem %d).' . I18N::PLURAL . '%d dcery (celkem %d).' . I18N::PLURAL . '%d dcer (celkem %d).',
            '%2$s has %1$d daughter and ' . I18N::PLURAL . '%2$s has %1$d daughters and '
                => '%2$s má zaznamenanou %1$d dceru a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d dcery a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d dcer a ',
            '%d child of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d children of unknown sex recorded (%d in total).'
                => '%d dítě neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d děti neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d dětí neznámého pohlaví (celkem %d).',
            '%2$s has %1$d son, ' . I18N::PLURAL . '%2$s has %1$d sons, '
                => '%2$s má %1$d syna, ' . I18N::PLURAL . '%2$s má %1$d syny, ' . I18N::PLURAL . '%2$s má %1$d synů, ',
            '%d daughter, and ' . I18N::PLURAL . '%d daughters, and '
                => '%d dceru, a ' . I18N::PLURAL . '%d dcery, a ' . I18N::PLURAL . '%d dcer, a ',

            'Children-in-law' => 'Zeťové a snachy',
            '%s has no children-in-law recorded.' => '%s nemá zaznamenané žádné zetě ani snachy.',
            '%s has one daughter-in-law recorded.' => '%s má zaznamenanou jednu snachu.',
            '%s has one son-in-law recorded.' => '%s má zaznamenaného jednoho zetě.',
            '%s has one child-in-law of unknown sex recorded.' => '%s má zaznamenaného jednoho zetě či snachu neznámého pohlaví.',
            '%2$s has %1$d daughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d daughters-in-law recorded.'
                => '%2$s má zaznamenanou %1$d snachu.' . I18N::PLURAL . '%2$s má zaznamenané %1$d snachy.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d snach.',
            '%2$s has %1$d son-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sons-in-law recorded.'
                => '%2$s má zaznamenaného %1$d zetě.' . I18N::PLURAL . '%2$s má zaznamenané %1$d zetě.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d zeťů.',
            '%2$s has %1$d child-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d children-in-law of unknown sex recorded.'
                => '%2$s má zaznamenaného %1$d zetě či snachu neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenané %1$d zetě či snachy neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d zetů či snach neznámého pohlaví.',
            '%2$s has %1$d son-in-law and ' . I18N::PLURAL . '%2$s has %1$d sons-in-law and '
                => '%2$s má zaznamenaného %1$d zetě a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d zetě a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d zeťů a ',
            '%d daughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d daughters-in-law recorded (%d in total).'
                => '%d snachu (celkem %d).' . I18N::PLURAL . '%d snachy (celkem %d).' . I18N::PLURAL . '%d snach (celkem %d).',
            '%2$s has %1$d daughter-in-law and ' . I18N::PLURAL . '%2$s has %1$d daughters-in-law and '
                => '%2$s má zaznamenanou %1$d snachu a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d snachy a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d snach a ',
            '%d child-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d children-in-law of unknown sex recorded (%d in total).'
                => '%d zetě či snachu neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d zetě či snachy neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d zeťů či snach neznámého pohlaví (celkem %d).',
            '%2$s has %1$d son-in-law, ' . I18N::PLURAL . '%2$s has %1$d sons-in-law, '
                => '%2$s má %1$d zetě, ' . I18N::PLURAL . '%2$s má %1$d zetě, ' . I18N::PLURAL . '%2$s má %1$d zeťů, ',
            '%d daughter-in-law, and ' . I18N::PLURAL . '%d daughters-in-law, and '
                => '%d snachu, a ' . I18N::PLURAL . '%d snachy, a ' . I18N::PLURAL . '%d snach, a ',

            'Grandchildren' => 'Vnoučata',
            '%s has no grandchildren recorded.' => '%s nemá zaznamenaná žádná vnoučata.',
            '%s has one granddaughter recorded.' => '%s má zaznamenanou jednu vnučku.',
            '%s has one grandson recorded.' => '%s má zaznamenaného jednoho vnuka.',
            '%s has one grandchild of unknown sex recorded.' => '%s má zaznamenané jedno vnouče neznámého pohlaví.',
            '%2$s has %1$d granddaughter recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters recorded.' => '%2$s má zaznamenanou %1$d vnučku.' . I18N::PLURAL . '%2$s má zaznamenané %1$d vnučky.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vnuček.',
            '%2$s has %1$d grandson recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons recorded.'
                => '%2$s má zaznamenaného %1$d vnuka.' . I18N::PLURAL . '%2$s má zaznamenané %1$d vnuky.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vnuků.',
            '%2$s has %1$d grandchild of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandchildren of unknown sex recorded.'
                => '%2$s má zaznamenaného %1$d vnouče neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenané %1$d vnoučata neznámého pohlaví.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vnoučat neznámého pohlaví.',
            '%2$s has %1$d grandson and ' . I18N::PLURAL . '%2$s has %1$d grandsons and '
                => '%2$s má zaznamenaného %1$d vnuka a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d vnuky a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vnuků a ',
            '%d granddaughter recorded (%d in total).' . I18N::PLURAL . '%d granddaughters recorded (%d in total).'
                => '%d vnučku (celkem %d).' . I18N::PLURAL . '%d vnučky (celkem %d).' . I18N::PLURAL . '%d vnuček (celkem %d).',
            '%2$s has %1$d granddaughter and ' . I18N::PLURAL . '%2$s has %1$d granddaughters and '
                => '%2$s má zaznamenanou %1$d vnučku a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d vnučky a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d vnuček a ',
            '%d grandchild of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandchildren of unknown sex recorded (%d in total).'
                => '%d vnouče neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d vnoučata neznámého pohlaví (celkem %d).' . I18N::PLURAL . '%d vnoučat neznámého pohlaví (celkem %d).',
            '%2$s has %1$d grandson, ' . I18N::PLURAL . '%2$s has %1$d grandsons, '
                => '%2$s má %1$d vnuka, ' . I18N::PLURAL . '%2$s má %1$d vnuky, ' . I18N::PLURAL . '%2$s má %1$d vnuků, ',
            '%d granddaughter, and ' . I18N::PLURAL . '%d granddaughters, and '
                => '%d vnučku, a ' . I18N::PLURAL . '%d vnučky, a ' . I18N::PLURAL . '%d vnuček, a ',
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
            'Family part (generation relative to proband)' => 'Familienteil (Generation relativ zum Probanden)',
            'Show name of proband as short name or as full name?' => 'Soll eine Kurzform oder der vollständige Name des Probanden angezeigt werden?',
			'Show options to filter the results?' => 'Sollen Optionen zum Filtern der Ergebnisse angezeigt werden?',
            'Show filter options' => 'Zeige Filteroptionen',
            'How should empty parts of extended family be presented?' => 'Wie sollen leere Teile der erweiterten Familie angezeigt werden?',
			'Show empty block' => 'Zeige leere Familienteile',
			'yes, always at standard location' => 'ja, immer am normalen Platz',
			'no, but collect messages about empty blocks at the summary block' => 'nein, aber sammle Nachrichten über leere Familienteile im zusammenfassenden Abschnitt',
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
            'This allows a user to filter the members of the extended family by gender and if they are alive or dead.'
                => 'Dies erlaubt es einem Nutzer die Mitglieder der erweiterten Familie nach Geschlecht sowie nach lebend/tot zu filtern.',
            'Should a summary block be shown?' => 'Soll ein zusammenfassender Abschnitt angezeigt werden?',
            'The summary contains information about the extended family in total.' => 'Die Zusammenfassung enthält Informationen über die erweiterte Familie als Ganzes.',
            'Show summary' => 'Zeige Zusammenfassung',
            'Count the members of the partner chains as members of the extended family?'
                => 'Zählen die Mitglieder der Partnerketten zur erweiterten Familie?',
            'If you select "no", then the additional members in the partner chains will not be counted to the total number of individuals in the extended family.'
                => 'Wenn Sie "nein" auswählen, dann werden die zusätzlichen Mitglieder in den Partnerketten nicht zur Gesamtzahl der Mitglieder der erweiterten Familie gezählt.',
            'And these persons and families will be not selected when a user decides to copy the extended family to the clippings cart.'
                => 'Und diese Personen und Familien werden nicht ausgewählt, wenn ein Anwender sich entscheidet, die erweiterte Familie in den Sammelbehälter zu kopieren.',
            'But even in this case, you can copy these persons and families to the clippings cart by using a special menu topic of the custom module "enhanced clippings cart": "add partner chains for an individual".'
                => 'Aber auch in diesem Fall können diese Personen und Familien in den Sammelbehälter kopiert werden, indem ein spezieller Menüpunkt im Erweiterungsmodul Sammelbehälter ausgewählt wird: "füge Partnerketten für eine Person hinzu".',
            'This is only relevant if you have chosen in the above table, that the partner chains should be shown as a part of the extended family.'
                => 'Dies ist nur dann relevant, wenn Sie in der oben stehenden Tabelle ausgewählt haben, dass die Partnerketten ein Teil der erweiterten Familie sind.',
            'Include them' => 'Einbeziehen',
            'Show a button "copy to clippings cart"?' => 'Soll ein Knopf "kopieren in den Auswahlkorb" gezeigt werden',
            'This allows a user to copy all members of the extended family to the clippings cart.'
                => 'Das erlaubt einem Anwender alle Mitglieder der erweiterten Familie in den Auswahlkorb zu kopieren.',
            'Show button' => 'Zeige den Knopf',
            
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
            'a dead person' => 'eine verstorbene Person',
            'a living person' => 'eine lebende Person',
            'not a male person' => 'keine männliche Person',
            'not a female person' => 'keine weibliche Person',
            'not a person of unknown gender' => 'keine Person unbekannten Geschlechts',
            'copy all members of the extended family to the clippings cart' => 'kopiere alle Mitglieder der Großfamilie in den Sammelbehälter',
            'copy to clippings cart' => 'in den Sammelbehälter kopieren',

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

            'Biological grandparents of father' => 'Biologische Großeltern des Vaters',
            'Biological grandparents of mother' => 'Biologische Großeltern der Mutter',
            'Biological grandparents of parent' => 'Biologische Großeltern eines Elternteils',
            'Stepparents of biological parent of father' => 'Stiefeltern eines biologischen Elternteils des Vaters',
            'Stepparents of biological parent of mother' => 'Stiefeltern eines biologischen Elternteils der Mutter',
            'Stepparents of biological grandparent' => 'Stiefeltern eines biologischen Großelternteils',
            'Parents of stepparent of father' => 'Eltern eines Stiefelternteils des Vaters',
            'Parents of stepparent of mother' => 'Eltern eines Stiefelternteils der Mutter',
            'Parents of stepparent of parent' => 'Eltern eines Stiefelternteils eines Elternteils',
            'Grandparents of stepparent' => 'Großeltern eines Stiefelternteils',
            'Biological great-grandparents' => 'Biologische Urgroßeltern',
            'Biological parents of father' => 'Biologische Eltern des Vaters',
            'Biological parents of mother' => 'Biologische Eltern der Mutter',
            'Biological parents of parent' => 'Biologische Eltern eines Elternteils',
            'Stepparents of father' => 'Stiefeltern des Vaters',
            'Stepparents of mother' => 'Stiefeltern der Mutter',
            'Stepparents of parent' => 'Stiefeltern eines Elternteils',
            'Parents of stepparent' => 'Eltern eines Stiefelternteils',
            'Biological grandparents' => 'Biologische Großeltern',
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
            'Partners of biological grandchildren' => 'Partner der biologischen Enkelkinder',
            'Partners of stepchildren of children' => 'Partner der Stiefkinder der Kinder',
            'Partners of children of stepchildren' => 'Partner der Kinder der Stiefkinder',
            'Partners of stepchildren of stepchildren' => 'Partner der Stiefkinder der Stiefkinder',

            'He' => 'ihn', // Kontext "Für ihn"
            'She' => 'sie', // Kontext "Für sie"
            'He/she' => 'ihn/sie', // Kontext "Für ihn/sie"
            'Mr.' => 'Herrn', // Kontext "Für Herrn xxx"
            'Mrs.' => 'Frau', // Kontext "Für Frau xxx"
            'No family available' => 'Es wurde keine Familie gefunden.',
            'Summary for the shown extended family' => 'Zusammenfassung für die gezeigte erweiterte Familie',
            'The extended family has only %1$s as a member.' . I18N::PLURAL . 'The extended family of %1$s has %2$d members (including %1$s).'
                => 'Die erweiterte Familie von %1$s hat ein Mitglied.' . I18N::PLURAL . 'Die erweiterte Familie von %1$s hat %2$d Mitglieder.',
            '(additional members of the partner chains are not counted)'
                => '(zusätzliche Mitglieder in den Partnerketten werden nicht mitgezählt)',
            'Some of them are member in more than one part of the extended family.'
                => 'Einige von ihnen sind in mehr als einem Familienteil vertreten.',
            '%s has no %s recorded.' => 'Für %s sind keine %s verzeichnet.',
            '%s has no %s, and no %s recorded.' => 'Für %s sind keine %s und keine %s verzeichnet.',

            'Father\'s family (%d)' => 'Familie des Vaters (%d)',
            'Mother\'s family (%d)' => 'Familie der Mutter (%d)',
            'Father\'s and Mother\'s family (%d)' => 'Familie des Vaters und der Mutter (%d)',
            'Grandparents %1$s (%2$s) of stepfather %3$s' => 'Großeltern %1$s (%2$s) des Stiefvaters %3$s',
            'Grandparents %1$s (%2$s) of stepmother %3$s' => 'Großeltern %1$s (%2$s) der Stiefmutter %3$s',
            'Grandparents %1$s (%2$s) of stepparent %3$s' => 'Großeltern %1$s (%2$s) des Stiefelternteils %3$s',
            'Stepparents %1$s (%2$s) of %3$s' => 'Stiefeltern %1$s (%2$s) von %3$s',
            'Parents %1$s (%2$s) of stepfather %3$s' => 'Eltern %1$s (%2$s) des Stiefvaters %3$s',
            'Parents %1$s (%2$s) of stepmother %3$s' => 'Eltern %1$s (%2$s) der Stiefmutter %3$s',
            'Parents %1$s (%2$s) of stepparent %3$s' => 'Eltern %1$s (%2$s) des Stiefelternteils %3$s',
            'Parents %1$s of %2$s' => 'Eltern %1$s von %2$s',
            'Parents %1$s (%2$s) of %3$s' => 'Eltern %1$s (%2$s) von %3$s',
            'Partners of %s' => 'Partner von %s',
            'Brother %1$s of partner %2$s' => 'Bruder %1$s von Partner %2$s',
            'Sister %1$s of partner %2$s' => 'Schwester %1$s von Partner %2$s',
            'Sibling %1$s of partner %2$s' => 'Geschwister %1$s von Partner %2$s',

            'Great-grandparents' => 'Urgroßeltern',
            '%s has no great-grandparents recorded.' => 'Für %s sind keine Urgroßeltern verzeichnet.',
            '%s has one great-grandmother recorded.' => 'Für %s ist eine Urgroßmutter verzeichnet.',
            '%s has one great-grandfather recorded.' => 'Für %s ist ein Urgroßvater verzeichnet.',
            '%s has one great-grandparent of unknown sex recorded.' => 'Für %s ist ein Urgroßelternteil mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d great-grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandmothers recorded.'
                => 'Für %2$s ist %1$d Urgroßmutter verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Urgroßmütter verzeichnet.',
            '%2$s has %1$d great-grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandfathers recorded.'
                => 'Für %2$s ist %1$d Urgroßvater verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Urgroßväter verzeichnet.',
            '%2$s has %1$d great-grandparent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandparents of unknown sex recorded.'
                => 'Für %2$s ist %1$d Urgroßelternteil mit unbekanntem Geschlecht verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Urgroßelternteile mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d great-grandfather and ' . I18N::PLURAL . '%2$s has %1$d great-grandfathers and '
                => 'Für %2$s sind %1$d Urgroßvater und ' . I18N::PLURAL . 'Für %2$s sind %1$d Urgroßväter und ',
            '%d great-grandmother recorded (%d in total).' . I18N::PLURAL . '%d great-grandmothers recorded (%d in total).'
                => '%d Urgroßmutter verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Urgroßmütter verzeichnet (insgesamt %d).',
            '%2$s has %1$d great-grandmother and ' . I18N::PLURAL . '%2$s has %1$d great-grandmothers and '
                => 'Für %2$s sind %1$d Urgroßmutter und ' . I18N::PLURAL . 'Für %2$s sind %1$d Urgroßmütter und ',
            '%d great-grandparent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d great-grandparents of unknown sex recorded (%d in total).'
                => '%d Urgroßelternteil mit unbekanntem Geschlecht verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Urgroßelternteile mit unbekanntem Geschlecht verzeichnet (insgesamt %d).',
            '%2$s has %1$d great-grandfather, ' . I18N::PLURAL . '%2$s has %1$d great-grandfathers, '
                => 'Für %2$s sind %1$d Urgroßvater, ' . I18N::PLURAL . 'Für %2$s sind %1$d Urgroßväter, ',
            '%d great-grandmother, and ' . I18N::PLURAL . '%d great-grandmothers, and '
                => '%d Urgroßmutter und ' . I18N::PLURAL . '%d Urgroßmütter und ',

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
            '%1$d female partner in this partner chain recorded (%2$d in total, including %3$s).' . I18N::PLURAL . '%1$d female partners in this partner chain recorded (%2$d in total, including %3$s).'
                => '%1$d Partnerin in dieser Partnerkette verzeichnet (insgesamt %2$d, inklusive %3$s).' . I18N::PLURAL . '%1$d Partnerinnen in dieser Partnerkette verzeichnet (insgesamt %2$d, inklusive %3$s).',
            '%d female partner and ' . I18N::PLURAL . '%d female partners and '
                => '%d Partnerin und ' . I18N::PLURAL . '%d Partnerinnen und ',
            '%1$d partner of unknown sex in this partner chain recorded (%2$d in total, including %3$s).' . I18N::PLURAL . '%1$d partners of unknown sex in this partner chain recorded (%2$d in total, including %3$s).'
                => '%1$d Partner mit unbekanntem Geschlecht in dieser Partnerkette verzeichnet (insgesamt %2$d, inklusive %3$s).' . I18N::PLURAL . '%d Partner mit unbekanntem Geschlecht in dieser Partnerkette verzeichnet (insgesamt %d, inklusive %3$s).',
            '%2$s has %1$d female partner and ' . I18N::PLURAL . '%2$s has %1$d female partners and '
                => 'Für %2$s sind %1$d Partnerin und ' . I18N::PLURAL . 'Für %2$s sind %1$d Partnerinnen und ',
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

            'Grandchildren-in-law' => 'Schwiegerenkelkinder',
            '%s has no grandchildren-in-law recorded.' => 'Für %s sind keine Schwiegerenkelkinder verzeichnet.',
            '%s has one granddaughter-in-law recorded.' => 'Für %s ist eine Schwiegerenkeltochter verzeichnet.',
            '%s has one grandson-in-law recorded.' => 'Für %s ist ein Schwiegerenkelsohn verzeichnet.',
            '%s has one grandchild-in-law of unknown sex recorded.' => 'Für %s ist ein Schwiegerenkelkind mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d granddaughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters-in-law recorded.'
                => 'Für %2$s ist %1$d Schwiegerenkeltochter verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Schwiegerenkeltöchter verzeichnet.',
            '%2$s has %1$d grandson-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons-in-law recorded.'
                => 'Für %2$s ist %1$d Schwiegerenkelsohn verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Schwiegerenkelsöhne verzeichnet.',
            '%2$s has %1$d grandchild-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandchildren-in-law of unknown sex recorded.'
                => 'Für %2$s ist %1$d Schwiegerenkelkind mit unbekanntem Geschlecht verzeichnet.' . I18N::PLURAL . 'Für %2$s sind %1$d Schwiegerenkelkinder mit unbekanntem Geschlecht verzeichnet.',
            '%2$s has %1$d grandson-in-law and ' . I18N::PLURAL . '%2$s has %1$d grandsons-in-law and '
                => 'Für %2$s sind %1$d Schwiegerenkelsohn und ' . I18N::PLURAL . 'Für %2$s sind %1$d Schwiegerenkelsöhne und ',
            '%d granddaughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d granddaughters-in-law recorded (%d in total).'
                => '%d Schwiegerenkeltochter verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Schwiegerenkeltöchter verzeichnet (insgesamt %d).',
            '%2$s has %1$d granddaughter-in-law and ' . I18N::PLURAL . '%2$s has %1$d granddaughters-in-law and '
                => 'Für %2$s sind %1$d Schwiegerenkeltochter und ' . I18N::PLURAL . 'Für %2$s sind %1$d Schwiegerenkeltöchter und ',
            '%d grandchild-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandchildren-in-law of unknown sex recorded (%d in total).'
                => '%d Schwiegerenkelkind mit unbekanntem Geschlecht verzeichnet (insgesamt %d).' . I18N::PLURAL . '%d Schwiegerenkelkinder mit unbekanntem Geschlecht verzeichnet (insgesamt %d).',
            '%2$s has %1$d grandson-in-law, ' . I18N::PLURAL . '%2$s has %1$d grandsons-in-law, '
                => 'Für %2$s sind %1$d Schwiegerenkelsohn, ' . I18N::PLURAL . 'Für %2$s sind %1$d Schwiegerenkelsöhne, ',
            '%d granddaughter-in-law, and ' . I18N::PLURAL . '%d granddaughters-in-law, and '
                => '%d Schwiegerenkeltochter und ' . I18N::PLURAL . '%d Schwiegerenkeltöchter und ',
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
            'Show parameters of extended family part?' => '¿Mostrar parámetros de la familia ampliada?',
            'Display of additional information for each part of the extended family, such as the generation shift and the coefficient of relationship, which is a measure of the degree of consanguinity.' => 'Visualizaci&oacute;n de informaci&oacute; adicional para cada miembro de la familia ampliada, as&iacute; como el movimiento generacional y el coeficiente de parentesco medido con grado de consanguinidad.',
            'Show parameters' => 'Mostrar parámetros',

            'generation +%s' => 'Generaci&oacute;n +%s',
            'same generation' => 'Misma generaci&oacute;n',
            'generation %s' => 'Generaci&oacute;n %s',
            'relationship coefficient: %.1f' => 'Coeficiente de relaci&oacute;n %.1f',
            'no blood relationship' => 'sin relaci&oacute;n de consanguinidad',

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

            'Biological grandparents of father' => 'Abuelos biol&oacute;gicos del padre',
            'Biological grandparents of mother' => 'Abuelos biol&oacute;gicos de la madre',
            'Biological grandparents of parent' => 'Abuelos biol&oacute;gicos de los padres',
            'Stepparents of biological parent of father' => 'Padrastos del padre biol&oacute;gico',
            'Stepparents of biological parent of mother' => 'Padrastros del padre biol&oacute;gico de la madre',
            'Stepparents of biological grandparent' => 'Padrastros del abuelo biol&oacute;gico',
            'Parents of stepparent of father' => 'Padres del padrasto o de la madrasta',
            'Parents of stepparent of mother' => 'Padres del padrastro de la madre',
            'Parents of stepparent of parent' => 'Padres del padrastro de la madre',
            'Grandparents of stepparent' => 'Abuelos de los padrastros',
            'Biological great-grandparents' => 'Bisabuelos biolbiol&oacute;gicos',
            'Biological parents of father' => 'Abuelos biol&oacute;gicos por parte de padre',
            'Biological parents of mother' => 'Abuelos biol&oacute;gicos por parte de madre',
            'Biological parents of parent' => 'Padres biol&oacute;gicos',
            'Stepparents of father' => 'Padrastros del padre',
            'Stepparents of mother' => 'Padrastros de la madre',
            'Stepparents of parent' => 'Padrastros de los padres',
            'Parents of stepparent' => 'Padres de padrastros',
            'Siblings of father' => 'Hermanos del padre',
            'Siblings of mother' => 'Hermanos de la madre',
            'Full siblings of biological parents' => 'Relaci&oacute; completa de hermanos de los padres biol&oacute;gicos',
            'Siblings-in-law of father' => 'Hermanos políticos del padre',
            'Siblings-in-law of mother' => 'Hermanos políticos de la madre',
            'Biological parents' => 'Padres biolbiol&oacute;gicos',
            'Stepparents' => 'Padrastros',
            'Parents-in-law of biological children' => 'Suegros de sus hijos/as biol&oacute;gicos',
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
            'Children of full siblings of biological parents' => 'Relaci&oacute; de hijos de hermanos de los padres biol&oacute;gicos',
            'Children of siblings' => 'Hijos de hermanos',
            'Children of full siblings' => 'Hijos de los hermanos mayores',
            'Siblings\' stepchildren' => 'Hijastros de hermanos',
            'Children of siblings of partners' => 'Hijos de los hermanos del cónyuge',
            'Biological children' => 'Hijos biol&oacute;gicos',
            'Stepchildren' => 'Hijastros',
            'Stepchild' => 'Hijastras',
            'Stepson' => 'Hijastro',
            'Stepdaughter' => 'Hijastra',
            'Partners of biological children' => 'Cónyuges de los hijos biol&oacute;gicos',
            'Partners of stepchildren' => 'Cónyuge de hijastros',
            'Biological grandchildren' => 'Nietos biol&oacute;gicos',
            'Stepchildren of children' => 'Hijastros/as',
            'Children of stepchildren' => 'Hijos de hijastros/as',
            'Stepchildren of stepchildren' => 'Hijastro/a de hijastros',
            'Partners of biological grandchildren' => 'Parejas de los nietos biol&oacute;gicos',
            'Partners of stepchildren of children' => 'Parejas de los hijos de los nietos',
            'Partners of children of stepchildren' => 'Parejas de los hijos de hijastros',
            'Partners of stepchildren of stepchildren' => 'Parejas de los hijastros',

            'He' => 'él',
            'She' => 'ella',
            'He/she' => 'él/ella',
            'Mr.' => 'Sr.',
            'Mrs.' => 'Sra.',
            'No family available' => 'No hay familia disponible',
            'Summary for the shown extended family' => 'Summary for the shown extended family',
            'The extended family of %1$s has one member.' . I18N::PLURAL . 'The extended family of %1$s has %2$d members.'
            => 'The extended family of %1$s has one member.' . I18N::PLURAL . 'The extended family of %1$s has %2$d members.',
            '%s has no %s recorded.' => '%s no tiene %s registrados.',
            '%s has no %s, and no %s recorded.' => '%s no tiene %s ni %s registrados.',

            'Father\'s family (%d)' => 'Familia del padre (%d)',
            'Mother\'s family (%d)' => 'Familia de la madre (%d)',
            'Father\'s and Mother\'s family (%d)' => 'Familia del padre y de la Madre (%d)',
            'Grandparents %1$s (%2$s) of stepfather %3$s' => 'Abuelos %1$s (%2$s) del padrasto %3$s',
            'Grandparents %1$s (%2$s) of stepmother %3$s' => 'Abuelos %1$s (%2$s) de la madrasta %3$s',
            'Grandparents %1$s (%2$s) of stepparent %3$s' => 'Abuelos %1$s (%2$s) del padrasto %3$s',
            'Stepparents %1$s (%2$s) of %3$s' => 'Padrastros %1$s (%2$s) de %3$s',
            'Parents %1$s (%2$s) of stepfather %3$s' => 'Padres %1$s (%2$s) del padrasto %3$s',
            'Parents %1$s (%2$s) of stepmother %3$s' => 'Padres %1$s (%2$s) de la madrasta %3$s',
            'Parents %1$s (%2$s) of stepparent %3$s' => 'Padres %1$s (%2$s) del padrasto %3$s',
            'Parents %1$s of %2$s' => 'Padres %1$s de %2$s',
            'Parents %1$s (%2$s) of %3$s' => 'Padres %1$s (%2$s) de %3$s',
            'Partners of %s' => 'Cónyuge de %s',
            'Brother %1$s of partner %2$s' => 'Hermano %1$s de Cónyuge %2$s',
            'Sister %1$s of partner %2$s' => 'Hermana %1$s de Cónyuge %2$s',
            'Sibling %1$s of partner %2$s' => 'Hermanos %1$s de Cónyuge %2$s',

            'Great-grandparents' => 'Bisabuelos y Bisabuelas',
            '%s has no great-grandparents recorded.' => '%s no tiene bisabuelos registrados.',
            '%s has one great-grandmother recorded.' => '%s tiene una bisabuela registrada',
            '%s has one great-grandfather recorded.' => '%s tiene un bisabuelo registrado.',
            '%s has one great-grandparent of unknown sex recorded.' => '%s tiene un bisabuelo/a registrado.',
            '%2$s has %1$d great-grandmother recorded.' . I18N::PLURAL . '%2$s tiene %1$d bisabuelas registradas.'
            => '%2$s tiene %1$d bisabuela.' . I18N::PLURAL . '%2$s tiene %1$d bisabuelas registradas.',
            '%2$s has %1$d great-grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandfathers recorded.'
            => '%2$s tiene %1$d bisabuelo registrado.' . I18N::PLURAL . '%2$s tiene %1$d bisabuelos registrados.',
            '%2$s has %1$d great-grandparent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandparents of unknown sex recorded.'
            => '%2$s tiene %1$d bisabuelo/a registrado.' . I18N::PLURAL . '%2$s tiene %1$d bisabuelos/as registrados/as.',
            '%2$s has %1$d great-grandfather and ' . I18N::PLURAL . '%2$s has %1$d great-grandfathers and '
            => '%2$s tiene %1$d bisabuelo y ' . I18N::PLURAL . '%2$s tiene %1$d bisabuelos y ',
            '%d great-grandmother recorded (%d in total).' . I18N::PLURAL . '%d great-grandmothers recorded (%d in total).'
            => '%d tiene bisabuela resgistrada (%d del total).' . I18N::PLURAL . '%d bisabuelas registradas (%d del total).',
            '%2$s has %1$d great-grandmother and ' . I18N::PLURAL . '%2$s has %1$d great-grandmothers and '
            => '%2$s tiene %1$d bisabuela y ' . I18N::PLURAL . '%2$s tiene %1$d bisabuelos y ',
            '%d great-grandparent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d great-grandparents of unknown sex recorded (%d in total).'
            => '%d tiene bisabuelo/a (%d en total).' . I18N::PLURAL . '%d son bisabuelos/as registrados/as (%d en total).',
            '%2$s has %1$d great-grandfather, ' . I18N::PLURAL . '%2$s has %1$d great-grandfathers, '
            => '%2$s tiene %1$d bisabuelo, ' . I18N::PLURAL . '%2$s tiene %1$d bisabuelos, ',
            '%d great-grandmother, and ' . I18N::PLURAL . '%d great-grandmothers, and '
            => '%d tiene bisabuela y ' . I18N::PLURAL . '%d son los bisabuelos y ',

            'Grandparents' => 'Abuelos y Abuelas',
            '%s has no grandparents recorded.' => '%s no tiene abuelos registrados.',
            '%s has one grandmother recorded.' => '%s tiene una abuela registrada.',
            '%s has one grandfather recorded.' => '%s tiene un abuelo registrado.',
            '%s has one grandparent of unknown sex recorded.' => '%s tiene registrado/a un abuelo/a.',
            '%2$s has %1$d grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d grandmothers recorded.'
            => '%2$s tiene %1$d abuela registrada.' . I18N::PLURAL . '%2$s tiene %1$d abuelas registradas.',
            '%2$s has %1$d grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d grandfathers recorded.'
            => '%2$s tiene %1$d abuelo registrado.' . I18N::PLURAL . '%2$s tiene %1$d abuelos registrados.',
            '%2$s has %1$d grandparent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandparents of unknown sex recorded.'
            => '%2$s tiene %1$d abuelo/a registrado/a.' . I18N::PLURAL . '%2$s tiene %1$d abuelos/as registrados/as.',
            '%2$s has %1$d grandfather and ' . I18N::PLURAL . '%2$s has %1$d grandfathers and '
            => '%2$s tiene %1$d abuelo y ' . I18N::PLURAL . '%2$s tiene %1$d abuelos y ',
            '%d grandmother recorded (%d in total).' . I18N::PLURAL . '%d grandmothers recorded (%d in total).'
            => '%d abuela registrado/a (%d en total).' . I18N::PLURAL . '%d abuelas registrados/as (%d en total).',
            '%2$s has %1$d grandmother and ' . I18N::PLURAL . '%2$s has %1$d grandmothers and '
            => '%2$s tiene %1$d abuela y ' . I18N::PLURAL . '%2$s son %1$d abuelas y ',
            '%d grandparent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandparents of unknown sex recorded (%d in total).'
            => '%d es abuelo/a registrado/a (%d en total).' . I18N::PLURAL . '%d Abuelos/as registrados/as (%d en total).',
            '%2$s has %1$d grandfather, ' . I18N::PLURAL . '%2$s has %1$d grandfathers, '
            => '%2$s tiene %1$d abuelo, ' . I18N::PLURAL . '%2$s tiene %1$d abuelos, ',
            '%d grandmother, and ' . I18N::PLURAL . '%d grandmothers, and '
            => '%d abuela y ' . I18N::PLURAL . '%d abuelas y ',

            'Uncles and Aunts' => 'Tíos y Tías',
            '%s has no uncles or aunts recorded.' => '%s no tiene tíos registrados.',
            '%s has one aunt recorded.' => '%s tiene una tía registrados.',
            '%s has one uncle recorded.' => '%s tiene un tío registrados.',
            '%s has one uncle or aunt of unknown sex recorded.' => '%s tiene un tío o tía registrado/a.',
            '%2$s has %1$d aunt recorded.' . I18N::PLURAL . '%2$s has %1$d aunts recorded.'
            => '%2$s tiene %1$d tía registrada.' . I18N::PLURAL . '%2$s tiene %1$d tías registradas.',
            '%2$s has %1$d uncle recorded.' . I18N::PLURAL . '%2$s has %1$d uncles recorded.'
            => '%2$s tiene %1$d tío registrado.' . I18N::PLURAL . '%2$s tiene %1$d tíos registrados.',
            '%2$s has %1$d uncle or aunt of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d uncles or aunts of unknown sex recorded.'
            => '%2$s tiene %1$d  tío/a registrado/a.' . I18N::PLURAL . '%2$s tiene %1$d tíos/as registrados/as.',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and '
            => '%2$s tiene %1$d tío y ' . I18N::PLURAL . '%2$s tiene %1$d tíos y ',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).'
            => '%d tía registrados/as (%d en total).' . I18N::PLURAL . '%d tías registrados/as (%d en total).',
            '%2$s has %1$d aunt and ' . I18N::PLURAL . '%2$s has %1$d aunts and '
            => '%2$s tiene %1$d tía ' . I18N::PLURAL . '%2$s tiene %1$d tías y ',
            '%d uncle or aunt of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d uncles or aunts of unknown sex recorded (%d in total).'
            => '%d tío/a registrado/a (%d en total).' . I18N::PLURAL . '%d tíos/as registrados/as (%d en total).',
            '%2$s has %1$d uncle, ' . I18N::PLURAL . '%2$s has %1$d uncles, '
            => '%2$s tiene %1$d tío' . I18N::PLURAL . '%2$s tiene %1$d tíos ',
            '%d aunt, and ' . I18N::PLURAL . '%d aunts, and '
            => '%d tia y ' . I18N::PLURAL . '%d tías y ',

            'Uncles and Aunts by marriage' => 'Tíos y tías políticos/as',
            '%s has no uncles or aunts by marriage recorded.' => '%s no tiene tíos políticos registrados.',
            '%s has one aunt by marriage recorded.' => '%s tiene una tía política registrada.',
            '%s has one uncle by marriage recorded.' => '%s tiene un tío político registrado.',
            '%s has one uncle or aunt by marriage of unknown sex recorded.' => '%s tiene un tío/a político/a registrado/a.',
            '%2$s has %1$d aunt by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d aunts by marriage recorded.'
            => '%2$s tiene %1$d tía política registrada.' . I18N::PLURAL . '%2$s tiene %1$d tías políticas registradas.',
            '%2$s has %1$d uncle by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d uncles by marriage recorded.'
            => '%2$s tiene %1$d tío político registrado.' . I18N::PLURAL . '%2$s tiene %1$d tíos políticos registrados/as.',
            '%2$s has %1$d uncle or aunt by marriage of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d uncles or aunts by marriage of unknown sex recorded.'
            => '%2$s tiene %1$d tío/a político/a.' . I18N::PLURAL . '%2$s tiene %1$d tíos/as políticos/as.',
            '%2$s has %1$d uncle by marriage and ' . I18N::PLURAL . '%2$s has %1$d uncles by marriage and '
            => '%2$s tiene %1$d tío político y ' . I18N::PLURAL . '%2$s tiene %1$d tíos políticos y ',
            '%d aunt by marriage recorded (%d in total).' . I18N::PLURAL . '%d aunts by marriage recorded (%d in total).'
            => '%d tía política registrados (%d en total).' . I18N::PLURAL . '%d tías políticas registrados/as (%d en total).',
            '%2$s has %1$d aunt by marriage and ' . I18N::PLURAL . '%2$s has %1$d aunts by marriage and '
            => '%2$s tiene %1$d tía política y ' . I18N::PLURAL . '%2$s tiene %1$d tías políticas y ',
            '%d uncle or aunt by marriage of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d uncles or aunts by marriage of unknown sex recorded (%d in total).'
            => '%d Tío/a político/a (%d en total).' . I18N::PLURAL . '%d Tíos/as políticos/as resgistrados/as (%d en total).',
            '%2$s has %1$d uncle by marriage, ' . I18N::PLURAL . '%2$s has %1$d uncles by marriage, '
            => '%2$s tiene %1$d tío político, ' . I18N::PLURAL . '%2$s tiene %1$d tíos políticos ',
            '%d aunt by marriage, and ' . I18N::PLURAL . '%d aunts by marriage, and '
            => '%d tía política y ' . I18N::PLURAL . '%d tías políticas y  ',

            'Parents' => 'Padres y Madres',
            '%s has no parents recorded.' => '%s no tiene padres registrados.',
            '%s has one mother recorded.' => '%s tiene una madre registrada.',
            '%s has one father recorded.' => '%s tiene un padre registrado.',
            '%s has one parent of unknown sex recorded.' => 'tiene registrado un progenitor/a.',
            '%2$s has %1$d mother recorded.' . I18N::PLURAL . '%2$s has %1$d mothers recorded.'
            => '%2$s tiene %1$d madre registrada.' . I18N::PLURAL . '%2$s tiene %1$d madres registradas.',
            '%2$s has %1$d father recorded.' . I18N::PLURAL . '%2$s has %1$d fathers recorded.'
            => '%2$s tiene %1$d padre registrado.' . I18N::PLURAL . '%2$s tiene %1$d padres registrados.',
            '%2$s has %1$d parent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d parents of unknown sex recorded.'
            => '%2$s tiene %1$d padre/madre registrado/a.' . I18N::PLURAL . '%2$s tiene %1$d padres/madres registrados/as.',
            '%2$s has %1$d father and ' . I18N::PLURAL . '%2$s has %1$d fathers and '
            => '%2$s tiene %1$d padre y ' . I18N::PLURAL . '%2$s tiene %1$d padres y ',
            '%d mother recorded (%d in total).' . I18N::PLURAL . '%d mothers recorded (%d in total).'
            => '%d madre registrados/as (%d en total).' . I18N::PLURAL . '%d madres registradas (%d en total).',
            '%2$s has %1$d mother and ' . I18N::PLURAL . '%2$s has %1$d mothers and '
            => '%2$s tiene %1$d madre y ' . I18N::PLURAL . '%2$s tiene %1$d madres y ',
            '%d parent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d parents of unknown sex recorded (%d in total).'
            => '%d padre/madre registrado/a (%d en total).' . I18N::PLURAL . '%d padres/madres registrados/as (%d en total).',
            '%2$s has %1$d father, ' . I18N::PLURAL . '%2$s has %1$d fathers, '
            => '%2$s tiene %1$d padre, ' . I18N::PLURAL . '%2$s tiene %1$d padres, ',
            '%d mother, and ' . I18N::PLURAL . '%d mothers, and '
            => '%d la madre y ' . I18N::PLURAL . '%d las madres y ',

            'Parents-in-law' => 'Suegros y Suegras',
            '%s has no parents-in-law recorded.' => '%s no tiene suegros registrados.',
            '%s has one mother-in-law recorded.' => '%s tiene una suegra registrada.',
            '%s has one father-in-law recorded.' => '%s tiene un suegro registrado.',
            '%s has one parent-in-law of unknown sex recorded.' => '%s tien un suegro/a registrado/a.',
            '%2$s has %1$d mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d mothers-in-law recorded.'
            => '%2$s tiene %1$d suegra registrado/a.' . I18N::PLURAL . '%2$s tiene %1$d suegras registrados.',
            '%2$s has %1$d father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d fathers-in-law recorded.'
            => '%2$s tiene %1$d suegro registrado.' . I18N::PLURAL . '%2$s tiene %1$d suegros registrados.',
            '%2$s has %1$d parent-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d parents-in-law of unknown sex recorded.'
            => '%2$s tiene %1$d suegro/a registrado/a.' . I18N::PLURAL . '%2$s tiene %1$d suegros/as registrados/as.',
            '%2$s has %1$d father-in-law and ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law and '
            => '%2$s tiene %1$d suegro y ' . I18N::PLURAL . '%2$s tiene %1$d suegros y ',
            '%d mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d mothers-in-law recorded (%d in total).'
            => '%d suegra registrada (%d en total).' . I18N::PLURAL . '%d suegras registradas (%d en total).',
            '%2$s has %1$d mother-in-law and ' . I18N::PLURAL . '%2$s has %1$d mothers-in-law and '
            => '%2$s tiene %1$d suegra registrada y ' . I18N::PLURAL . '%2$s tiene %1$d suegras y ',
            '%d parent-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d parents-in-law of unknown sex recorded (%d in total).'
            => '%d suegro/a registrado/a (%d en total).' . I18N::PLURAL . '%d suegros/as registrados/as (%d en total).',
            '%2$s has %1$d father-in-law, ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law, '
            => '%2$s tiene %1$d suegro registrado, ' . I18N::PLURAL . 'Para %2$s tiene %1$d suegros registrados,',
            '%d mother-in-law, and ' . I18N::PLURAL . '%d mothers-in-law, and '
            => '%d es suegra y ' . I18N::PLURAL . '%d tiene %1$d suegras y ',

            'Co-parents-in-law' => 'Consuegros y Consuegras',
            '%s has no co-parents-in-law recorded.' => '%s no tiene consuegros registrados.',
            '%s has one co-mother-in-law recorded.' => '%s tiene una consuegra registrada.',
            '%s has one co-father-in-law recorded.' => '%s tiene un consuegro registrado.',
            '%s has one co-parent-in-law of unknown sex recorded.' => 'tiene registrado un consuegro/a.',
            '%2$s has %1$d co-mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law recorded.'
            => '%2$s tiene %1$d consuegra registrada.' . I18N::PLURAL . '%2$s tiene %1$d consuegras registradas.',
            '%2$s has %1$d co-father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law recorded.'
            => '%2$s tiene %1$d consuegro registrado.' . I18N::PLURAL . '%2$s tiene %1$d consuegros registrados.',
            '%2$s has %1$d co-parent-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d co-parents-in-law of unknown sex recorded.'
            => '%2$s tiene registrado a %1$d consuegros.' . I18N::PLURAL . '%2$s tiene registrados %1$d consuegros.',
            '%2$s has %1$d co-father-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law and '
            => '%2$s tiene %1$d consuegro y ' . I18N::PLURAL . '%2$s tiene %1$d consuegros y ',
            '%d co-mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-mothers-in-law recorded (%d in total).'
            => '%d consuegra registrado/a (%d en total).' . I18N::PLURAL . '%d consuegras registrados/as (%d en total).',
            '%2$s has %1$d co-mother-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law and '
            => '%2$s tiene %1$d consuegra y ' . I18N::PLURAL . '%2$s tiene %1$d consuegras y ',
            '%d co-parent-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d co-parents-in-law of unknown sex recorded (%d in total).'
            => '%d suegros registrados (%d en total).' . I18N::PLURAL . '%d consuegros registrados(%d en total).',
            '%2$s has %1$d co-father-in-law, ' . I18N::PLURAL . '%2$ has %1$d co-fathers-in-law, '
            => '%2$s tiene %1$d consuegro, ' . I18N::PLURAL . '%2$s tiene %1$d consuegros, ',
            '%d co-mother-in-law, and ' . I18N::PLURAL . '%d co-mothers-in-law, and '
            => '%d consuegra y ' . I18N::PLURAL . '%d consuegras y ',

            'Partners' => 'Cónyuge',
            'Partner of ' => 'Cónyuge de ',
            '%s has no partners recorded.' => '%s no tiene cónyuge registrado.',
            '%s has one female partner recorded.' => '%s tiene un cónyuge registrado.',
            '%s has one male partner recorded.' => '%s tiene un cónyuge registrado.',
            '%s has one partner of unknown sex recorded.' => '%s tiene registrada un cónyuge de sexo no identificado.',
            '%2$s has %1$d female partner recorded.' . I18N::PLURAL . '%2$s has %1$d female partners recorded.'
            => '%2$s tiene %1$d cónyuge registrado.' . I18N::PLURAL . '%2$s tiene %1$d cónyuges registrados.',
            '%2$s has %1$d male partner recorded.' . I18N::PLURAL . '%2$s has %1$d male partners recorded.'
            => '%2$s tiene %1$d cónyuge registrado.' . I18N::PLURAL . '%2$s tiene %1$d cónyuges registrados.',
            '%2$s has %1$d partner of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d partners of unknown sex recorded.'
            => '%2$s tiene registrada a %1$d como pareja de sexo no identificado.' . I18N::PLURAL . '%2$s tiene registradas %1$d parejas de sexo no identificado.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and '
            => '%2$s tiene %1$d cónyuge y ' . I18N::PLURAL . '%2$s tiene %1$d cónyuges y ',
            '%2$s has %1$d female partner and ' . I18N::PLURAL . '%2$s has %1$d female partners and '
            => '%2$s tiene %1$d cónyuge y ' . I18N::PLURAL . '%2$s tiene %1$d cónyuges y ',
            '%d female partner recorded (%d in total).' . I18N::PLURAL . '%d female partners recorded (%d in total).'
            => '%d cónyuge registrado (%d en total).' . I18N::PLURAL . '%d cónyuges registrados (%d en total).',
            '%2$s has %1$d partner and ' . I18N::PLURAL . '%2$s has %1$d partners and '
            => '%2$s tiene %1$d cónyuge y ' . I18N::PLURAL . '%2$s tiene %1$d cónyuges y ',
            '%d male partner of female partners recorded (%d in total).' . I18N::PLURAL . '%d male partners of female partners recorded (%d in total).'
            => '%d cónyuge registrado (%d en total).' . I18N::PLURAL . '%d cónyuges registrados (%d en total).',
            '%d female partner of male partners recorded (%d in total).' . I18N::PLURAL . '%d female partners of male partners recorded (%d in total).'
            => '%d cónyuge registrado (%d en total).' . I18N::PLURAL . '%d cónyuges registrados (%d en total).',

            'Partner chains' => 'cadena de miembros familiares',
            '%s has no members of a partner chain recorded.' => '%s no tiene registrados miembros en la cadena familiar.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and '
            => '%2$s tiene a %1$d como pareja mascualina y ' . I18N::PLURAL . '%2$s tiene a %1$d como parejas mascualinas y ',
            '%d female partner in this partner chain recorded (%d in total).' . I18N::PLURAL . '%d female partners in this partner chain recorded (%d in total).'
            => '%d es pareja femenina en esta cadena de pareja registrada (%d en total).' . I18N::PLURAL . '%d parejas femeninas en esta cadena de parejas registradas (%d en total).',
            '%d female partner and ' . I18N::PLURAL . '%d female partners and '
            => '%d pareja femenina y ' . I18N::PLURAL . '%d female partner and',
            '%d partner of unknown sex in this partner chain recorded (%d in total).' . I18N::PLURAL . '%d partners of unknown sex in this partner chain recorded (%d in total).'
            => '%d pareja de sexo no identificado en esta cadena de pareja registrada(%d).' . I18N::PLURAL . '%d parejas de sexo no identificado en esta cadena de parejas registradas (%d en total).',
            '%2$s has %1$d female partner and ' . I18N::PLURAL . '%2$s has %1$d female partners and '
            => '%2$s tiene a %1$d pareja femenina y ' . I18N::PLURAL . '%2$s tiene a %1$d parejas femeninas y ',
            '%d partner of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d partners of unknown sex recorded (%d in total).'
            => '%d pareja registrada con sexo no identificado(%d en total ).' . I18N::PLURAL . '%d parejas registradas de sexno no identificado (%d en total).',
            '%2$s has %1$d male partner, ' . I18N::PLURAL . '%2$s has %1$d male partners, '
            => '%2$s tiene a %1$d como pareja masculina, ' . I18N::PLURAL . '%2$s tiene %1$d parejas masculinas, ',
            '%d female partner, and ' . I18N::PLURAL . '%d female partners, and '
            => '%d pareja femenina y ' . I18N::PLURAL . '%d parejas femeninas y ',
            'There are %d branches in the partner chain. ' => 'Hay ramificaciones en la cadena de miembros.',
            'The longest branch in the partner chain to %2$s consists of %1$d partners (including %3$s).' => 'La rama m᳠larga de la cadena de miembros de %2$s consta de %1$d individuos (incluyendo %3$s).',
            'The longest branch in the partner chain consists of %1$d partners (including %2$s).' => 'La rama m᳠larga de la cadena de miembros estᠦormada por %1$d individuos (incluyendo %2$s).',

            'Siblings' => 'Hermanos y Hermanas',
            '%s has no siblings recorded.' => '%s no tiene hermanos/as registrados.',
            '%s has one sister recorded.' => '%s tiene una hermana registrada.',
            '%s has one brother recorded.' => '%s tiene un  hermano registrado.',
            '%s has one sibling of unknown sex recorded.' => '%s tiene un hermano/a registrados',
            '%2$s has %1$d sister recorded.' . I18N::PLURAL . '%2$s has %1$d sisters recorded.'
            => '%2$s tiene %1$d hermana registrada.' . I18N::PLURAL . '%2$s tiene %1$d hermanas registradas.',
            '%2$s has %1$d brother recorded.' . I18N::PLURAL . '%2$s has %1$d brothers recorded.'
            => '%2$s tiene %1$d hermano registrado.' . I18N::PLURAL . '%2$s tiene %1$d hermanos registrados.',
            '%2$s has %1$d sibling of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d siblings of unknown sex recorded.'
            => '%2$s tiene a %1$d de hermano/a.' . I18N::PLURAL . '%2$s tiene %1$d hermanos/as registrados.',
            '%2$s has %1$d brother and ' . I18N::PLURAL . '%2$s has %1$d brothers and '
            => '%2$s tiene %1$d hermano y ' . I18N::PLURAL . '%2$s tiene %1$d hermanos y ',
            '%d sister recorded (%d in total).' . I18N::PLURAL . '%d sisters recorded (%d in total).'
            => '%d hermana registrados (%d en total).' . I18N::PLURAL . '%d hermanas registrados/as (%d en total).',
            '%2$s has %1$d sister and ' . I18N::PLURAL . '%2$s has %1$d sisters and '
            => '%2$s tiene a %1$d como hermana y ' . I18N::PLURAL . '%2$s tiene %1$d hermanas y ',
            '%d sibling of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d siblings of unknown sex recorded (%d in total).'
            => '%d hermano/a registrado (%d en total).' . I18N::PLURAL . '%d hermanos/as registrados %d en total).',
            '%2$s has %1$d brother, ' . I18N::PLURAL . '%2$s has %1$d brothers, '
            => '%2$s tiene a %1$d de hermano, ' . I18N::PLURAL . '%2$s tiene %1$d hermanos, ',
            '%d sister, and ' . I18N::PLURAL . '%d sisters, and '
            => '%d hermana y ' . I18N::PLURAL . '%d hermanas y ',

            'Siblings-in-law' => 'Cuñados y Cuñadas',
            '%s has no siblings-in-law recorded.' => '%s no tiene cuñados/as registrados.',
            '%s has one sister-in-law recorded.' => '%s tiene una cuñada registrada.',
            '%s has one brother-in-law recorded.' => '%s un cuñado registrado.',
            '%s has one sibling-in-law of unknown sex recorded.' => '%s tiene un cuñado/a registrado.',
            '%2$s has %1$d sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sisters-in-law recorded.'
            => '%2$s tiene %1$d cuñada registrada.' . I18N::PLURAL . '%2$s tiene %1$d cuñadas registradas.',
            '%2$s has %1$d brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d brothers-in-law recorded.'
            => '%2$s tiene %1$d cuñado registrado.' . I18N::PLURAL . '%2$s tiene %1$d cuñados registrados.',
            '%2$s has %1$d sibling-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d siblings-in-law of unknown sex recorded.'
            => '%2$s tiene registrado %1$d cuñado/a.' . I18N::PLURAL . '%2$s tiene %1$d suegos/asregistrados.',
            '%2$s has %1$d brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law and '
            => '%2$s tiene %1$d cuñado y ' . I18N::PLURAL . '%2$s tiene %1$d cuñados y ',
            '%d sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d sisters-in-law recorded (%d in total).'
            => '%d cuñada registrado/a (%d en total).' . I18N::PLURAL . '%d cuñadas registrados/as (%d en total).',
            '%2$s has %1$d sister-in-law and ' . I18N::PLURAL . '%2$s has %1$d sisters-in-law and '
            => '%2$s tiene %1$d cuñada y ' . I18N::PLURAL . '%2$s tiene %1$d cuñadas y ',
            '%d sibling-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d siblings-in-law of unknown sex recorded (%d in total).'
            => '%d suegros/as registradas(%d en total).' . I18N::PLURAL . '%d cuñados/as registrados(%d en total).',
            '%2$s has %1$d brother-in-law, ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law, '
            => '%2$s tiene %1$d de cuñado, ' . I18N::PLURAL . '%2$s tiene %1$d cuñados, ',
            '%d sister-in-law, and ' . I18N::PLURAL . '%d sisters-in-law, and '
            => '%d cuñada, y ' . I18N::PLURAL . '%d cuñadas, y ',

            'Co-siblings-in-law' => 'Concuñados y Concuñadas',
            '%s has no co-siblings-in-law recorded.' => '%s no tiene concuñados/as registrados.',
            '%s has one co-sister-in-law recorded.' => '%s tiene una concuñada registrada.',
            '%s has one co-brother-in-law recorded.' => '%s un concuñado registrado.',
            '%s has one co-sibling-in-law of unknown sex recorded.' => '%s tiene un concuñado/a registrado.',
            '%2$s has %1$d co-sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-sisters-in-law recorded.'
            => '%2$s tiene %1$d concuñada registrada.' . I18N::PLURAL . '%2$s tiene %1$d concuñadas registradas.',
            '%2$s has %1$d co-brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law recorded.'
            => '%2$s tiene %1$d concuñado registrado.' . I18N::PLURAL . '%2$s tiene %1$d concuñados registrados.',
            '%2$s has %1$d co-sibling-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d co-siblings-in-law of unknown sex recorded.'
            => '%2$s tiene %1$d concuñados/as.' . I18N::PLURAL . '%2$s tiene %1$d cuñados/as.',
            '%2$s has %1$d co-brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law and '
            => '%2$s tiene %1$d concuñado y ' . I18N::PLURAL . '%2$s tiene %1$d concuñados y ',
            '%d co-sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-sisters-in-law recorded (%d in total).'
            => '%d concuñada (%d en total).' . I18N::PLURAL . '%d concuñadas registrados/as (%d en total).',
            '%2$s has %1$d co-sister-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-sisters-in-law and '
            => '%2$s tiene %1$d concuñada y ' . I18N::PLURAL . '%2$s tiene %1$d concuñadas y ',
            '%d co-sibling-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d co-siblings-in-law of unknown sex recorded (%d in total).'
            => '%d concuñados/as registrados (%d en total).' . I18N::PLURAL . '%d cuñados/as registrados(%d en total).',
            '%2$s has %1$d co-brother-in-law, ' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law, '
            => '%2$s tiene %1$d concuñado, ' . I18N::PLURAL . '%2$s tiene %1$d concuñados, ',
            '%d co-sister-in-law, and ' . I18N::PLURAL . '%d co-sisters-in-law, and '
            => '%d concuñada, y ' . I18N::PLURAL . '%d concuñadas, y und ',

            'Cousins' => 'Primos y Primas',
            '%s has no first cousins recorded.' => '%s no tiene primos ni primas registrados/as.',
            '%s has one female first cousin recorded.' => '%s tiene una prima registrada.',
            '%s has one male first cousin recorded.' => '%s tiene un primo registrado.',
            '%s has one first cousin of unknown sex recorded.' => '%s tiene un primo/a registrado/a.',
            '%2$s has %1$d female first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d female first cousins recorded.'
            => '%2$s tiene %1$d prima registrada.' . I18N::PLURAL . '%2$s tiene %1$d pºrimas registrados/as.',
            '%2$s has %1$d male first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d male first cousins recorded.'
            => '%2$s tiene %1$d primo registrado.' . I18N::PLURAL . '%2$s tiene %1$d primos registrados.',
            '%2$s has %1$d first cousin of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d first cousins of unknown sex recorded.'
            => '%2$s tiene registrado %1$d primo/a hermano/a.' . I18N::PLURAL . '%2$s tiene registrados %1$d primos/as hermanos/as',
            '%2$s has %1$d male first cousin and ' . I18N::PLURAL . '%2$s has %1$d male first cousins and '
            => '%2$s tiene %1$d primo y ' . I18N::PLURAL . '%2$s tiene %1$d primos y ',
            '%d female first cousin recorded (%d in total).' . I18N::PLURAL . '%d female first cousins recorded (%d in total).'
            => '%d prima registrada (%d en total).' . I18N::PLURAL . '%d Primas registradas (%d en total).',
            '%2$s has %1$d female first cousin and ' . I18N::PLURAL . '%2$s has %1$d female first cousins and '
            => '%2$s tiene %1$d prima hermana y ' . I18N::PLURAL . '%2$s tiene %1$d primas hermanas y ',
            '%d first cousin of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d first cousins of unknown sex recorded (%d in total).'
            => '%d primo/a hermano/a registrados/as (%d en total).' . I18N::PLURAL . '%d primos/as hermanos/as registrados/as (%d en total).',
            '%2$s has %1$d male first cousin, ' . I18N::PLURAL . '%2$s has %1$d male first cousins, '
            => '%2$s tiene a %1$d primo hermano, ' . I18N::PLURAL . '%2$s tiene %1$d primos hermanos, ',
            '%d female first cousin, and ' . I18N::PLURAL . '%d female first cousins, and '
            => '%d prima hermana, y ' . I18N::PLURAL . '%d primas hermanas, y ',

            'Nephews and Nieces' => 'Sobrinos y Sobrinas',
            '%s has no nephews or nieces recorded.' => '%s no tiene sobrinos ni sobrinas registrados.',
            '%s has one niece recorded.' => '%s tiene una sobrina registrada.',
            '%s has one nephew recorded.' => '%s tiene un sobrino registrado.',
            '%s has one nephew or niece of unknown sex recorded.' => '%s tiene una sobrina/o registrado/a.',
            '%2$s has %1$d niece recorded.' . I18N::PLURAL . '%2$s has %1$d nieces recorded.'
            => '%2$s tiene %1$d sºobrina registrada.' . I18N::PLURAL . '%2$s tiene %1$d sobrinas registradas.',
            '%2$s has %1$d nephew recorded.' . I18N::PLURAL . '%2$s has %1$d nephews recorded.'
            => '%2$s tiene %1$d sobrino registrado.' . I18N::PLURAL . '%2$s tiene %1$d sobrinos registrados.',
            '%2$s has %1$d nephew or niece of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d nephews or nieces of unknown sex recorded.'
            => '%2$s tiene %1$d sobrino/a registrado/a.' . I18N::PLURAL . '%2$s tienend %1$d sobrinos/as registrados/as.',
            '%2$s has %1$d nephew and ' . I18N::PLURAL . '%2$s has %1$d nephews and '
            => '%2$s tiene %1$d sobrino y ' . I18N::PLURAL . '%2$s tiene %1$d sobrinos y ',
            '%d niece recorded (%d in total).' . I18N::PLURAL . '%d nieces recorded (%d in total).'
            => '%d sobrina registrados/as (%d en total).' . I18N::PLURAL . '%d sobrinas registradas (%d en total).',
            '%2$s has %1$d niece and ' . I18N::PLURAL . '%2$s has %1$d nieces and '
            => '%2$s tiene %1$d sobrina y ' . I18N::PLURAL . '%2$s tiene %1$d sobrinas y ',
            '%d nephew or niece of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d nephews or nieces of unknown sex recorded (%d in total).'
            => '%d sobrino/a registrado/a (%d en total).' . I18N::PLURAL . '%d sobrinos/as registrados/as (%d en total).',
            '%2$s has %1$d nephew, ' . I18N::PLURAL . '%2$s has %1$d nephews, '
            => '%2$s tiene %1$d sobrino, ' . I18N::PLURAL . '%2$s tiene %1$d sobrinos, ',
            '%d niece, and ' . I18N::PLURAL . '%d nieces, and '
            => '%d sobrina, y ' . I18N::PLURAL . '%d sobrinas, y ',

            'Children' => 'Hijos e Hijas',
            '%s has no children recorded.' => '%s no tiene hijos registrados.',
            '%s has one daughter recorded.' => '%s tiene una hija registrado.',
            '%s has one son recorded.' => '%s tiene un hijo registrado.',
            '%s has one child of unknown sex recorded.' => '%s tiene un hijo o hija registrados.',
            '%2$s has %1$d daughter recorded.' . I18N::PLURAL . '%2$s has %1$d daughters recorded.'
            => '%2$s tiene %1$d hija registrada.' . I18N::PLURAL . '%2$s tiene %1$d hijas registradas.',
            '%2$s has %1$d son recorded.' . I18N::PLURAL . '%2$s has %1$d sons recorded.'
            => '%2$s tiene %1$d hijo registrado.' . I18N::PLURAL . '%2$s tiene %1$d hijos registrados.',
            '%2$s has %1$d child of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d children of unknown sex recorded.'
            => '%2$s tiene %1$d hijo/a registrado/a.' . I18N::PLURAL . '%2$s tiene %1$d hijos/as registrados/as.',
            '%2$s has %1$d son and ' . I18N::PLURAL . '%2$s has %1$d sons and '
            => '%2$s tiene %1$d hijo y ' . I18N::PLURAL . '%2$s tiene %1$d hijos y ',
            '%d daughter recorded (%d in total).' . I18N::PLURAL . '%d daughters recorded (%d in total).'
            => '%d Hija registrados (%d en total).' . I18N::PLURAL . '%d Hijas registrados (%d en total).',
            '%2$s has %1$d daughter and ' . I18N::PLURAL . '%2$s has %1$d daughters and '
            => '%2$s tine %1$d hija y ' . I18N::PLURAL . '%2$s tiene %1$d hijas y ',
            '%d child of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d children of unknown sex recorded (%d in total).'
            => '%d niño/a registrado/a (%d en total).' . I18N::PLURAL . '%d niños/as registrados/as (%d en total).',
            '%2$s has %1$d son, ' . I18N::PLURAL . '%2$s has %1$d sons, '
            => '%2$s tiene %1$d hijo, ' . I18N::PLURAL . '%2$s tiene %1$d hijos, ',
            '%d daughter, and ' . I18N::PLURAL . '%d daughters, and '
            => '%d hija, y ' . I18N::PLURAL . '%d hijas, y ',

            'Children-in-law' => 'Hijos/as políticos/as (Yerno/Nuera)',
            '%s has no children-in-law recorded.' => '%s no tienes hijos políticos (yernos) registrados.',
            '%s has one daughter-in-law recorded.' => '%s tiene una hija política (nuera) registrada.',
            '%s has one son-in-law recorded.' => '%s tiene un hijo político (yerno) registrado.',
            '%s has one child-in-law of unknown sex recorded.' => '%s tiene un hijo/a político/a registrado.',
            '%2$s has %1$d daughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d daughters-in-law recorded.'
            => '%2$s tiene %1$d hija política (nuera) registrada.' . I18N::PLURAL . '%2$s tiene %1$d hijas políticas (nueras) registradas.',
            '%2$s has %1$d son-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sons-in-law recorded.'
            => '%2$s tine %1$d hijo político (yerno) registrado.' . I18N::PLURAL . '%2$s tine %1$d hijos politicos registrados.',
            '%2$s has %1$d child-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d children-in-law recorded.'
            => '%2$s tiene %1$d yerno/nuera registrado/a.' . I18N::PLURAL . '%2$s tiene %1$d yernos/nueras registrados.',
            '%2$s has %1$d son-in-law and ' . I18N::PLURAL . '%2$s has %1$d sons-in-law and '
            => '%2$s tiene %1$d hijo político (yerno) y ' . I18N::PLURAL . '%2$s tiene %1$d hijos políticos (yernos) y ',
            '%d daughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d daughters-in-law recorded (%d in total).'
            => '%d hijas políticas (nueras) registradas (%d en total).' . I18N::PLURAL . '%d hijas políticas (nueras) registradas (%d en total).',
            '%2$s has %1$d daughter-in-law and ' . I18N::PLURAL . '%2$s has %1$d daughters-in-law and '
            => '%2$s tiene %1$d nuera y ' . I18N::PLURAL . '%2$s tiene %1$d nueras y ',
            '%d child-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d children-in-law of unknown sex recorded (%d in total).'
            => '%d nuera/yerno registrado (%d en total).' . I18N::PLURAL . '%d nueras/yernos registrados/as (%d en total).',
            '%2$s has %1$d son-in-law, ' . I18N::PLURAL . '%2$s has %1$d sons-in-law, '
            => '%2$s es %1$d yerno, ' . I18N::PLURAL . '%2$s son %1$d yernos, ',
            '%d daughter-in-law, and ' . I18N::PLURAL . '%d daughters-in-law, and '
            => '%d n nuera y ' . I18N::PLURAL . '%d nueras y ',

            'Grandchildren' => 'Nietos y Nietas',
            '%s has no grandchildren recorded.' => '%s no tiene nietos registrados.',
            '%s has one granddaughter recorded.' => '%s tiene una nieta registrada.',
            '%s has one grandson recorded.' => '%s tiene un nieto registrado.',
            '%s has one grandchild of unknown sex recorded.' => '%s tiene un nieto o nieta registrados.',
            '%2$s has %1$d granddaughter recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters recorded.'
            => '%2$s ist %1$d nieta registrada.' . I18N::PLURAL . '%2$s tiene %1$d nietas registradas.',
            '%2$s has %1$d grandson recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons recorded.'
            => '%2$s ist %1$d nieto registrado.' . I18N::PLURAL . '%2$s tiene %1$d nietos registrados.',
            '%2$s has %1$d grandchild of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandchildren of unknown sex recorded.'
            => '%2$s tiene %1$d nieto/a registrado.' . I18N::PLURAL . '%2$s tiene %1$d nietos/as registrados.',
            '%2$s has %1$d grandson and ' . I18N::PLURAL . '%2$s has %1$d grandsons and '
            => '%2$s tiene %1$d nieto y ' . I18N::PLURAL . '%2$s tiene %1$d nietos y ',
            '%d granddaughter recorded (%d in total).' . I18N::PLURAL . '%d granddaughters recorded (%d in total).'
            => '%d nieta registrados (%d en total).' . I18N::PLURAL . '%d nietas registrados/as (%d en total).',
            '%2$s has %1$d granddaughter and ' . I18N::PLURAL . '%2$s has %1$d granddaughters and '
            => '%2$s tiene %1$d nieta y ' . I18N::PLURAL . '%2$s tiened %1$d nietas y ',
            '%d grandchild of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandchildren of unknown sex recorded (%d in total).'
            => '%d nieto/a registrado (%d en total).' . I18N::PLURAL . '%d nietos/as registrados (%d en total).',
            '%2$s has %1$d grandson, ' . I18N::PLURAL . '%2$s has %1$d grandsons, '
            => '%2$s tiene %1$d nieto, ' . I18N::PLURAL . '%2$s tiene %1$d nietos, ',
            '%d granddaughter, and ' . I18N::PLURAL . '%d granddaughters, and '
            => '%d nieta y ' . I18N::PLURAL . 'd nietas y ',

            'Grandchildren-in-law' => 'Nietos/as políticos/as',
            '%s has no grandchildren-in-law recorded.' => '%s no aparecen nietos politicos.',
            '%s has one granddaughter-in-law recorded.' => '%s nieta política registrada.',
            '%s has one grandson-in-law recorded.' => 'Für %s ist ein Schwiegerenkelsohn verzeichnet.',
            '%s has one grandchild-in-law of unknown sex recorded.' => '%s nieto/a político/a registrado/a.',
            '%2$s has %1$d granddaughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters-in-law recorded.'
            => '%2$s tiene %1$d nuera política registrada.' . I18N::PLURAL . '%2$s tiene %1$d nueras políticas registradas.',
            '%2$s has %1$d grandson-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons-in-law recorded.'
            => '%2$s tiene %1$d yerno político registrado.' . I18N::PLURAL . '%2$s tiene %1$d yernos políticos registrados.',
            '%2$s has %1$d grandchild-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandchildren-in-law of unknown sex recorded.'
            => '%2$s tiene %1$d nieto/a político/a registrado/a.' . I18N::PLURAL . '%2$s tiene %1$d nietos/as políticos/as registrados.',
            '%2$s has %1$d grandson-in-law and ' . I18N::PLURAL . '%2$s has %1$d grandsons-in-law and '
            => '%2$s tiene %1$d yerno polñitico y ' . I18N::PLURAL . '%2$s tiene %1$d yernos políticos y ',
            '%d granddaughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d granddaughters-in-law recorded (%d in total).'
            => '%d nuera política registrada(%d en total).' . I18N::PLURAL . '%d nueras políticas registradas(%d en total).',
            '%2$s has %1$d granddaughter-in-law and ' . I18N::PLURAL . '%2$s has %1$d granddaughters-in-law and '
            => '%2$s tiene %1$d nieta política y ' . I18N::PLURAL . '%2$s tiene %1$d nietas políoticas y ',
            '%d grandchild-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandchildren-in-law of unknown sex recorded (%d in total).'
            => '%d nietos/as políticos/as registrados/as (%d en total).' . I18N::PLURAL . '%d nietos/as políticos/as registrados/as (%d en total).',
            '%2$s has %1$d grandson-in-law, ' . I18N::PLURAL . '%2$s has %1$d grandsons-in-law, '
            => '%2$s tiene %1$d yerno político, ' . I18N::PLURAL . '%2$s tiened %1$d yernos políticos, ',
            '%d granddaughter-in-law, and ' . I18N::PLURAL . '%d granddaughters-in-law, and '
            => '%d nuera política y ' . I18N::PLURAL . 'd nueras políticas y ',
        ];
    }

    /**
     * @return array
     */
    public static function frenchTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Famille élargie',
            'A tab showing the extended family of an individual.' => 'Un onglet montrant la famille élargie d\'un individu.',
            'In which sequence should the parts of the extended family be shown?' => 'Dans quel ordre les parties de la famille élargie doivent-elles être montrées?',
            'Family part' => 'Blocs familiaux',
            'Show name of proband as short name or as full name?' => 'Afficher le nom du proband comme nom court ou comme nom complet?',
            'Show options to filter the results (gender and alive/dead)?' => 'Afficher des options pour filtrer les résultats (sexe et vivant/mort)?',
            'Show filter options' => 'Afficher les options de filtrage',
            'How should empty parts of extended family be presented?' => 'Comment présenter les parties vides de la famille élargie?',
            'Show empty block' => 'Afficher le bloc vide',
            'yes, always at standard location' => 'oui, toujours à l\'emplacement standard',
            'no, but collect messages about empty blocks at the end' => 'non, mais collecte des messages sur les blocs vides à la fin',
            'never' => 'jamais',
            'The short name is based on the probands Rufname or nickname. If these are not available, the first of the given names is used, if one is given. Otherwise the last name is used.' => 'Le nom court est basé sur le nom de famille ou le surnom du proband. Si ceux-ci ne sont pas disponibles, le premier des prénoms est utilisé, s\'il y en a un. Sinon, c\'est le nom de famille qui est utilisé.',
            'Show short name' => 'Afficher le nom court',
            'Show labels in special situations?' => 'Afficher les étiquettes dans des situations particulières?',
            'Labels (or stickers) are used for example for adopted persons or foster children.' => 'Les étiquettes sont utilisées par exemple pour les personnes adoptées ou les enfants placés en famille d\'accueil.',
            'Show labels' => 'Afficher les étiquettes',
            'Use the compact design?' => 'Utilisez le design compact?',
            'Use the compact design' => 'Utilisation du design compact',
            'The compact design only shows the name and life span for each person. The enriched design also shows a photo (if this is activated for this tree) as well as birth and death information.' => 'Le design compact ne montre que le nom et la durée de vie de chaque personne. Le design enrichi montre également une photo (si celle-ci est activée pour cet arbre) ainsi que des informations sur la naissance et le décès.',
            'Show parameters of extended family part?' => 'Montrer les paramètres de la partie de la famille élargie?',
            'Display of additional information for each part of the extended family, such as the generation shift and the coefficient of relationship, which is a measure of the degree of consanguinity.' => 'Affichage d\'informations supplémentaires pour chaque partie de la famille élargie, telles que le décalage des générations et le coefficient de parenté, qui est une mesure du degré de consanguinité.',
            'Show parameters' => 'Afficher les paramètres',

            'generation +%s' => 'génération +%s',
            'same generation' => 'même génération',
            'generation %s' => 'génération %s',
            'relationship coefficient: %.1f' => 'coefficient de relation : %.1f',
            'no blood relationship' => 'aucun lien de sang',

            'don\'t use this filter' => 'n\'utilisez pas ce filtre',
            'show only male persons' => 'afficher uniquement les personnes de sexe masculin',
            'show only female persons' => 'afficher uniquement les personnes de sexe féminin',
            'show only persons of unknown gender' => 'afficher uniquement les personnes de sexe inconnu',
            'show only alive persons' => 'afficher uniquement les personnes vivantes',
            'show only dead persons' => 'ne montrer que les personnes décédées',
            'alive' => 'vivant',
            'dead' => 'décédé',
            'a dead person' => 'une personne décédée',
            'a living person' => 'une personne vivante',
            'not a male person' => 'pas une personne de sexe masculin',
            'not a female person' => 'pas une personne de sexe féminin',
            'not a person of unknown gender' => 'pas une personne de sexe inconnu',

            'twin' => 'jumeau',
            'triplet' => 'triplés',
            'quadruplet' => 'quadruplés',
            'quintuplet' => 'quintuplés',
            'sextuplet' => 'sextuplés',
            'septuplet' => 'septuplés',
            'octuplet' => 'octuplés',
            'nonuplet' => 'nonuplés',
            'decuplet' => 'décuplés',
            'stillborn' => 'mort-né',
            'died as infant' => 'mort en bas âge',
            'linkage challenged' => 'lien contesté',
            'linkage disproven' => 'lien réfuté',
            'linkage proven' => 'lien avéré',

            'Marriage' => 'Mariage',
            'Ex-marriage' => 'Ex-mariage',
            'Partnership' => 'Conjoint',
            'Fiancée' => 'Fiancée',
            ' with ' => ' avec ',

            'Biological grandparents of father' => 'Grands-parents biologiques du père',
            'Biological grandparents of mother' => 'Grands-parents biologiques de la mère',
            'Biological grandparents of parent' => 'Grands-parents biologiques du parent',
            'Stepparents of biological parent of father' => 'Beau-parents du parent biologique du père',
            'Stepparents of biological parent of mother' => 'Beau-parents du parent biologique de la mère',
            'Stepparents of biological grandparent' => 'Beau-parents d\'un grand-parent biologique',
            'Parents of stepparent of father' => 'Parents du beau-parent du père',
            'Parents of stepparent of mother' => 'Parents du beau-parent de la mère',
            'Parents of stepparent of parent' => 'Parents du beau-parent du parent',
            'Grandparents of stepparent' => 'Grands-parents du beau-parent',
            'Biological great-grandparents' => 'Arrière-grands-parents biologiques',
            'Biological parents of father' => 'Parents biologiques du père',
            'Biological parents of mother' => 'Parents biologiques de la mère',
            'Biological parents of parent' => 'Parents biologiques du parent',
            'Stepparents of father' => 'Beau-parents du père',
            'Stepparents of mother' => 'Beau-parents de la mère',
            'Stepparents of parent' => 'Beau-parents du parent',
            'Parents of stepparent' => 'Parents de beaux-parents',
            'Biological grandparents' => 'Grands-parents biologiques',
            'Siblings of father' => 'Frères et sœurs du père',
            'Siblings of mother' => 'Frères et sœurs de la mère',
            'Full siblings of biological parents' => 'Frères et sœurs à part entière des parents biologiques',
            'Siblings-in-law of father' => 'Beau-frère ou belle-sœur du père',
            'Siblings-in-law of mother' => 'Beau-frère ou belle-sœur de la mère',
            'Biological parents' => 'Parents biologiques',
            'Stepparents' => 'Beaux-parents',
            'Parents-in-law of biological children' => 'Beaux-parents d\'enfants biologiques',
            'Parents-in-law of stepchildren' => 'Les beaux-parents des beaux-enfants',
            'Full siblings' => 'Tous les frères et sœurs',
            'Half siblings' => 'Beaux-frères et belles-sœurs',
            'Stepsiblings' => 'Frères et sœurs par alliance',
            'Children of full siblings of father' => 'Enfants des frères et sœurs germains du père',
            'Children of full siblings of mother' => 'Enfants des frères et sœurs germains de la mère',
            'Children of full siblings of parent' => 'Cousins et cousines du côté des parents',
            'Children of half siblings of father' => 'Enfants des demi-frères et demi-sœurs du père',
            'Children of half siblings of mother' => 'Enfants des demi-frères et demi-sœurs de la mère',
            'Children of half siblings of parent' => 'Enfants des demi-frères et demi-sœurs des parents',
            'Siblings of partners' => 'Frères et sœurs du conjoint',
            'Partners of siblings' => 'Conjoints de leurs frères et sœurs',
            'Siblings of siblings-in-law' => 'Belle-famille',
            'Partners of siblings-in-law' => 'Conjoints de leurs beaux-frères et belles-sœurs',
            'Children of full siblings of biological parents' => 'Enfants de frères et sœurs de parents biologiques',
            'Children of siblings' => 'Enfants de frères et sœurs',
            'Children of full siblings' => 'Enfants de frères et sœurs à part entière',
            'Siblings\' stepchildren' => 'Les beaux-enfants des frères et sœurs',
            'Children of siblings of partners' => 'Enfants des frères et sœurs du conjoint',
            'Biological children' => 'Enfants biologiques',
            'Stepchildren' => 'Beaux-enfants',
            'Stepchild' => 'Beau-fils ou belle-fille',
            'Stepson' => 'Gendre',
            'Stepdaughter' => 'Bru',
            'Partners of biological children' => 'Conjoints d\'enfants biologiques',
            'Partners of stepchildren' => 'Conjoint des beaux-enfants',
            'Biological grandchildren' => 'Petits-enfants biologiques',
            'Stepchildren of children' => 'Beaux-enfants',
            'Children of stepchildren' => 'Enfants des beaux-enfants',
            'Stepchildren of stepchildren' => 'Beau-fils ou belle-fille de beau-fils ou belle-fille',
            'Partners of biological grandchildren' => 'Partenaires de petits-enfants biologiques',
            'Partners of stepchildren of children' => 'Partenaires des beaux-enfants des enfants',
            'Partners of children of stepchildren' => 'Partenaires des enfants des beaux-enfants',
            'Partners of stepchildren of stepchildren' => 'Partenaires des beaux-enfants des beaux-enfants',

            'He' => 'Il',
            'She' => 'Elle',
            'He/she' => 'Il/elle',
            'Mr.' => 'Mr.',
            'Mrs.' => 'Mme.',
            'No family available' => 'Aucune famille disponible',
            'Summary for the shown extended family' => 'Summary for the shown extended family',
            'The extended family of %1$s has one member.' . I18N::PLURAL . 'The extended family of %1$s has %2$d members.'
                => 'The extended family of %1$s has one member.' . I18N::PLURAL . 'The extended family of %1$s has %2$d members.',
            '%s has no %s recorded.' => '%s no tiene %s registrados.',
            '%s has no %s, and no %s recorded.' => '%s n\'a pas %s ni %s enregistré.',

            'Father\'s family (%d)' => 'Famille du père (%d)',
            'Mother\'s family (%d)' => 'Famille de la mère (%d)',
            'Father\'s and Mother\'s family (%d)' => 'Famille du père et de la mère (%d)',
            'Grandparents %1$s (%2$s) of stepfather %3$s' => 'Grands-parents %1$s (%2$s) du beau-père %3$s ',
            'Grandparents %1$s (%2$s) of stepmother %3$s' => 'Grands-parents %1$s (%2$s) de la belle-mère %3$s',
            'Grandparents %1$s (%2$s) of stepparent %3$s' => 'Grands-parents %1$s (%2$s) du beau-parent %3$s',
            'Stepparents %1$s (%2$s) of %3$s' => 'Beaux-parents %1$s (%2$s) de %3$s',
            'Parents %1$s (%2$s) of stepfather %3$s' => 'Parents %1$s (%2$s) du beau-père %3$s',
            'Parents %1$s (%2$s) of stepmother %3$s' => 'Parents %1$s (%2$s) de la belle-mère %3$s',
            'Parents %1$s (%2$s) of stepparent %3$s' => 'Parents %1$s (%2$s) du beau-parent %3$s',
            'Parents %1$s of %2$s' => 'Parents %1$s de %2$s',
            'Parents %1$s (%2$s) of %3$s' => 'Parents %1$s (%2$s) de %3$s',
            'Partners of %s' => 'Conjoint de %s',
            'Brother %1$s of partner %2$s' => 'Frère %1$s de conjoint %2$s',
            'Sister %1$s of partner %2$s' => 'Soeur %1$s de conjoint %2$s',
            'Sibling %1$s of partner %2$s' => 'Frères et soeurs %1$s de Conjoint %2$s',

            'Great-grandparents' => 'Arrière-grands-parents',
            '%s has no great-grandparents recorded.' => '%s n\'a pas d\'arrière-grands-parents enregistrés.',
            '%s has one great-grandmother recorded.' => '%s a une arrière-grand-mère enregistrée.',
            '%s has one great-grandfather recorded.' => '%s a un arrière-grand-père enregistré.',
            '%s has one great-grandparent of unknown sex recorded.' => '%s a un arrière-grand-parent de sexe inconnu enregistré.',
            '%2$s has %1$d great-grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandmothers recorded.'
                => '%2$s a %1$d arrière-grand-mère enregistrée.' . I18N::PLURAL . '%2$s a %1$d arrière-grands-mères enregistrées.',
            '%2$s has %1$d great-grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandfathers recorded.'
                => '%2$s a %1$d arrière-grand-père enregistré.' . I18N::PLURAL . '%2$s a %1$d arrière-grands-pères enregistrés.',
            '%2$s has %1$d great-grandparent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandparents of unknown sex recorded.'
                => '%2$s a %1$d arrière-grand-parent de sexe inconnu enregistré.' . I18N::PLURAL . '%2$s a %1$d arrière-grands-parents de sexe inconnu enregistrés.',
            '%2$s has %1$d great-grandfather and ' . I18N::PLURAL . '%2$s has %1$d great-grandfathers and '
                => '%2$s a %1$d arrière-grand-père et ' . I18N::PLURAL . '%2$s a %1$d arrière-grand-père et ',
            '%d great-grandmother recorded (%d in total).' . I18N::PLURAL . '%d great-grandmothers recorded (%d in total).'
                => '%d arrière-grand-mère enregistrée (%d au total).' . I18N::PLURAL . '%d arrière-grands-mères enregistrées (%d au total).',
            '%2$s has %1$d great-grandmother and ' . I18N::PLURAL . '%2$s has %1$d great-grandmothers and '
                => '%2$s a %1$d arrière-grand-mère et ' . I18N::PLURAL . '%2$s a %1$d arrière-grands-mères et ',
            '%d great-grandparent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d great-grandparents of unknown sex recorded (%d in total).'
                => '%d arrière-grand-parents de sexe inconnu enregistrés (%d au total).' . I18N::PLURAL . '%d arrière-grands-parents de sexe inconnu enregistrés (%d au total).',
            '%2$s has %1$d great-grandfather, ' . I18N::PLURAL . '%2$s has %1$d great-grandfathers, '
                => '%2$s a %1$d arrière-grand-père, ' . I18N::PLURAL . '%2$s a %1$d arrière-grands-pères, ',
            '%d great-grandmother, and ' . I18N::PLURAL . '%d great-grandmothers, and '
                => '%d arrière-grand-mère, et ' . I18N::PLURAL . '%d arrière-grands-mères, et ',

            'Grandparents' => 'Grands-parents',
            '%s has no grandparents recorded.' => '%s n\'a pas de grands-parents enregistrés.',
            '%s has one grandmother recorded.' => '%s a une grand-mère enregistrée.',
            '%s has one grandfather recorded.' => '%s a un grand-père enregistré.',
            '%s has one grandparent recorded.' => '%s a un grand-parent enregistré.',
            '%2$s has %1$d grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d grandmothers recorded.'
                => '%2$s a %1$d grand-mère enregistrée.' . I18N::PLURAL . '%2$s a %1$d grands-mères enregistrées.',
            '%2$s has %1$d grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d grandfathers recorded.'
                => '%2$s a %1$d grand-père enregistré.' . I18N::PLURAL . '%2$s a %1$d grands-pères enregistrés.',
            '%2$s has %1$d grandparent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandparents of unknown sex recorded.'
                => '%2$s a %1$d grand-parent de sexe inconnu enregistré.' . I18N::PLURAL . '%2$s a %1$d grands-parents de sexe inconnu enregistrés.',
            '%2$s has %1$d grandfather and ' . I18N::PLURAL . '%2$s has %1$d grandfathers and '
                => '%2$s a %1$d grand-père et ' . I18N::PLURAL . '%2$s a %1$d grands-pères et ',
            '%d grandmother recorded (%d in total).' . I18N::PLURAL . '%d grandmothers recorded (%d in total).'
                => '%d grand-mère enregistrée (%d au total).' . I18N::PLURAL . '%d grands-mères enregistrées (%d au total).',
            '%2$s has %1$d grandmother and ' . I18N::PLURAL . '%2$s has %1$d grandmothers and '
                => '%2$s a %1$d grand-mère et ' . I18N::PLURAL . '%2$s a %1$d grand-mères et ',
            '%d grandparent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandparents of unknown sex recorded (%d in total).'
                => '%d grand-parent de sexe inconnu enregistré (%d au total).' . I18N::PLURAL . '%d grands-parents de sexe inconnu enregistrés (%d au total).',
            '%2$s has %1$d grandfather, ' . I18N::PLURAL . '%2$s has %1$d grandfathers, '
                => '%2$s a %1$d grand-père, ' . I18N::PLURAL . '%2$s a %1$d grands-pères, ',
            '%d grandmother, and ' . I18N::PLURAL . '%d grandmothers, and '
                => '%d grand-mère, et ' . I18N::PLURAL . '%d grand-mères, et ',

            'Uncles and Aunts' => 'Oncles et tantes',
            '%s has no uncles or aunts recorded.' => '%s n\'a pas d\'oncle ou de tante enregistré.',
            '%s has one aunt recorded.' => '%s a une tante enregistrée.',
            '%s has one uncle recorded.' => '%s a un oncle enregistré.',
            '%s has one uncle or aunt recorded.' => '%s a un oncle ou une tante enregistrée.',
            '%s has one uncle or aunt of unknown sex recorded.' => '%s a un oncle ou une tante de sexe inconnu enregistré.',
            '%2$s has %1$d aunt recorded.' . I18N::PLURAL . '%2$s has %1$d aunts recorded.'
                => '%2$s a %1$d tante enregistrée.' . I18N::PLURAL . '%2$s a %1$d tantes enregistrées.',
            '%2$s has %1$d uncle recorded.' . I18N::PLURAL . '%2$s has %1$d uncles recorded.'
                => '%2$s a %1$d oncle enregistré.' . I18N::PLURAL . '%2$s a %1$d oncles enregistrés.',
            '%2$s has %1$d uncle or aunt of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d uncles or aunts of unknown sex recorded.'
                => '%2$s a %1$d oncle ou tante de sexe inconnu enregistré.'. I18N::PLURAL . 'oncles ou tantes de sexe inconnu enregistré.',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and '
                => '%2$s a %1$d oncle et ' . I18N::PLURAL . '%2$s a %1$d oncles et ',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).'
                => '%d tante enregistrée (%d au total).' . I18N::PLURAL . '%d tantes enregistrées (%d au total).',
            '%2$s has %1$d aunt and ' . I18N::PLURAL . '%2$s has %1$d aunts and '
                => '%2$s a %1$d tante et ' . I18N::PLURAL . '%2$s a %1$d tantes et ',
            '%d uncle or aunt of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d uncles or aunts of unknown sex recorded (%d in total).'
                => '%d oncle ou tante de sexe inconnu enregistré (%d au total).' . I18N::PLURAL . '%d oncles ou tantes de sexe inconnu enregistré (%d au total).',
            '%2$s has %1$d uncle, ' . I18N::PLURAL . '%2$s has %1$d uncles, '
                => '%2$s a %1$d oncle, ' . I18N::PLURAL . '%2$s a %1$d oncles, ',
            '%d aunt, and ' . I18N::PLURAL . '%d aunts, and '
                => '%d tante, et ' . I18N::PLURAL . '%d tantes, et ',

            'Uncles and Aunts by marriage' => 'Oncles et tantes par alliance',
            '%s has no uncles or aunts by marriage recorded.' => '%s n\'a pas d\'oncle par alliance enregistré.',
            '%s has one aunt by marriage recorded.' => '%s a une tante par alliance enregistrée.',
            '%s has one uncle by marriage recorded.' => '%s a un oncle par alliance enregistré.',
            '%s has one uncle or aunt by marriage of unknown sex recorded.' => '%s a un oncle ou une tante par alliance de sexe inconnu enregistré. ',
            '%2$s has %1$d aunt by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d aunts by marriage recorded.'
                => '%2$s a %1$d tante par alliance enregistrée.' . I18N::PLURAL . '%2$s a %1$d tantes par alliance enregistrées.',
            '%s has one uncle or aunt by marriage recorded.' => '%s a un oncle ou une tante par alliance enregistré(e).',
            '%2$s has %1$d uncle by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d uncles by marriage recorded.'
                => '%2$s a %1$d oncle par alliance enregistré.' . I18N::PLURAL . '%2$s a %1$d oncles par alliance enregistrés.',
            '%2$s has %1$d uncle or aunt by marriage of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d uncles or aunts by marriage of unknown sex recorded.'
                => '%2$s a %1$d oncle ou tante par alliance de sexe inconnu enregistré.' . I18N::PLURAL . '%2$s a %1$d oncles ou tantes par alliance de sexe inconnu enregistrés.',
            '%2$s has %1$d uncle by marriage and ' . I18N::PLURAL . '%2$s has %1$d uncles by marriage and '
                => '%2$s a %1$d oncle par alliance et ' . I18N::PLURAL . '%2$s a %1$d oncles par alliance et ',
            '%d aunt by marriage recorded (%d in total).' . I18N::PLURAL . '%d aunts by marriage recorded (%d in total).'
                => '%d tante par alliance enregistrée (%d au total).' . I18N::PLURAL . '%d tantes par alliance enregistrées (%d au total).',
            '%2$s has %1$d aunt by marriage and ' . I18N::PLURAL . '%2$s has %1$d aunts by marriage and '
                => '%2$s a %1$d tante par alliance et ' . I18N::PLURAL . '%2$s a %1$d tantes par alliance et ',
            '%d uncle or aunt by marriage of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d uncles or aunts by marriage of unknown sex recorded (%d in total).'
                => '%d oncle ou tante par alliance de sexe inconnu enregistré (%d au total).' . I18N::PLURAL . '%d oncles ou tantes par mariage de sexe inconnu enregistrés (%d au total).',
            '%2$s has %1$d uncle by marriage, ' . I18N::PLURAL . '%2$s has %1$d uncles by marriage, '
                => '%2$s a %1$d oncle par alliance, ' . I18N::PLURAL . '%2$s a %1$d oncles par alliance, ',
            '%d aunt by marriage, and ' . I18N::PLURAL . '%d aunts by marriage, and '
                => '%d tante par alliance, et ' . I18N::PLURAL . '%d tantes par alliance, et ',

            'Parents' => 'Parents',
            '%s has no parents recorded.' => '%s n\'a pas de parent enregistré.',
            '%s has one mother recorded.' => '%s n\'a pas de mère enregistrée',
            '%s has one father recorded.' => '%s n\'a pas de père enregistré.',
            '%s has one parent recorded.' => '%s a un parent enregistré.',
            '%s has one parent of unknown sex recorded.' => '%s a un parent de sexe inconnu enregistré.',
            '%2$s has %1$d mother recorded.' . I18N::PLURAL . '%2$s has %1$d mothers recorded.'
                => '%2$s a %1$d mère enregistrée.' . I18N::PLURAL . '%2$s a %1$d mères enregistrées.',
            '%2$s has %1$d father recorded.' . I18N::PLURAL . '%2$s has %1$d fathers recorded.'
                => '%2$s a %1$d père enregistré.' . I18N::PLURAL . '%2$s a %1$d pères enregistrés.',
            '%2$s has %1$d parent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d parents of unknown sex recorded.'
                => '%2$s a %1$d parent de sexe inconnu enregistré.' . I18N::PLURAL . '%2$s a %1$d parents de sexe inconnu enregistrés.',
            '%2$s has %1$d father and ' . I18N::PLURAL . '%2$s has %1$d fathers and '
                => '%2$s a %1$d père et ' . I18N::PLURAL . '%2$s a %1$d pères et ',
            '%d mother recorded (%d in total).' . I18N::PLURAL . '%d mothers recorded (%d in total).'
                => '%d mère enregistrée (%d au total).' . I18N::PLURAL . '%d mères enregistrées (%d au total).',
            '%2$s has %1$d mother and ' . I18N::PLURAL . '%2$s has %1$d mothers and '
                => '%2$s a %1$d mère et ' . I18N::PLURAL . '%2$s a %1$d mères et ',
            '%d parent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d parents of unknown sex recorded (%d in total).'
                => '%d parent de sexe inconnu enregistré (%d au total).' . I18N::PLURAL . '%d parents de sexe inconnu enregistrés (%d au total).',
            '%2$s has %1$d father, ' . I18N::PLURAL . '%2$s has %1$d fathers, '
                => '%2$s a %1$d père, ' . I18N::PLURAL . '%2$s a %1$d pères, ',
            '%d mother, and ' . I18N::PLURAL . '%d mothers, and '
                => '%d mère, et ' . I18N::PLURAL . '%d mères, et ',

            'Parents-in-law' => 'Beaux-parents',
            '%s has no parents-in-law recorded.' => '%s n\'a pas de beau-parent enregistré.',
            '%s has one mother-in-law recorded.' => '%s a une belle-mère enregistrée.',
            '%s has one father-in-law recorded.' => '%s a un beau-père enregistré.',
            '%s has one parent-in-law recorded.' => '%s a un beau-père ou une belle-mère enregistré(e).',
            '%s has one parent-in-law of unknown sex recorded.' => '%s a un beau-parent de sexe inconnu enregistré.',
            '%2$s has %1$d mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d mothers-in-law recorded.'
                => '%2$s a %1$d belle-mère enregistrée.' . I18N::PLURAL . '%2$s a %1$d belles-mères enregistrées.',
            '%2$s has %1$d father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d fathers-in-law recorded.'
                => '%2$s a %1$d beau-père enregistré.' . I18N::PLURAL . '%2$s a %1$d beaux-pères enregistrés.',
            '%2$s has %1$d parent-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d parents-in-law of unknown sex recorded.'
                => '%2$s a %1$d beaux-parents de sexe inconnu enregistrés.' . I18N::PLURAL . '%2$s a %1$d beaux-parents de sexe inconnu enregistrés.',
            '%2$s has %1$d father-in-law and ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law and '
                => '%2$s a %1$d beau-père et ' . I18N::PLURAL . '%2$s a %1$d beaux-pères et ',
            '%d mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d mothers-in-law recorded (%d in total).'
                => '%d belle-mère enregistrée (%d au total).' . I18N::PLURAL . '%d belles-mères enregistrées (%d au total).',
            '%2$s has %1$d mother-in-law and ' . I18N::PLURAL . '%2$s has %1$d mothers-in-law and '
                => '%2$s a %1$d belle-mère et ' . I18N::PLURAL . '%2$s a %1$d belles-mères et ',
            '%d parent-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d parents-in-law of unknown sex recorded (%d in total).'
                => '%d beaux-parents de sexe inconnu enregistrés (%d au total).' . I18N::PLURAL . '%d beaux-parents de sexe inconnu enregistrés (%d au total).',
            '%2$s has %1$d father-in-law, ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law, '
                => '%2$s a %1$d beau-père, ' . I18N::PLURAL . '%2$s a %1$d beaux-pères, ',
            '%d mother-in-law, and ' . I18N::PLURAL . '%d mothers-in-law, and '
                => '%d belle-mère, et ' . I18N::PLURAL . '%d belles-mères, et ',

            'Co-parents-in-law' => 'Beaux-parents',
            '%s has no co-parents-in-law recorded.' => '%s n\'a pas de beau-parent enregistré.',
            '%s has one co-mother-in-law recorded.' => '%s a une belle-mère enregistrée.',
            '%s has one co-father-in-law recorded.' => '%s a un beau-père enregistré.',
            '%s has one co-parent-in-law of unknown sex recorded.' => '%s a un co-parent de sexe inconnu enregistré.',
            '%2$s has %1$d co-mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law recorded.'
                => '%2$s a %1$d belle-mère enregistrée.' . I18N::PLURAL . '%2$s a %1$d belles-mères enregistrées.',
            '%2$s has %1$d co-father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law recorded.'
                => '%2$s a %1$d beau-père enregistré.' . I18N::PLURAL . '%2$s a %1$d beaux-pères enregistrés.',
            '%2$s has %1$d co-parent-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d co-parents-in-law of unknown sex recorded.'
                => '%2$s a %1$d beaux-parents de sexe inconnu enregistrés.' . I18N::PLURAL . '%2$s a %1$d beaux-parents de sexe inconnu enregistrés.',
            '%2$s has %1$d co-father-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law and '
                => '%2$s a %1$d beau-père et ' . I18N::PLURAL . '%2$s a %1$d beaux-pères et ',
            '%d co-mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-mothers-in-law recorded (%d in total).'
                => '%d belle-mère enregistrée (%d au total).' . I18N::PLURAL . '%d belles-mères enregistrées (%d au total).',
            '%2$s has %1$d co-mother-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law and '
                => '%2$s a %1$d belle-mère et ' . I18N::PLURAL . '%2$s a %1$d belles-mères et ',
            '%d co-parent-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d co-parents-in-law of unknown sex recorded (%d in total).'
                => '%d beaux-parents de sexe inconnu enregistrés (%d au total).' . I18N::PLURAL . '%d beaux-parents de sexe inconnu enregistrés (%d au total).',
            '%2$s has %1$d co-father-in-law, ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law, '
                => '%2$s a %1$d beau-père, ' . I18N::PLURAL . '%2$s a %1$d beaux-pères, ',
            '%d co-mother-in-law, and ' . I18N::PLURAL . '%d co-mothers-in-law, and '
                => '%d belle-mère, et ' . I18N::PLURAL . '%d belles-mères, et ',
            '%s has one co-parent-in-law recorded.' => '%s a un beau-père ou une belle-mère enregistré(e).',

            'Partners' => 'Conjoint',
            'Partner of ' => 'Conjoint de ',
            '%s has no partners recorded.' => '%s n\'a pas de conjoint enregistré.',
            '%s has one female partner recorded.' => '%s a une conjointe enregistrée.',
            '%s has one male partner recorded.' => '%s a un conjoint enregistré.',
            '%s has one partner recorded.' => '%s a un conjoint ou conjointe enregistré.',
            '%s has one partner of unknown sex recorded.' => '%s a enregistré un partenaire de sexe inconnu.',
            '%2$s has %1$d female partner recorded.' . I18N::PLURAL . '%2$s has %1$d female partners recorded.'
                => '%2$s a %1$d conjointe enregistrée.' . I18N::PLURAL . '%2$s a %1$d conjointes enregistrées.',
            '%2$s has %1$d male partner recorded.' . I18N::PLURAL . '%2$s has %1$d male partners recorded.'
                => '%2$s a %1$d conjoint enregistré.' . I18N::PLURAL . '%2$s a %1$d conjoints enregistrés.',
            '%2$s has %1$d partner of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d partners of unknown sex recorded.'
                => '%2$s a enregistré %1$d partenaire de sexe inconnu.' . I18N::PLURAL . '%2$s a enregistré %1$d partenaires de sexe inconnu.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and '
                => '%2$s a %1$d conjoint et ' . I18N::PLURAL . '%2$s a %1$d conjoints et ',
            '%2$s has %1$d female partner and ' . I18N::PLURAL . '%2$s has %1$d female partners and '
                => '%2$s a %1$d conjointe et ' . I18N::PLURAL . '%2$s a %1$d conjointes et ',
            '%d female partner recorded (%d in total).' . I18N::PLURAL . '%d female partners recorded (%d in total).'
                => '%d conjointe enregistrée (%d au total).' . I18N::PLURAL . '%d conjointes enregistrées (%d au total).',
            '%2$s has %1$d partner and ' . I18N::PLURAL . '%2$s has %1$d partners and '
                => '%2$s a %1$d conjoint/conjointe et ' . I18N::PLURAL . '%2$s a %1$d conjoints/conjointes et ',
            '%d male partner of female partners recorded (%d in total).' . I18N::PLURAL . '%d male partners of female partners recorded (%d in total).'
                => '%d conjoint des  conjointes enregistrées (%d au total).' . I18N::PLURAL . '%d conjoints des conjointes enregistrées (%d au total).',
            '%d female partner of male partners recorded (%d in total).' . I18N::PLURAL . '%d female partners of male partners recorded (%d in total).'
                => '%d conjointe de conjoints enregistrés (%d au total).' . I18N::PLURAL . '%d conjointes de conjoints enregistrés (%d au total).',

            'Partner chains' => 'Chaînes de partenaires',
            '%s has no members of a partner chain recorded.' => '%s n\'a pas de membre d\'une chaîne de partenaires enregistré.',
            '%d female partner in this partner chain recorded (%d in total).' . I18N::PLURAL . '%d female partners in this partner chain recorded (%d in total).'
            =>'%d partenaire féminin dans cette chaîne de partenariat enregistré (%d au total).' . I18N::PLURAL . '%d partenaires féminines dans cette chaîne de partenariat enregistrées (%d au total).',
            '%d female partner and ' . I18N::PLURAL . '%d female partners and '
                => '%d partenaire féminin et ' . I18N::PLURAL . '%d partenaires féminines et ',
            '%d partner of unknown sex in this partner chain recorded (%d in total).' . I18N::PLURAL . '%d partners of unknown sex in this partner chain recorded (%d in total).'
                => '%d partenaire de sexe inconnu enregistré dans cette chaîne de partenaires (%d au total).' . I18N::PLURAL . '%d partenaires de sexe inconnu dans cette chaîne de partenaires enregistrés (%d au total).',
            '%d partner of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d partners of unknown sex recorded (%d in total).'
                => '%d partenaire de sexe inconnu enregistré (%d au total).' . I18N::PLURAL . '%d partenaires de sexe inconnu enregistrés (%d au total).',
            '%2$s has %1$d male partner, ' . I18N::PLURAL . '%2$s has %1$d male partners, '
                => '%2$s a %1$d partenaire masculin, ' . I18N::PLURAL . '%2$s a %1$d partenaires masculins, ',
            '%d female partner, and ' . I18N::PLURAL . '%d female partners, and '
                => '%d partenaire féminin, et ' . I18N::PLURAL . '%d partenaires féminines, et ',
            'There are %d branches in the partner chain. ' => 'Il y a %d branches de la chaîne de partenaires.',
            'The longest branch in the partner chain to %2$s consists of %1$d partners (including %3$s).' => 'La branche la plus longue de la chaîne de partenaires vers %2$s est constituée de %1$d partenaires (dont %3$s).',
            'The longest branch in the partner chain consists of %1$d partners (including %2$s).' => 'La branche la plus longue de la chaîne de partenaires est constituée de %1$d partenaires (dont %2$s).',

            'Siblings' => 'Frères et soeurs',
            '%s has no siblings recorded.' => '%s n\'a pas de frère ou de soeur enregistré(e).',
            '%s has one sister recorded.' => '%s a une soeur enregistrée.',
            '%s has one brother recorded.' => '%s a un frère enregistré.',
            '%s has one brother or sister recorded.' => '%s a un frère ou une soeur enregistré(e).',
            '%s has one sibling of unknown sex recorded.' => '%s a un frère ou une sœur de sexe inconnu enregistré.',
            '%2$s has %1$d sister recorded.' . I18N::PLURAL . '%2$s has %1$d sisters recorded.'
                => '%2$s a %1$d soeur enregistrée.' . I18N::PLURAL . '%2$s a %1$d soeurs enregistrées.',
            '%2$s has %1$d brother recorded.' . I18N::PLURAL . '%2$s has %1$d brothers recorded.'
                => '%2$s a %1$d frère enregistré.' . I18N::PLURAL . '%2$s a %1$d frères enregistrés.',
            '%2$s has %1$d sibling of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d siblings of unknown sex recorded.'
                => '%2$s a %1$d frère ou sœur de sexe inconnu enregistré.' . I18N::PLURAL . '%2$s a %1$d frères et sœurs de sexe inconnu enregistrés.',
            '%2$s has %1$d brother and ' . I18N::PLURAL . '%2$s has %1$d brothers and '
                => '%2$s a %1$d frère et ' . I18N::PLURAL . '%2$s a %1$d frères et ',
            '%d sister recorded (%d in total).' . I18N::PLURAL . '%d sisters recorded (%d in total).'
                => '%d soeur enregistrée (%d au total).' . I18N::PLURAL . '%d soeurs enregistrées (%d au total).',
            '%2$s has %1$d sister and ' . I18N::PLURAL . '%2$s has %1$d sisters and '
                => '%2$s a %1$d soeur et ' . I18N::PLURAL . '%2$s a %1$d sœurs et ',
            '%d sibling of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d siblings of unknown sex recorded (%d in total).'
                => '%d frère ou sœur de sexe inconnu enregistré (%d au total).' . I18N::PLURAL . '%d frères et sœurs de sexe inconnu enregistrés (%d au total).',
            '%2$s has %1$d brother, ' . I18N::PLURAL . '%2$s has %1$d brothers, '
                => '%2$s a %1$d frère, ' . I18N::PLURAL . '%2$s a %1$d frères, ',
            '%d sister, and ' . I18N::PLURAL . '%d sisters, and '
                => '%d soeur, et ' . I18N::PLURAL . '%d sœurs, et ',

            'Siblings-in-law' => 'Beaux-frères et belles-soeurs',
            '%s has no siblings-in-law recorded.' => '%s n\'a pas de beau-frère ou de belle-soeur enregistré(e).',
            '%s has one sister-in-law recorded.' => '%s a une belle-soeur enregistrée.',
            '%s has one brother-in-law recorded.' => '%s a un beau-frère enregistré.',
            '%s has one sibling-in-law recorded.' => '%s a un beau-frère ou une belle-soeur enregistrée.',
            '%s has one sibling-in-law of unknown sex recorded.' => '%s a un beau-frère de sexe inconnu enregistré.',
            '%2$s has %1$d sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sisters-in-law recorded.'
                => '%2$s a %1$d belle-soeur enregistrée.' . I18N::PLURAL . '%2$s a %1$d belles-soeurs enregistrées.',
            '%2$s has %1$d brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d brothers-in-law recorded.'
                => '%2$s a %1$d beau-frère enregistré.' . I18N::PLURAL . '%2$s a %1$d beaux-frères enregistrés.',
            '%2$s has %1$d sibling-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d siblings-in-law of unknown sex recorded.'
                => '%2$s a %1$d beau-frère ou belle-soeur de sexe inconnu enregistré.' . I18N::PLURAL . '%2$s a %1$d beaux-frères et belles-soeurs de sexe inconnu enregistrés.',
            '%2$s has %1$d brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law and '
                => '%2$s a %1$d beau-frère et ' . I18N::PLURAL . '%2$s a %1$d belle-soeur et ',
            '%d sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d sisters-in-law recorded (%d in total).'
                => '%d belle-soeur enregistrée (%d au total).' . I18N::PLURAL . '%d belles-soeurs enregistrées (%d au total).',
            '%2$s has %1$d sister-in-law and ' . I18N::PLURAL . '%2$s has %1$d sisters-in-law and '
                => '%2$s a %1$d belle-soeur et ' . I18N::PLURAL . '%2$s a %1$d belles-soeurs et ',
            '%d sibling-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d siblings-in-law of unknown sex recorded (%d in total).'
                => '%d beau-frère ou belle-soeur de sexe inconnu enregistré (%d au total).' . I18N::PLURAL . '%d beau-frères ou belles-soeurs de sexe inconnu enregistrés (%d au total). ',
            '%2$s has %1$d brother-in-law, ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law, '
                => '%2$s a %1$d beau-frère, ' . I18N::PLURAL . '%2$s a %1$d beaux-frères, ',
            '%d sister-in-law, and ' . I18N::PLURAL . '%d sisters-in-law, and '
                => '%d belle-soeur, et ' . I18N::PLURAL . '%d belles-soeurs, et ',

            'Co-siblings-in-law' => 'Beaux-frères et belles-soeurs',
            '%s has no co-siblings-in-law recorded.' => '%s n\'a pas de beau-frère ou de belle-soeur enregistré(e).',
            '%s has one co-sister-in-law recorded.' => '%s a une belle-soeur enregistrée.',
            '%s has one co-brother-in-law recorded.' => '%s a un beau-frère enregistré.',
            '%s has one co-sibling-in-law of unknown sex recorded.' => '%s a un beau-frère ou belle-sœur de sexe inconnu enregistré.',
            '%s has one co-sibling-in-law recorded.' => '%s a un beau-frère ou une belle-soeur enregistrée.',
            '%2$s has %1$d co-sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-sisters-in-law recorded.'
                => '%2$s a %1$d belle-soeur enregistrée.' . I18N::PLURAL . '%2$s a %1$d belles-soeurs enregistrées.',
            '%2$s has %1$d co-brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law recorded.'
                => '%2$s a %1$d beau-frère enregistré.' . I18N::PLURAL . '%2$s a %1$d beaux-frères enregistrés.',
            '%2$s has %1$d co-sibling-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d co-siblings-in-law of unknown sex recorded.'
                => '%2$s a %1$d beau-frère ou belle-soeur de sexe inconnu enregistré.' . I18N::PLURAL . '%2$s a %1$d beaux-frères ou belles-soeurs de sexe inconnu enregistrés.',
            '%2$s has %1$d co-brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law and '
                => '%2$s a %1$d beau-frère et ' . I18N::PLURAL . '%2$s a %1$d belle-soeur et ',
            '%d co-sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-sisters-in-law recorded (%d in total).'
                => '%d belle-soeur enregistrée (%d au total).' . I18N::PLURAL . '%d belles-soeurs enregistrées (%d au total).',
            '%2$s has %1$d co-sister-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-sisters-in-law and '
                => '%2$s a %1$d belle-soeur et ' . I18N::PLURAL . '%2$s a %1$d belles-soeurs et ',
            '%d co-sibling-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d co-siblings-in-law of unknown sex recorded (%d in total).'
                => '%d beau-frère ou belle-sœur de sexe inconnu enregistré (%d au total). ' . I18N::PLURAL . '%d beaux-frères ou belles-sœurs de sexe inconnu enregistrés (%d au total). ',
            '%2$s has %1$d co-brother-in-law, ' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law, '
                => '%2$s a %1$d beau-frère ' . I18N::PLURAL . '%2$s a %1$d beaux-frères ',
            '%d co-sister-in-law, and ' . I18N::PLURAL . '%d co-sisters-in-law, and '
                => '%d belle-soeur, et ' . I18N::PLURAL . '%d belles-soeurs, et ',

            'Cousins' => 'Cousins germains',
            '%s has no first cousins recorded.' => '%s n\'a pas de cousin(e) germain(e) enregistré(e).',
            '%s has one female first cousin recorded.' => '%s a une cousine germaine enregistrée.',
            '%s has one male first cousin recorded.' => '%s a un cousin germain enregistré.',
            '%s has one first cousin of unknown sex recorded.' => '%s a un cousin(e) germain(e) de sexe inconnu enregistré. ',
            '%s has one first cousin recorded.' => '%s a un cousin germain enregistré.',
            '%2$s has %1$d female first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d female first cousins recorded.'
                => '%2$s a %1$d cousine germaine enregistrée.' . I18N::PLURAL . '%2$s a %1$d cousines germaines enregistrées.',
            '%2$s has %1$d male first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d male first cousins recorded.'
                => '%2$s a %1$d cousin germain enregistré.' . I18N::PLURAL . '%2$s a %1$d cousins germains enregistrés.',
            '%2$s has %1$d first cousin of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d first cousins of unknown sex recorded.'
                => '%2$s a %1$d cousin(e) germain(e) de sexe inconnu enregistré. ' . I18N::PLURAL . '%2$s a %1$d cousin(e)s germain(e)s de sexe inconnu enregistré(e)s. ',
            '%2$s has %1$d male first cousin and ' . I18N::PLURAL . '%2$s has %1$d male first cousins and '
                => '%2$s a %1$d cousin germain et ' . I18N::PLURAL . '%2$s a %1$d cousins germains et ',
            '%d female first cousin recorded (%d in total).' . I18N::PLURAL . '%d female first cousins recorded (%d in total).'
                => '%d cousine germaine enregistrée (%d au total).' . I18N::PLURAL . '%d cousines germaines enregistrées (%d au total).',
            '%2$s has %1$d female first cousin and ' . I18N::PLURAL . '%2$s has %1$d female first cousins and '
                => '%2$s a %1$d cousine germaine et ' . I18N::PLURAL . '%2$s a %1$d cousines germaines et ',
            '%d first cousin of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d first cousins of unknown sex recorded (%d in total).'
                => '%d cousin(e) germain(e) de sexe inconnu enregistré (%d au total). ' . I18N::PLURAL . '%d cousin(e)s germain(e)s de sexe inconnu enregistré(e)s (%d au total). ',
            '%2$s has %1$d male first cousin, ' . I18N::PLURAL . '%2$s has %1$d male first cousins, '
                => '%2$s a %1$d cousin germain, ' . I18N::PLURAL . '%2$s a %1$d cousins germains, ',
            '%d female first cousin, and ' . I18N::PLURAL . '%d female first cousins, and '
                => '%d cousine germaine, et ' . I18N::PLURAL . '%d cousines germaines, et ',

            'Nephews and Nieces' => 'Neveux et nièces',
            '%s has no nephews or nieces recorded.' => '%s n\'a pas de neveux ou nièces enregistrés.',
            '%s has one niece recorded.' => '%s a une nièce enregistrée.',
            '%s has one nephew recorded.' => '%s a un neveu enregistré.',
            '%s has one nephew or niece of unknown sex recorded.' => '%s a un neveu ou une nièce de sexe inconnu enregistré.',
            '%s has one nephew or niece recorded.' => '%s a un neveu ou une nièce enregistrés.',
            '%2$s has %1$d niece recorded.' . I18N::PLURAL . '%2$s has %1$d nieces recorded.'
                => '%2$s a %1$d nièce enregistrée.' . I18N::PLURAL . '%2$s a %1$d nièces enregistrées.',
            '%2$s has %1$d nephew recorded.' . I18N::PLURAL . '%2$s has %1$d nephews recorded.'
                => '%2$s a %1$d neveu enregistré.' . I18N::PLURAL . '%2$s a %1$d neveux enregistrés.',
            '%2$s has %1$d nephew or niece of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d nephews or nieces of unknown sex recorded.'
                => '%2$s a %1$d neveu ou nièce de sexe inconnu enregistré.' . I18N::PLURAL . '%2$s a %1$d neveux ou nièces de sexe inconnu enregistrés.',
            '%2$s has %1$d nephew and ' . I18N::PLURAL . '%2$s has %1$d nephews and '
                => '%2$s a %1$d neveu et ' . I18N::PLURAL . '%2$s a %1$d neveux et ',
            '%d niece recorded (%d in total).' . I18N::PLURAL . '%d nieces recorded (%d in total).'
                => '%d nièce enregistrée (%d au total).' . I18N::PLURAL . '%d nièces enregistrées (%d au total).',
            '%2$s has %1$d niece and ' . I18N::PLURAL . '%2$s has %1$d nieces and '
                => '%2$s a %1$d nièce et ' . I18N::PLURAL . '%2$s a %1$d nièces et ',
            '%d nephew or niece of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d nephews or nieces of unknown sex recorded (%d in total).'
                => '%d neveu ou nièce de sexe inconnu enregistré (%d au total).' . I18N::PLURAL . '%d nephews or nieces of unknown sex recorded (%d in total).',
            '%2$s has %1$d nephew, ' . I18N::PLURAL . '%2$s has %1$d nephews, '
                => '%2$s a %1$d neveu, ' . I18N::PLURAL . '%2$s a %1$d neveux, ',
            '%d niece, and ' . I18N::PLURAL . '%d nieces, and '
                => '%d nièce, et ' . I18N::PLURAL . '%d nièces, et ',

            'Children' => 'Enfants',
            '%s has no children recorded.' => '%s n\'a pas d\'enfant enregistré.',
            '%s has one daughter recorded.' => '%s a une fille enregistrée.',
            '%s has one son recorded.' => '%s a un fils enregistré.',
            '%s has one child of unknown sex recorded.' => '%s a enregistré un enfant de sexe inconnu.',
            '%s has one child recorded.' => '%s a un fils ou une fille enregistré.',
            '%2$s has %1$d daughter recorded.' . I18N::PLURAL . '%2$s has %1$d daughters recorded.'
                => '%2$s a %1$d fille enregistrée.' . I18N::PLURAL . '%2$s a %1$d filles enregistrées.',
            '%2$s has %1$d son recorded.' . I18N::PLURAL . '%2$s has %1$d sons recorded.'
                => '%2$s a %1$d fils enregistré.' . I18N::PLURAL . '%2$s a %1$d fils enregistrés.',
            '%2$s has %1$d child of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d children of unknown sex recorded.'
                => '%2$s a enregistré %1$d enfant de sexe inconnu.' . I18N::PLURAL . '%2$s a %1$d enfants de sexe inconnu enregistrés.',
            '%2$s has %1$d son and ' . I18N::PLURAL . '%2$s has %1$d sons and '
                => '%2$s a %1$d fils et ' . I18N::PLURAL . '%2$s a %1$d fils et ',
            '%d daughter recorded (%d in total).' . I18N::PLURAL . '%d daughters recorded (%d in total).'
                => '%d fille enregistrée (%d au total).' . I18N::PLURAL . '%d filles enregistrées (%d au total).',
            '%2$s has %1$d daughter and ' . I18N::PLURAL . '%2$s has %1$d daughters and '
                => '%2$s a %1$d fille et ' . I18N::PLURAL . '%2$s a %1$d filles et ',
            '%d child of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d children of unknown sex recorded (%d in total).'
                => '%d enfant de sexe inconnu enregistré (%d au total).' . I18N::PLURAL . '%d enfants de sexe inconnu enregistrés (%d au total).',
            '%2$s has %1$d son, ' . I18N::PLURAL . '%2$s has %1$d sons, '
                => '%2$s a %1$d fils, ' . I18N::PLURAL . '%2$s a %1$d fils, ',
            '%d daughter, and ' . I18N::PLURAL . '%d daughters, and '
                => '%d fille, et ' . I18N::PLURAL . '%d filles, et ',

            'Children-in-law' => 'Beaux-enfants',
            '%s has no children-in-law recorded.' => '%s n\'a pas de beaux-enfants enregistrés.',
            '%s has one daughter-in-law recorded.' => '%s a une belle-fille enregistrée.',
            '%s has one son-in-law recorded.' => '%s a un beau-fils enregistré.',
            '%s has one child-in-law of unknown sex recorded.' => '%s a un beau-enfant de sexe inconnu enregistré.',
            '%s has one child-in-law recorded.' => '%s a un beau-fils/belle fille enregistré.',
            '%2$s has %1$d daughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d daughters-in-law recorded.'
                => '%2$s a %1$d belle-fille enregistré.' . I18N::PLURAL . '%2$s a %1$d belles-filles enregistrées.',
            '%2$s has %1$d son-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sons-in-law recorded.'
                => '%2$s a %1$d beau-fils enregistré.' . I18N::PLURAL . '%2$s a %1$d beaux-fils enregistrés.',
            '%2$s has %1$d child-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d children-in-law recorded.'
                => '%2$s a %1$d beau-fils/belle-fille enregistré.' . I18N::PLURAL . '%2$s a %1$d beaux-fils/belles-filles enregistrés.',
            '%2$s has %1$d son-in-law and ' . I18N::PLURAL . '%2$s has %1$d sons-in-law and '
                => '%2$s a %1$d beau-fils et ' . I18N::PLURAL . '%2$s a %1$d beaux-fils et ',
            '%d daughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d daughters-in-law recorded (%d in total).'
                => '%d belle-fille enregistrée (%d au total).' . I18N::PLURAL . '%d belles-filles enregistrées (%d au total).',
            '%2$s has %1$d daughter-in-law and ' . I18N::PLURAL . '%2$s has %1$d daughters-in-law and '
                => '%2$s a %1$d belle-fille et ' . I18N::PLURAL . '%2$s a %1$d belles-filles et ',
            '%d child-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d children-in-law of unknown sex recorded (%d in total).'
                => '%d beau-fils /belle-fille de sexe inconnu enregistré (%d au total).' . I18N::PLURAL . '%d beaux-enfants de sexe inconnu enregistrés (%d au total).',
            '%2$s has %1$d son-in-law, ' . I18N::PLURAL . '%2$s has %1$d sons-in-law, '
                => '%2$s a %1$d beau-fils, ' . I18N::PLURAL . '%2$s a %1$d beaux-fils, ',
            '%d daughter-in-law, and ' . I18N::PLURAL . '%d daughters-in-law, and '
                => '%d belle-fille, et ' . I18N::PLURAL . '%d belles-filles, et ',

            'Grandchildren' => 'Petits-enfants',
            '%s has no grandchildren recorded.' => '%s n\'a pas de petit-enfant enregistré.',
            '%s has one granddaughter recorded.' => '%s a une petite-fille enregistrée.',
            '%s has one grandson recorded.' => '%s a un petit-fils enregistré.',
            '%s has one grandchild of unknown sex recorded.' => '%s a un petit-enfant de sexe inconnu enregistré.',
            '%s has one grandchild recorded.' => '%s a un petit-enfant enregistré.',
            '%2$s has %1$d granddaughter recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters recorded.'
                => '%2$s a %1$d petite-fille enregistrée.' . I18N::PLURAL . '%2$s a %1$d petites-filles enregistrées.',
            '%2$s has %1$d grandson recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons recorded.'
                => '%2$s a %1$d petit-fils enregistré.' . I18N::PLURAL . '%2$s a %1$d petits-fils enregistrés.',
            '%2$s has %1$d grandchild of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandchildren of unknown sex recorded.'
                => '%2$s a %1$d petit-enfant de sexe inconnu enregistré.' . I18N::PLURAL . '%2$s a %1$d petits-enfants de sexe inconnu enregistrés.',
            '%2$s has %1$d grandson and ' . I18N::PLURAL . '%2$s has %1$d grandsons and '
                => '%2$s a %1$d petit-fils et ' . I18N::PLURAL . '%2$s a %1$d petits-fils et ',
            '%d granddaughter recorded (%d in total).' . I18N::PLURAL . '%d granddaughters recorded (%d in total).'
                => '%d petite-fille enregistrée (%d au total).' . I18N::PLURAL . '%d petites-filles enregistrées (%d au total).',
            '%2$s has %1$d granddaughter and ' . I18N::PLURAL . '%2$s has %1$d granddaughters and '
                => '%2$s a %1$d petite-fille et ' . I18N::PLURAL . '%2$s a %1$d petites-filles et ',
            '%d grandchild of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandchildren of unknown sex recorded (%d in total).'
                => '%d petit-enfant de sexe inconnu enregistré (%d au total).' . I18N::PLURAL . '%d petits-enfants de sexe inconnu enregistrés (%d au total).',
            '%2$s has %1$d grandson, ' . I18N::PLURAL . '%2$s has %1$d grandsons, '
                => '%2$s a %1$d petit-fils, ' . I18N::PLURAL . '%2$s a %1$d petits-fils, ',
            '%d granddaughter, and ' . I18N::PLURAL . '%d granddaughters, and '
                => '%d petite-fille, et ' . I18N::PLURAL . '%d petites-filles, et ',

            'Grandchildren-in-law' => 'Beaux-enfants',
            '%s has no grandchildren-in-law recorded.' => '%s n\'a pas de beaux-enfants enregistrés.',
            '%s has one granddaughter-in-law recorded.' => '%s a une petite belle-fille enregistrée.',
            '%s has one grandson-in-law recorded.' => '%s a un petit-fils ou une petite-fille enregistré(e).',
            '%s has one grandchild-in-law of unknown sex recorded.' => '%s a un petit-fils ou une petite-fille de sexe inconnu enregistré.',
            '%2$s has %1$d granddaughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters-in-law recorded.'
                => '%2$s a %1$d petite-belle-fille enregistrée.' . I18N::PLURAL . '%2$s a %1$d petites-belles-filles enregistrées.',
            '%2$s has %1$d grandson-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons-in-law recorded.'
                => '%2$s a %1$d petits-enfants enregistrés.' . I18N::PLURAL . '%2$s a %1$d petits-bois enregistrés.',
            '%2$s has %1$d grandchild-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandchildren-in-law of unknown sex recorded.'
                => '%2$s a %1$d petit-fils ou petite-fille de sexe inconnu enregistré.' . I18N::PLURAL . '%2$s a %1$d beaux-enfants de sexe inconnu enregistrés.',
            '%2$s has %1$d grandson-in-law and ' . I18N::PLURAL . '%2$s has %1$d grandsons-in-law and '
                => '%2$s a %1$d petits-fils par alliance et ' . I18N::PLURAL . '%2$s a %1$d petits-fils par alliance et ',
            '%d granddaughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d granddaughters-in-law recorded (%d in total).'
                => '%d belle-fille enregistrée (%d au total).' . I18N::PLURAL . '%d petites-filles-belles-filles enregistrées (%d au total).',
            '%2$s has %1$d granddaughter-in-law and ' . I18N::PLURAL . '%2$s has %1$d granddaughters-in-law and '
                => '%2$s a %1$d petite-fille-belle-fille et ' . I18N::PLURAL . '%2$s a %1$d petites-filles par alliance et ',
            '%d grandchild-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandchildren-in-law of unknown sex recorded (%d in total).'
                => '%d beaux-enfants de sexe inconnu enregistrés (%d au total).' . I18N::PLURAL . '%d petits-enfants-belles-filles de sexe inconnu enregistrés (%d au total).',
            '%2$s has %1$d grandson-in-law, ' . I18N::PLURAL . '%2$s has %1$d grandsons-in-law, '
                => '%2$s a %1$d petit-fils par alliance, ' . I18N::PLURAL . '%2$s a %1$d petits-fils par alliance, ' ,
            '%d granddaughter-in-law, and ' . I18N::PLURAL . '%d granddaughters-in-law, and '
                => '%d petite-fille-belle-fille, et ' . I18N::PLURAL . '%d petites-filles-belles-filles, et ',
        ];
    }

    /**
     * @return array
     */
    public static function hindiTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'विस्तृत परिवार',
            'A tab showing the extended family of an individual.' => 'किसी व्यक्ति के विस्तृत परिवार को दर्शाने वाला टैब।',
            'In which sequence should the parts of the extended family be shown?' => 'विस्तारित परिवार के भागों को किस क्रम में दिखाया जाना चाहिए?',
            'Family part' => 'परिवार का हिस्सा',
            'Show name of proband as short name or as full name?' => 'विषय का नाम संक्षिप्त नाम के रूप में या पूरे नाम के रूप में दिखाएं?',
            'Show options to filter the results (gender and alive/dead)?' => 'परिणामों को फ़िल्टर करने के लिए विकल्प दिखाएं (लिंग और जीवित/मृत)?',
            'Show filter options' => 'फ़िल्टर विकल्प दिखाएं',
            'How should empty parts of extended family be presented?' => 'विस्तारित परिवार के खाली हिस्सों को कैसे प्रस्तुत किया जाना चाहिए?',
            'Show empty block' => 'खाली ब्लॉक दिखाएं',
            'yes, always at standard location' => 'हाँ, हमेशा मानक स्थान पर',
            'no, but collect messages about empty blocks at the end' => 'नहीं, लेकिन अंत में खाली ब्लॉकों के बारे में संदेश एकत्र करें',
            'never' => 'कभी नहीं',
            'The short name is based on the probands Rufname or nickname. If these are not available, the first of the given names is used, if one is given. Otherwise the last name is used.' => 'संक्षिप्त नाम रूफनाम या उपनाम की जांच पर आधारित है।  यदि ये उपलब्ध नहीं हैं, तो दिए गए नामों में से पहले का प्रयोग किया जाता है, यदि कोई दिया गया हो।  अन्यथा अंतिम नाम का उपयोग किया जाता है।',
            'Show short name' => 'संक्षिप्त नाम दिखाएं',
            'Show labels in special situations?' => 'विशेष परिस्थितियों में लेबल दिखाएं?',
            'Labels (or stickers) are used for example for adopted persons or foster children.' => 'उदाहरण के लिए गोद लिए गए व्यक्तियों या पालक बच्चों के लिए लेबल (या स्टिकर) का उपयोग किया जाता है।',
            'Show labels' => 'लेबल दिखाएं',
            'Use the compact design?' => 'कॉम्पैक्ट डिज़ाइन का उपयोग करें?',
            'Use the compact design' => 'कॉम्पैक्ट डिज़ाइन का उपयोग करें',
            'The compact design only shows the name and life span for each person. The enriched design also shows a photo (if this is activated for this tree) as well as birth and death information.' => 'कॉम्पैक्ट डिज़ाइन प्रत्येक व्यक्ति के लिए केवल नाम और जीवन काल दिखाता है।  समृद्ध डिज़ाइन एक तस्वीर (यदि यह इस वंशवृक्ष के लिए सक्रिय है) के साथ-साथ जन्म और मृत्यु की जानकारी भी दिखाता है।',
            'Show parameters of extended family part?' => 'विस्तारित पारिवारिक भाग के पैरामीटर दिखाएँ?',
            'Display of additional information for each part of the extended family, such as the generation shift and the coefficient of relationship, which is a measure of the degree of consanguinity.' => 'विस्तारित परिवार के प्रत्येक भाग के लिए अतिरिक्त जानकारी का प्रदर्शन, जैसे कि पीढ़ी का बदलाव और रिश्ते का गुणांक, जो कि समानता की डिग्री का एक उपाय है।',
            'Show parameters' => 'पैरामीटर दिखाएं',

            'generation +%s' => 'पीढ़ी +%s',
            'same generation' => 'एक ही पीढ़ी',
            'generation %s' => 'पीढ़ी %s',
            'relationship coefficient: %.1f' => 'संबंध गुणांक: %.1f',
            'no blood relationship' => 'खून का रिश्ता नहीं',

            'don\'t use this filter' => 'इस फ़िल्टर का उपयोग न करें',
            'show only male persons' => 'केवल पुरुष व्यक्तियों को दिखाएं',
            'show only female persons' => 'केवल महिला व्यक्तियों को दिखाएं',
            'show only persons of unknown gender' => 'केवल अज्ञात लिंग के व्यक्तियों को दिखाएं',
            'show only alive persons' => 'केवल जिवित व्यक्तियों को दिखाएं',
            'show only dead persons' => 'केवल मृतक व्यक्तियों को दिखाएं',
            'alive' => 'जिवित',
            'dead' => 'मृत',
            'a dead person' => 'एक मृत व्यक्ति',
            'a living person' => 'एक जीवित व्यक्ति',
            'not a male person' => 'पुरुष व्यक्ति नहीं',
            'not a female person' => 'महिला व्यक्ति नहीं',
            'not a person of unknown gender' => 'अज्ञात लिंग का व्यक्ति नहीं',

            'twin' => 'जुड़वां',
            'triplet' => 'त्रिक',
            'quadruplet' => 'चतुष्क',
            'quintuplet' => 'पंचक',
            'sextuplet' => 'षटक',
            'septuplet' => 'सप्तक',
            'octuplet' => 'अष्टक',
            'nonuplet' => 'नवक',
            'decuplet' => 'दशक',
            'stillborn' => 'मृत जन्म',
            'died as infant' => 'बचपन में मृत',
            'linkage challenged' => 'संबंध संदिग्ध',
            'linkage disproven' => 'संबंध अस्वीकृत',
            'linkage proven' => 'संबंध स्वीकृत',
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
    public static function norwegianBokmålTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family'  => 'Storfamilie',
            'A tab showing the extended family of an individual.'  => 'En fane som viser en persons storfamilie.',
            'In which sequence should the parts of the extended family be shown?'  => 'I hvilken rekkefølge skal storfamiliens deler vises?',
            'Family part'  => 'Familiedel',
            'Show name of proband as short name or as full name?'  => 'Skal hovedpersonens navn vises i kortform eller som fullt navn?',
            'Show options to filter the results (gender and alive/dead)?'  => 'Vis alternativ for å filtrere resultatene (kjønn og nålevende/døde)?',
            'Show filter options'  => 'Vis filteralternativ',
            'How should empty parts of extended family be presented?'  => 'Hvordan skal manglende deler av storfamilien vises?',
            'Show empty block'  => 'Vis tomme familiedeler',
            'yes, always at standard location'  => 'ja, alltid på vanlig sted',
            'no, but collect messages about empty blocks at the end'  => 'nei, men samle opplysninger om manglende familiedeler til sist',
            'never'  => 'aldri',
            'The short name is based on the probands Rufname or nickname. If these are not available, the first of the given names is used, if one is given. Otherwise the last name is used.'  => 'Kortformen er basert på hovedpersonens kallenavn. Er dette ikke registrert, blir det første fornavnet brukt, så lenge det er registrert. Ellers brukes etternavnet.',
            'Show short name'  => 'Vis kortform av navnet',
            'Show labels in special situations?'  => 'Vis etiketter i spesielle situasjoner?',
            'Labels (or stickers) are used for example for adopted persons or foster children.'  => 'Etiketter brukes f.eks. for adoptivbarn eller fosterbarn.',
            'Show labels'  => 'Vis etiketter',
            'Use the compact design?'  => 'Bruk kompakt design?',
            'Use the compact design'  => 'Bruk kompakt design',
            'The compact design only shows the name and life span for each person. The enriched design also shows a photo (if this is activated for this tree) as well as birth and death information.'  => 'Kompakt design viser bare navn og levetid for hver person. Utvidet design viser dessuten bilde (hvis det er aktivert for dette slektstreet) og informasjoner om fødsel og død.',
            'Show parameters of extended family part?'  => 'Vis parametre for de utvidede familiedelene?',
            'Display of additional information for each part of the extended family, such as the generation shift and the coefficient of relationship, which is a measure of the degree of consanguinity.'  => 'Visning av tilleggsinformasjon for hver enkelt del av storfamilien, som f.eks. generasjonsorskyvning og slektskapskoeffisient, som er et mål for graden av blodsslektskap.',
            'Show parameters'  => 'Vis parametre',

            'generation +%s'  => 'generasjon +%s',
            'same generation'  => 'samme generasjon',
            'generation %s'  => 'generasjon %s',
            'relationship coefficient: %.1f'  => 'slektskapskoeffisient: %.1f',
            'no blood relationship'  => 'intet blodsbånd',

            'don\'t use this filter'  => 'bruk ikke dette filteret',
            'show only male persons'  => 'vis bare personer av hankjønn',
            'show only female persons'  => 'vis bare personer av hunkjønn',
            'show only persons of unknown gender'  => 'vis bare personer av ukjent kjønn',
            'show only alive persons'  => 'vis bare nålevende personer',
            'show only dead persons'  => 'vis bare avdøde personer',
            'alive'  => 'nålevende',
            'dead'  => 'død',
            'a dead person'  => 'en avdød person',
            'a living person'  => 'en nålevende person',
            'not a male person'  => 'ingen person av hankjønn',
            'not a female person'  => 'ingen person av hunkjønn',
            'not a person of unknown gender'  => 'ingen person av ukjent kjønn',
            'twin'  => 'tvilling',
            'triplet'  => 'trilling',
            'quadruplet'  => 'firling',
            'quintuplet'  => 'femling',
            'sextuplet'  => 'seksling',
            'septuplet'  => 'syvling',
            'octuplet'  => 'åttling',
            'nonuplet'  => 'niling',
            'decuplet'  => 'tiling',
            'stillborn'  => 'dødfødt',
            'died as infant'  => 'død som spedbarn',
            'linkage challenged'  => 'usikkert slektskap',
            'linkage disproven'  => 'påviselig manglende slektskap',
            'linkage proven'  => 'påvist slektskap',
            'Marriage'  => 'Ekteskap',
            'Ex-marriage'  => 'Tidligere ekteskap',
            'Partnership'  => 'Partnerskap',
            'Fiancée'  => 'Forlovelse',
            ' with '  => ' med ',
            'Biological grandparents of father'  => 'Fars biologiske besteforeldre',
            'Biological grandparents of mother'  => 'Mors biologiske besteforeldre',
            'Biological grandparents of parent'  => 'Forelders biologiske besteforeldre',
            'Stepparents of biological parent of father'  => 'Steforeldre til fars biologiske forelder',
            'Stepparents of biological parent of mother'  => 'Steforeldre til mors biologiske forelder',
            'Stepparents of biological grandparent'  => 'Steforeldre til en biologisk besteforelder',
            'Parents of stepparent of father'  => 'Fars steforelders foreldre',
            'Parents of stepparent of mother'  => 'Mors steforelders foreldre',
            'Parents of stepparent of parent'  => 'Foreldre til en forelders steforelder',
            'Grandparents of stepparent'  => 'Besteforeldre til steforelder',
            'Biological great-grandparents'  => 'Biologiske oldeforeldre',
            'Biological parents of father'  => 'Biologiske farforeldre',
            'Biological parents of mother'  => 'Biologiske morforeldre',
            'Biological parents of parent'  => 'Biologiske besteforeldre',
            'Stepparents of father'  => 'Fars steforeldre',
            'Stepparents of mother'  => 'Mors steforeldre',
            'Stepparents of parent'  => 'Forelders steforeldre',
            'Parents of stepparent'  => 'Steforelders foreldre',
            'Biological grandparents'  => 'Biologiske besteforeldre',
            'Siblings of father'  => 'Fars søsken',
            'Siblings of mother'  => 'Mors søsken',
            'Full siblings of biological parents'  => 'Helsøsken av biologiske foreldre',
            'Siblings-in-law of father'  => 'Fars svigersøsken',
            'Siblings-in-law of mother'  => 'Mors svigersøsken',
            'Biological parents'  => 'Biologiske foreldre',
            'Stepparents'  => 'Steforeldre',
            'Parents-in-law of biological children'  => 'Biologisk barns svigerforeldre',
            'Parents-in-law of stepchildren'  => 'Stebarns svigerforeldre',
            'Full siblings'  => 'Helsøsken',
            'Half siblings'  => 'Halvsøsken',
            'Stepsiblings'  => 'Stesøsken',
            'Children of full siblings of father'  => 'Barn av fars helsøsken',
            'Children of full siblings of mother'  => 'Barn av mors helsøsken',
            'Children of full siblings of parent'  => 'Barn av en forelders helsøsken',
            'Children of half siblings of father'  => 'Barn av fars halvsøsken',
            'Children of half siblings of mother'  => 'Barn av mors halvsøsken',
            'Children of half siblings of parent'  => 'Barn av en forelders halvsøsken',
            'Siblings of partners'  => 'Partners søsken',
            'Partners of siblings'  => 'Søskens partner',
            'Siblings of siblings-in-law'  => 'Søsken av svigersøsken',
            'Partners of siblings-in-law'  => 'Svigersøskens partner',
            'Children of full siblings of biological parents'  => 'Barn av en biologisk forelders helsøsken',
            'Children of siblings'  => 'Barn av søsken',
            'Children of full siblings'  => 'Barn av helsøsken',
            'Siblings\' stepchildren'  => 'Søskens stebarn',
            'Children of siblings of partners'  => 'Barn av partners søsken',
            'Biological children'  => 'Biologiske barn',
            'Stepchildren'  => 'Stebarn',
            'Stepchild'  => 'Stebarn',
            'Stepson'  => 'Stesønn',
            'Stepdaughter'  => 'Stedatter',
            'Partners of biological children'  => 'Biologiske barns partner',
            'Partners of stepchildren'  => 'Stebarns partner',
            'Biological grandchildren'  => 'Biologiske barnebarn',
            'Stepchildren of children'  => 'Barns stebarn',
            'Children of stepchildren'  => 'Stebarns barn',
            'Stepchildren of stepchildren'  => 'Stebarns stebarn',
            'Partners of biological grandchildren'  => 'Biologisk barnebarns partner',
            'Partners of stepchildren of children'  => 'Barns stebarns partner',
            'Partners of children of stepchildren'  => 'Stebarns barns partner',
            'Partners of stepchildren of stepchildren'  => 'Stebarns stebarns partner',

            'He'  => 'Han',
            'She'  => 'Hun',
            'He/she'  => 'Han/hun',
            'Mr.'  => 'Herr',
            'Mrs.'  => 'Fru',
            'No family available'  => 'Ingen familie funnet',
            'Summary for the shown extended family' => 'Summary for the shown extended family',
            'The extended family of %1$s has one member.' . I18N::PLURAL . 'The extended family of %1$s has %2$d members.'
                => 'The extended family of %1$s has one member.' . I18N::PLURAL . 'The extended family of %1$s has %2$d members.',
            '%s has no %s recorded.'  => '%s har ingen registrerte %s.',
            '%s has no %s, and no %s recorded.'  => '%s har ingen registrerte %s og ingen %s.',

            'Father\'s family (%d)'  => 'Fars familie (%d)',
            'Mother\'s family (%d)'  => 'Mors familie (%d)',
            'Father\'s and Mother\'s family (%d)'  => 'Fars og mors familie (%d)',
            'Grandparents %1$s (%2$s) of stepfather %3$s'  => 'Besteforeldre %1$s (%2$s) til stefar %3$s',
            'Grandparents %1$s (%2$s) of stepmother %3$s'  => 'Besteforeldre %1$s (%2$s) til stemor %3$s',
            'Grandparents %1$s (%2$s) of stepparent %3$s'  => 'Besteforeldre %1$s (%2$s) til steforelder %3$s',
            'Stepparents %1$s (%2$s) of %3$s'  => 'Steforeldre %1$s (%2$s) til %3$s',
            'Parents %1$s (%2$s) of stepfather %3$s'  => 'Foreldre %1$s (%2$s) til stefar %3$s',
            'Parents %1$s (%2$s) of stepmother %3$s'  => 'Foreldre %1$s (%2$s) til stemor %3$s',
            'Parents %1$s (%2$s) of stepparent %3$s'  => 'Foreldre %1$s (%2$s) til steforelder %3$s',
            'Parents %1$s of %2$s'  => 'Foreldre %1$s til %2$s',
            'Parents %1$s (%2$s) of %3$s'  => 'Foreldre %1$s (%2$s) til %3$s',
            'Partners of %s'  => 'Partner til %s',
            'Brother %1$s of partner %2$s'  => 'Bror %1$s til partner %2$s',
            'Sister %1$s of partner %2$s'  => 'Søster %1$s til partner %2$s',
            'Sibling %1$s of partner %2$s'  => 'Søsken %1$s til partner %2$s',

            'Great-grandparents'  => 'Oldeforeldre',
            '%s has no great-grandparents recorded.'  => '%s har ingen registrerte oldeforeldre.',
            '%s has one great-grandmother recorded.'  => '%s har én registrert oldemor.',
            '%s has one great-grandfather recorded.'  => '%s har én registrert oldefar.',
            '%s has one great-grandparent of unknown sex recorded.'  => '%s har én registrert oldeforelder av ukjent kjønn.',
            '%2$s has %1$d great-grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandmothers recorded.'  => '%2$s har %1$d registrert oldemor.' . I18N::PLURAL . '%2$s har %1$d registrerte oldemødre.',
            '%2$s has %1$d great-grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandfathers recorded.'  => '%2$s har %1$d registrert oldefar.' . I18N::PLURAL . '%2$s har %1$d registrerte oldefedre.',
            '%2$s has %1$d great-grandparent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandparents of unknown sex recorded.'  => '%2$s har %1$d registrert oldeforelder av ukjent kjønn.' . I18N::PLURAL . '%2$s har %1$d registrerte oldeforeldre av ukjent kjønn.',
            '%2$s has %1$d great-grandfather and ' . I18N::PLURAL . '%2$s has %1$d great-grandfathers and '  => '%2$s har %1$d registrert oldefar og' . I18N::PLURAL . '%2$s har %1$d registrerte oldeforeldre og ',
            '%d great-grandmother recorded (%d in total).' . I18N::PLURAL . '%d great-grandmothers recorded (%d in total).'  => '%d oldemor registrert (til sammen %d).' . I18N::PLURAL . '%d oldemødre registrert (til sammen %d).',
            '%2$s has %1$d great-grandmother and ' . I18N::PLURAL . '%2$s has %1$d great-grandmothers and '  => '%2$s har %1$d registrert oldemor og ' . I18N::PLURAL . '%2$s har %1$d registrerte oldemødre og ',
            '%d great-grandparent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d great-grandparents of unknown sex recorded (%d in total).'  => '%d oldeforelder av ukjent kjønn registrert (til sammen %d).' . I18N::PLURAL . '%d oldeforeldre av ukjent kjønn registrert (til sammen %d).',
            '%2$s has %1$d great-grandfather, ' . I18N::PLURAL . '%2$s has %1$d great-grandfathers, '  => '%2$s har %1$d registrert oldefar, ' . I18N::PLURAL . '%2$s har %1$d oldefedre, ',
            '%d great-grandmother, and ' . I18N::PLURAL . '%d great-grandmothers, and '  => '%d oldemor, og ' . I18N::PLURAL . '%d oldemødre, og ',

            'Grandparents'  => 'Besteforeldre',
            '%s has no grandparents recorded.'  => '%s har ingen registrerte besteforeldre.',
            '%s has one grandmother recorded.'  => '%s har én registrert bestemor.',
            '%s has one grandfather recorded.'  => '%s har én registrert bestefar.',
            '%s has one grandparent of unknown sex recorded.'  => '%s har én registrert besteforelder av ukjent kjønn.',
            '%2$s has %1$d grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d grandmothers recorded.'  => '%2$s har %1$d registrert bestemor.' . I18N::PLURAL . '%2$s har %1$d registrerte bestemødre.',
            '%2$s has %1$d grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d grandfathers recorded.'  => '%2$s har %1$d registrert bestefar.' . I18N::PLURAL . '%2$s har %1$d registrerte bestefedre.',
            '%2$s has %1$d grandparent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandparents of unknown sex recorded.'  => '%2$s har %1$d registrert besteforelder av ukjent kjønn.' . I18N::PLURAL . '%2$s har %1$d registrerte besteforeldre av ukjent kjønn.',
            '%2$s has %1$d grandfather and ' . I18N::PLURAL . '%2$s has %1$d grandfathers and '   => '%2$s har %1$d registrert bestefar og ' . I18N::PLURAL . '%2$s har %1$d registrerte bestefedre og ',
            '%d grandmother recorded (%d in total).' . I18N::PLURAL . '%d grandmothers recorded (%d in total).'   => '%d bestemor registrert (til sammen %d).' . I18N::PLURAL . '%d bestemødre registrert (til sammen %d).',
            '%2$s has %1$d grandmother and ' . I18N::PLURAL . '%2$s has %1$d grandmothers and '  => '%2$s har %1$d registrert bestemor og ' . I18N::PLURAL . '%2$s har %1$d registrerte bestemødre og ',
            '%d grandparent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandparents of unknown sex recorded (%d in total).'  => '%d besteforelder av ukjent kjønn registrert (til sammen %d).' . I18N::PLURAL . '%d besteforeldre av ukjent kjønn registrert (til sammen %d).',
            '%2$s has %1$d grandfather, ' . I18N::PLURAL . '%2$s has %1$d grandfathers, '  => '%2$s har %1$d registrert bestefar, ' . I18N::PLURAL . '%2$s har %1$d bestefedre, ',
            '%d grandmother, and ' . I18N::PLURAL . '%d grandmothers, and '  => '%d bestemor og ' . I18N::PLURAL . '%d bestemødre og ',

            'Uncles and Aunts'  => 'Onkler og tanter',
            '%s has no uncles or aunts recorded.'  => '%s har ingen registrerte onkler eller tanter.',
            '%s has one aunt recorded.'  => '%s har én registrert tante.',
            '%s has one uncle recorded.'  => '%s har én registrert onkel.',
            '%s has one uncle or aunt of unknown sex recorded.'  => '%s har én registrert onkel eller tante av ukjent kjønn.',
            '%2$s has %1$d aunt recorded.' . I18N::PLURAL . '%2$s has %1$d aunts recorded.'  => '%2$s har %1$d registrert tante.' . I18N::PLURAL . '%2$s har %1$d registrerte tanter.',
            '%2$s has %1$d uncle recorded.' . I18N::PLURAL . '%2$s has %1$d uncles recorded.'  => '%2$s har %1$d registrert onkel.' . I18N::PLURAL . '%2$s har %1$d registrerte onkler.',
            '%2$s has %1$d uncle or aunt of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d uncles or aunts of unknown sex recorded.'  => '%2$s har %1$d registrert onkel eller tante av ukjent kjønn.' . I18N::PLURAL . '%2$s har %1$d registrerte onkler eller tanter av ukjent kjønn.',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and '   => '%2$s har %1$d registrert onkel og ' . I18N::PLURAL . '%2$s har %1$d registrerte onkler og ',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).'  => '%d tante (til sammen %d).' . I18N::PLURAL . '%d tanter (til sammen %d).',
            '%2$s has %1$d aunt and ' . I18N::PLURAL . '%2$s has %1$d aunts and '  => '%2$s har %1$d registrert tante og ' . I18N::PLURAL . '%2$s har %1$d registrerte tanter og ',
            '%d uncle or aunt of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d uncles or aunts of unknown sex recorded (%d in total).'  => '%d onkel eller tante av ukjent kjønn (til sammen %d).' . I18N::PLURAL . '%d onkler eller tanter av ukjent kjønn (til sammen %d).',
            '%2$s has %1$d uncle, ' . I18N::PLURAL . '%2$s has %1$d uncles, '  => '%2$s har %1$d registrert onkel, ' . I18N::PLURAL . '%2$s har %1$d onkler, ',
            '%d aunt, and ' . I18N::PLURAL . '%d aunts, and '  => '%d tante, og ' . I18N::PLURAL . '%d tanter, og ',

            'Uncles and Aunts by marriage'  => 'Inngifte onkler og tanter',
            '%s has no uncles or aunts by marriage recorded.'  => '%s har ingen registrerte inngifte onkler eller tanter.',
            '%s has one aunt by marriage recorded.'  => '%s har én registrert inngift tante.',
            '%s has one uncle by marriage recorded.'  => '%s har én registrert inngift onkel.',
            '%s has one uncle or aunt by marriage of unknown sex recorded.'  => '%s har én registrert inngift onkel eller tante av ukjent kjønn.',
            '%2$s has %1$d aunt by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d aunts by marriage recorded.'  => '%2$s har %1$d registrert inngift tante.' . I18N::PLURAL . '%2$s har registrert %1$d inngifte tanter.',
            '%2$s has %1$d uncle by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d uncles by marriage recorded.'  => '%2$s har %1$d registrert inngift onkel.' . I18N::PLURAL . '%2$s har %1$d registrerte inngifte onkler.',
            '%2$s has %1$d uncle or aunt by marriage of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d uncles or aunts by marriage of unknown sex recorded.'  => '%2$s har %1$d registrert inngift onkel eller tante av ukjent kjønn.' . I18N::PLURAL . '%2$s har %1$d registrerte inngifte onkler eller tanter av ukjent kjønn.',
            '%2$s has %1$d uncle by marriage and ' . I18N::PLURAL . '%2$s has %1$d uncles by marriage and '  => '%2$s har registrert %1$d inngift onkel og ' . I18N::PLURAL . '%2$s har registrert %1$d inngifte onkler og ',
            '%d aunt by marriage recorded (%d in total).' . I18N::PLURAL . '%d aunts by marriage recorded (%d in total).'  => '%d inngift tante (til sammen %d).' . I18N::PLURAL . '%d inngifte tanter (til sammen %d).' ,
            '%2$s has %1$d aunt by marriage and ' . I18N::PLURAL . '%2$s has %1$d aunts by marriage and '  => '%2$s har registrert %1$d inngift tante og ' . I18N::PLURAL . '%2$s har registrert %1$d inngifte tanter og ',
            '%d uncle or aunt by marriage of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d uncles or aunts by marriage of unknown sex recorded (%d in total).'  => '%d inngift onkel eller tante av ukjent kjønn (til sammen %d).' . I18N::PLURAL . '%d inngifte onkler eller tanter av ukjent kjønn (til sammen %d).',
            '%2$s has %1$d uncle by marriage, ' . I18N::PLURAL . '%2$s has %1$d uncles by marriage, '  => '%2$s har %1$d registrert inngift onkel, ' . I18N::PLURAL . '%2$s har %1$d registrerte inngifte onkler, ',
            '%d aunt by marriage, and ' . I18N::PLURAL . '%d aunts by marriage, and '  => '%d inngift tante og ' . I18N::PLURAL . '%d inngifte tanter og ',

            'Parents'  => 'Foreldre',
            '%s has no parents recorded.'  => '%s har ingen registrerte foreldre.',
            '%s has one mother recorded.'  => '%s har én registrert mor.',
            '%s has one father recorded.'  => '%s har én registrert far.',
            '%s has one parent of unknown sex recorded.'  => '%s har én registrert forelder av ukjent kjønn.',
            '%2$s has %1$d mother recorded.' . I18N::PLURAL . '%2$s has %1$d mothers recorded.'  => '%2$s har %1$d registrert mor.' . I18N::PLURAL . '%2$s har %1$d registrerte mødre.',
            '%2$s has %1$d father recorded.' . I18N::PLURAL . '%2$s has %1$d fathers recorded.'  => '%2$s har %1$d registrert far.' . I18N::PLURAL . '%2$s har %1$d registrerte fedre.',
            '%2$s has %1$d parent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d parents of unknown sex recorded.'  => '%2$s har %1$d registrert forelder av ukjent kjønn.' . I18N::PLURAL . '%2$s har %1$d registrerte foreldre av ukjent kjønn.',
            '%2$s has %1$d father and ' . I18N::PLURAL . '%2$s has %1$d fathers and '  => '%2$s har %1$d registrert far og ' . I18N::PLURAL . '%2$s har %1$d registrerte fedre og ',
            '%d mother recorded (%d in total).' . I18N::PLURAL . '%d mothers recorded (%d in total).'  => '%d mor (til sammen %d).' . I18N::PLURAL . '%d mødre (til sammen %d).',
            '%2$s has %1$d mother and ' . I18N::PLURAL . '%2$s has %1$d mothers and '  => '%2$s har %1$d registrert mor og ' . I18N::PLURAL . '%2$s har %1$d registrerte mødre og ',
            '%d parent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d parents of unknown sex recorded (%d in total).'  => '%d forelder av ukjent kjønn (til sammen %d).' . I18N::PLURAL . '%d foreldre av ukjent kjønn (til sammen %d).',
            '%2$s has %1$d father, ' . I18N::PLURAL . '%2$s has %1$d fathers, '  => '%2$s har %1$d registrert far, ' . I18N::PLURAL . '%2$s har %1$d registrerte fedre, ',
            '%d mother, and ' . I18N::PLURAL . '%d mothers, and '  => '%d mor og ' . I18N::PLURAL . '%d mødre og ',

            'Parents-in-law'  => 'Svigerforeldre',
            '%s has no parents-in-law recorded.'  => '%s har ingen registrerte svigerforeldre.',
            '%s has one mother-in-law recorded.'  => '%s har én registrert svigermor.',
            '%s has one father-in-law recorded.'  => '%s har én registrert svigerfar.',
            '%s has one parent-in-law of unknown sex recorded.'  => '%s har én registrert svigerforelder av ukjent kjønn.',
            '%2$s has %1$d mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d mothers-in-law recorded.'  => '%2$s har %1$d registrert svigermor.' . I18N::PLURAL . '%2$s har %1$d registrerte svigermødre.',
            '%2$s has %1$d father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d fathers-in-law recorded.'  => '%2$s har %1$d registrert svigerfar.' . I18N::PLURAL . '%2$s har %1$d registrerte svigerfedre.',
            '%2$s has %1$d parent-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d parents-in-law of unknown sex recorded.'  => '%2$s har %1$d registrert svigerforelder av ukjent kjønn.' . I18N::PLURAL . '%2$s har %1$d registrerte svigerforeldre av ukjent kjønn.',
            '%2$s has %1$d father-in-law and ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law and '  => '%2$s har %1$d registrert svigerfar og ' . I18N::PLURAL . '%2$s har %1$d registrerte svigerfedre og ',
            '%d mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d mothers-in-law recorded (%d in total).'  => '%d svigermor (til sammen %d).' . I18N::PLURAL . '%d svigermødre (til sammen %d).',
            '%2$s has %1$d mother-in-law and ' . I18N::PLURAL . '%2$s has %1$d mothers-in-law and '  => '%2$s har %1$d registrert svigermor og ' . I18N::PLURAL . '%2$s har %1$d registrerte svigermødre og ',
            '%d parent-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d parents-in-law of unknown sex recorded (%d in total).'  => '%d svigerforelder av ukjent kjønn (til sammen %d).' . I18N::PLURAL . '%d svigerforeldre av ukjent kjønn (til sammen %d).',
            '%2$s has %1$d father-in-law, ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law, '  => '%2$s har %1$d registrert svigerfar, ' . I18N::PLURAL . '%2$s har %1$d svigerfedre, ',
            '%d mother-in-law, and ' . I18N::PLURAL . '%d mothers-in-law, and '  => '%d svigermor og ' . I18N::PLURAL . '%d svigermødre og ',

            'Co-parents-in-law'  => 'Barns svigerforeldre',
            '%s has no co-parents-in-law recorded.'  => '%s har ingen registrerte barns svigerforeldre.',
            '%s has one co-mother-in-law recorded.'  => '%s har én registrert barns svigermor.',
            '%s has one co-father-in-law recorded.'  => '%s har én registrert barns svigerfar.',
            '%s has one co-parent-in-law of unknown sex recorded.'  => '%s har én registrert barns svigerforelder av ukjent kjønn.',
            '%2$s has %1$d co-mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law recorded.'  => '%2$s har %1$d registrert barns svigermor.' . I18N::PLURAL . '%2$s har %1$d registrerte barns svigermødre.',
            '%2$s has %1$d co-father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law recorded.'  => '%2$s har %1$d registrert barns svigerfar.' . I18N::PLURAL . '%2$s har %1$d registrerte barns svigerfedre.',
            '%2$s has %1$d co-parent-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d co-parents-in-law of unknown sex recorded.'  => '%2$s har %1$d registrert barns svigerforelder av ukjent kjønn.' . I18N::PLURAL . '%2$s har %1$d registrerte barns svigerforeldre av ukjent kjønn.',
            '%2$s has %1$d co-father-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law and '  => '%2$s har registrert %1$d barns svigerfar og ' . I18N::PLURAL . '%2$s har registrert %1$d barns svigerfedre og ',
            '%d co-mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-mothers-in-law recorded (%d in total).'  => '%d barns svigermor (til sammen %d).' . I18N::PLURAL . '%d barns svigermødre (til sammen %d).',
            '%2$s has %1$d co-mother-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law and '  => '%2$s har registrert %1$d barns svigermor og ' . I18N::PLURAL . '%2$s har registrert %1$d barns svigermødre og ',
            '%d co-parent-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d co-parents-in-law of unknown sex recorded (%d in total).'  => '%d barns svigerforelder av ukjent kjønn (til sammen %d).' . I18N::PLURAL . '%d barns svigerforeldre av ukjent kjønn (til sammen %d).',
            '%2$s has %1$d co-father-in-law, ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law, '  => '%2$s har %1$d registrert barns svigerfar, ' . I18N::PLURAL . '%2$s har %1$d registrerte barns svigerfedre, ',
            '%d co-mother-in-law, and ' . I18N::PLURAL . '%d co-mothers-in-law, and '  => '%d barns svigermor, og ' . I18N::PLURAL . '%d barns svigermødre, og ',

            'Partners'  => 'Partnere',
            'Partner of '  => 'Partner av ',
            '%s has no partners recorded.'  => '%s har ingen registrerte partnere.',
            '%s has one female partner recorded.'  => '%s har én registrert kvinnelig partner.',
            '%s has one male partner recorded.'  => '%s har én registrert mannlig partner.',
            '%s has one partner of unknown sex recorded.'  => '%s har én registrert partner av ukjent kjønn.',
            '%2$s has %1$d female partner recorded.' . I18N::PLURAL . '%2$s has %1$d female partners recorded.'  => '%2$s har %1$d registrert kvinnelig partner.' . I18N::PLURAL . '%2$s har %1$d registrerte kvinnelige partnere.',
            '%2$s has %1$d male partner recorded.' . I18N::PLURAL . '%2$s has %1$d male partners recorded.'  => '%2$s har %1$d registrert mannlig partner.' . I18N::PLURAL . '%2$s har %1$d registrerte mannlige partnere.',
            '%2$s has %1$d partner of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d partners of unknown sex recorded.'  => '%2$s har %1$d registrert partner av ukjent kjønn.' . I18N::PLURAL . '%2$s har %1$d registrerte partnere av ukjent kjønn.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and '  => '%2$s har %1$d registrert mannlig partner og ' . I18N::PLURAL . '%2$s har %1$d registrerte mannlige partnere og ',
            '%2$s has %1$d female partner and ' . I18N::PLURAL . '%2$s has %1$d female partners and '  => '%2$s har registrert %1$d kvinnelig partner og ' . I18N::PLURAL . '%2$s har registrert %1$d kvinnelige partnere og ',
            '%d female partner recorded (%d in total).' . I18N::PLURAL . '%d female partners recorded (%d in total).'  => '%d kvinnelig partner (til sammen %d).' . I18N::PLURAL . '%d kvinnelige partnere (til sammen %d).',
            '%2$s has %1$d partner and ' . I18N::PLURAL . '%2$s has %1$d partners and '  => '%2$s har %1$d registrert partner og ' . I18N::PLURAL . '%2$s har %1$d registrerte partnere og ' ,
            '%d male partner of female partners recorded (%d in total).' . I18N::PLURAL . '%d male partners of female partners recorded (%d in total).'  => '%d mannlig partner av kvinnelige partnere (til sammen %d).' . I18N::PLURAL . '%d mannlige partnere av kvinnelige partnere (til sammen %d).',
            '%d female partner of male partners recorded (%d in total).' . I18N::PLURAL . '%d female partners of male partners recorded (%d in total).'  => '%d kvinnelig partner av mannlige partnere (til sammen %d).' . I18N::PLURAL . '%d kvinnelige partnere av mannlige partnere (til sammen %d).',

            'Partner chains'  => 'Partnerkjeder',
            '%s has no members of a partner chain recorded.'  => '%s inngår ikke i noen partnerkjede.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and '  => '%2$s har %1$d mannlig partner og ' . I18N::PLURAL . '%2$s har %1$d mannlige partnere og ',
            '%d female partner in this partner chain recorded (%d in total).' . I18N::PLURAL . '%d female partners in this partner chain recorded (%d in total).'  => '%d kvinnelig partner registrert i denne partnerkjeden (til sammen %d).' . I18N::PLURAL . '%d kvinnelige partnere registrert i denne partnerkjeden (til sammen %d).',
            '%d female partner and ' . I18N::PLURAL . '%d female partners and '  => '%d kvinnelig partner og ' . I18N::PLURAL . '%d kvinnelige partnere og ',
            '%d partner of unknown sex in this partner chain recorded (%d in total).' . I18N::PLURAL . '%d partners of unknown sex in this partner chain recorded (%d in total).'  => '%d partner av ukjent kjønn registrert i denne partnerkjeden (til sammen %d).' . I18N::PLURAL . '%d partnere av ukjent kjønn registrert i denne partnerkjeden (til sammen %d).',
            '%2$s has %1$d female partner and ' . I18N::PLURAL . '%2$s has %1$d female partners and '  => '%2$s har %1$d registrert kvinnelig partner og ' . I18N::PLURAL . '%2$s har %1$d registrerte kvinnelige partnere og ' ,
            '%d partner of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d partners of unknown sex recorded (%d in total).'  => '%d partner av ukjent kjønn registrert (til sammen %d).' . I18N::PLURAL . '%d partnere av ukjent kjønn registrert (til sammen %d).',
            '%2$s has %1$d male partner, ' . I18N::PLURAL . '%2$s has %1$d male partners, '  => '%2$s har %1$d registrert mannlig partner, ' . I18N::PLURAL . '%2$s har %1$d registrerte mannlige partnere, ',
            '%d female partner, and ' . I18N::PLURAL . '%d female partners, and '  => '%d kvinnelig partner og ' . I18N::PLURAL . '%d kvinnelige partnere og ' ,
            'There are %d branches in the partner chain. '  => 'Det er %d grener i partnerkjeden. ',
            'The longest branch in the partner chain to %2$s consists of %1$d partners (including %3$s).'  => 'Den lengste grenen i partnerkjeden med %2$s består av %1$d partnere (%3$s medregnet).',
            'The longest branch in the partner chain consists of %1$d partners (including %2$s).'  => 'Den lengste grenen i partnerkjeden består av %1$d partnere (%2$s medregnet).',

            'Siblings'  => 'Søsken',
            '%s has no siblings recorded.'  => '%s har ingen registrerte søsken.',
            '%s has one sister recorded.'  => '%s har én registrert søster.',
            '%s has one brother recorded.'  => '%s har én registrert bror.',
            '%s has one sibling of unknown sex recorded.'  => '%s har ett registrert søsken av ukjent kjønn.',
            '%2$s has %1$d sister recorded.' . I18N::PLURAL . '%2$s has %1$d sisters recorded.'  => '%2$s har %1$d registrert søster.' . I18N::PLURAL . '%2$s har %1$d registrerte søstre.',
            '%2$s has %1$d brother recorded.' . I18N::PLURAL . '%2$s has %1$d brothers recorded.'  => '%2$s har %1$d registrert bror.' . I18N::PLURAL . '%2$s har %1$d registrerte brødre.',
            '%2$s has %1$d sibling of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d siblings of unknown sex recorded.'  => '%2$s har %1$d registrert søsken av ukjent kjønn.' . I18N::PLURAL . '%2$s har %1$d registrerte søsken av ukjent kjønn.',
            '%2$s has %1$d brother and ' . I18N::PLURAL . '%2$s has %1$d brothers and '   => '%2$s har %1$d registrert bror og ' . I18N::PLURAL . '%2$s har %1$d brødre og ',
            '%d sister recorded (%d in total).' . I18N::PLURAL . '%d sisters recorded (%d in total).'   => '%d søster (til sammen %d).' . I18N::PLURAL . '%d søstre (til sammen %d).',
            '%2$s has %1$d sister and ' . I18N::PLURAL . '%2$s has %1$d sisters and '  => '%2$s har %1$d registrert søster og ' . I18N::PLURAL . '%2$s har %1$d registrerte søstre og ',
            '%d sibling of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d siblings of unknown sex recorded (%d in total).'  => '%d søsken av ukjent kjønn (til sammen %d).' . I18N::PLURAL . '%d søsken av ukjent kjønn (til sammen %d).',
            '%2$s has %1$d brother, ' . I18N::PLURAL . '%2$s has %1$d brothers, '  => '%2$s har %1$d registrert bror, ' . I18N::PLURAL . '%2$s har %1$d brødre, ',
            '%d sister, and ' . I18N::PLURAL . '%d sisters, and '  => '%d søster og ' . I18N::PLURAL . '%d søstre og ',

            'Siblings-in-law'  => 'Svigersøsken',
            '%s has no siblings-in-law recorded.'  => '%s har ingen registrerte svigersøsken.',
            '%s has one sister-in-law recorded.'  => '%s har én registrert svigerinne.',
            '%s has one brother-in-law recorded.'  => '%s har én registrert svoger.',
            '%s has one sibling-in-law of unknown sex recorded.'  => '%s har ett registrert svigersøsken av ukjent kjønn.',
            '%2$s has %1$d sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sisters-in-law recorded.'  => '%2$s har %1$d registrert svigerinne.' . I18N::PLURAL . '%2$s har %1$d registrerte svigerinner.',
            '%2$s has %1$d brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d brothers-in-law recorded.'  => '%2$s har %1$d registrert svoger.' . I18N::PLURAL . '%2$s har %1$d registrerte svogre.',
            '%2$s has %1$d sibling-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d siblings-in-law of unknown sex recorded.'  => '%2$s har %1$d registrert svigersøsken av ukjent kjønn.' . I18N::PLURAL . '%2$s har %1$d registrerte svigersøsken av ukjent kjønn.',
            '%2$s has %1$d brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law and '   => '%2$s har %1$d registrert svoger og ' . I18N::PLURAL . '%2$s har %1$d registrerte svogre og ',
            '%d sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d sisters-in-law recorded (%d in total).'   => '%d svigerinne (til sammen %d).' . I18N::PLURAL . '%d svigerinner (til sammen %d).',
            '%2$s has %1$d sister-in-law and ' . I18N::PLURAL . '%2$s has %1$d sisters-in-law and '  => '%2$s har %1$d registrert svigerinne og ' . I18N::PLURAL . '%2$s har %1$d registrerte svigerinner og ',
            '%d sibling-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d siblings-in-law of unknown sex recorded (%d in total).'  => '%d svigersøsken av ukjent kjønn (til sammen %d).' . I18N::PLURAL . '%d svigersøsken av ukjent kjønn (til sammen %d).',
            '%2$s has %1$d brother-in-law, ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law, '  => '%2$s har %1$d registrert svoger, ' . I18N::PLURAL . '%2$s har %1$d svogre, ',
            '%d sister-in-law, and ' . I18N::PLURAL . '%d sisters-in-law, and '  => '%d svigerinne, og ' . I18N::PLURAL . '%d svigerinner, og ',

            'Co-siblings-in-law'  => 'Ektefelles svigersøsken',
            '%s has no co-siblings-in-law recorded.'  => '%s har ingen registrerte ektefelles svigersøsken.',
            '%s has one co-sister-in-law recorded.'  => '%s har én registrert ektefelles svigerinne.',
            '%s has one co-brother-in-law recorded.'  => '%s har én registrert ektefelles svoger.',
            '%s has one co-sibling-in-law of unknown sex recorded.'  => '%s har ett registrert ektefelles svigersøsken av ukjent kjønn.',
            '%2$s has %1$d co-sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-sisters-in-law recorded.'  => '%2$s har %1$d registrert ektefelles svigerinne.' . I18N::PLURAL . '%2$s har %1$d registrerte ektefelles svigerinner.',
            '%2$s has %1$d co-brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law recorded.'  => '%2$s har %1$d registrert ektefelles svoger.' . I18N::PLURAL . '%2$s har %1$d registrerte ektefelles svogre.',
            '%2$s has %1$d co-sibling-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d co-siblings-in-law of unknown sex recorded.'  => '%2$s har %1$d registrert ektefelles svigersøsken av ukjent kjønn.' . I18N::PLURAL . '%2$s har %1$d registrerte ektefelles svigersøsken av ukjent kjønn.',
            '%2$s has %1$d co-brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law and '  => '%2$s har %1$d registrert ektefelles svoger og ' . I18N::PLURAL . '%2$s har %1$d registrerte ektefelles svogre og ',
            '%d co-sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-sisters-in-law recorded (%d in total).'   => '%d ektefelles svigerinne (til sammen %d).' . I18N::PLURAL . '%d ektefelles svigerinner (til sammen %d).',
            '%2$s has %1$d co-sister-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-sisters-in-law and '  => '%2$s har %1$d registrert ektefelles svigerinne og ' . I18N::PLURAL . '%2$s har %1$d registrerte ektefelles svigerinner og ',
            '%d co-sibling-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d co-siblings-in-law of unknown sex recorded (%d in total).'  => '%d ektefelles svigersøsken av ukjent kjønn (til sammen %d).' . I18N::PLURAL . '%d ektefelles svigersøsken av ukjent kjønn (til sammen %d).',
            '%2$s has %1$d co-brother-in-law, ' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law, '  => '%2$s har %1$d registrert ektefelles svoger, ' . I18N::PLURAL . '%2$s har %1$d registrerte ektefelles svogre, ',
            '%d co-sister-in-law, and ' . I18N::PLURAL . '%d co-sisters-in-law, and '  => '%d ektefelles svigerinne, og ' . I18N::PLURAL . '%d ektefelles svigerinner, og ',

            'Cousins'  => 'Søskenbarn',
            '%s has no first cousins recorded.'  => '%s har ingen registrerte søskenbarn.',
            '%s has one female first cousin recorded.'  => '%s har én registrert kusine.',
            '%s has one male first cousin recorded.'  => '%s har én registrert fetter.',
            '%s has one first cousin of unknown sex recorded.'  => '%s har ett registrert søskenbarn av ukjent kjønn.',
            '%2$s has %1$d female first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d female first cousins recorded.'  => '%2$s har %1$d registrert kusine.' . I18N::PLURAL . '%2$s har %1$d registrerte kusiner.',
            '%2$s has %1$d male first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d male first cousins recorded.'  => '%2$s har %1$d registrert fetter.' . I18N::PLURAL . '%2$s har %1$d registrerte fetre.',
            '%2$s has %1$d first cousin of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d first cousins of unknown sex recorded.'  => '%2$s har %1$d registrert søskenbarn av ukjent kjønn.' . I18N::PLURAL . '%2$s har %1$d registrerte søskenbarn av ukjent kjønn.',
            '%2$s has %1$d male first cousin and ' . I18N::PLURAL . '%2$s has %1$d male first cousins and '   => '%2$s har %1$d registrert fetter og ' . I18N::PLURAL . '%2$s har %1$d registrerte fetre og ',
            '%d female first cousin recorded (%d in total).' . I18N::PLURAL . '%d female first cousins recorded (%d in total).'   => '%d kusine (til sammen %d).' . I18N::PLURAL . '%d kusiner (til sammen %d).',
            '%2$s has %1$d female first cousin and ' . I18N::PLURAL . '%2$s has %1$d female first cousins and '  => '%2$s har %1$d registrert kusine og ' . I18N::PLURAL . '%2$s har %1$d registrerte kusiner og ',
            '%d first cousin of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d first cousins of unknown sex recorded (%d in total).'  => '%d søskenbarn av ukjent kjønn (til sammen %d).' . I18N::PLURAL . '%d søskenbarn av ukjent kjønn (til sammen %d).',
            '%2$s has %1$d male first cousin, ' . I18N::PLURAL . '%2$s has %1$d male first cousins, '  => '%2$s har %1$d registrert fetter, ' . I18N::PLURAL . '%2$s har %1$d fetre, ',
            '%d female first cousin, and ' . I18N::PLURAL . '%d female first cousins, and '  => '%d kusine og ' . I18N::PLURAL . '%d kusiner og ',

            'Nephews and Nieces'  => 'Nevøer og nieser',
            '%s has no nephews or nieces recorded.'  => '%s har ingen registrerte nevøer eller nieser.',
            '%s has one niece recorded.'  => '%s har én registrert niese.',
            '%s has one nephew recorded.'  => '%s har én registrert nevø.',
            '%s has one nephew or niece of unknown sex recorded.'  => '%s har én registrert nevø eller niese av ukjent kjønn.',
            '%2$s has %1$d niece recorded.' . I18N::PLURAL . '%2$s has %1$d nieces recorded.'  => '%2$s har %1$d registrert niese.' . I18N::PLURAL . '%2$s har %1$d registrerte nieser.',
            '%2$s has %1$d nephew recorded.' . I18N::PLURAL . '%2$s has %1$d nephews recorded.'  => '%2$s har %1$d registrert nevø.' . I18N::PLURAL . '%2$s har %1$d registrerte nevøer.',
            '%2$s has %1$d nephew or niece of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d nephews or nieces of unknown sex recorded.'  => '%2$s har %1$d registrert nevø eller niese av ukjent kjønn.' . I18N::PLURAL . '%2$s har %1$d registrerte nevøer eller nieser av ukjent kjønn.',
            '%2$s has %1$d nephew and ' . I18N::PLURAL . '%2$s has %1$d nephews and '  => '%2$s har %1$d registrert nevø og ' . I18N::PLURAL . '%2$s har %1$d registrerte nevøer og ',
            '%d niece recorded (%d in total).' . I18N::PLURAL . '%d nieces recorded (%d in total).'   => '%d niese (til sammen %d).' . I18N::PLURAL . '%d nieser (til sammen %d).',
            '%2$s has %1$d niece and ' . I18N::PLURAL . '%2$s has %1$d nieces and '  => '%2$s har %1$d registrert niese og ' . I18N::PLURAL . '%2$s har %1$d nieser og ',
            '%d nephew or niece of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d nephews or nieces of unknown sex recorded (%d in total).'  => '%d nevø eller niese av ukjent kjønn (til sammen %d).' . I18N::PLURAL . '%d nevøer eller nieser av ukjent kjønn (til sammen %d).',
            '%2$s has %1$d nephew, ' . I18N::PLURAL . '%2$s has %1$d nephews, '  => '%2$s har %1$d registrert nevø, ' . I18N::PLURAL . '%2$s har %1$d nevøer, ',
            '%d niece, and ' . I18N::PLURAL . '%d nieces, and '  => '%d niese, og ' . I18N::PLURAL . '%d nieser, og ',

            'Children'  => 'Barn',
            '%s has no children recorded.'  => '%s har ingen registrerte barn.',
            '%s has one daughter recorded.'  => '%s har én registrert datter.',
            '%s has one son recorded.'  => '%s har én registrert sønn.',
            '%s has one child of unknown sex recorded.'  => '%s har ett registrert barn av ukjent kjønn.',
            '%2$s has %1$d daughter recorded.' . I18N::PLURAL . '%2$s has %1$d daughters recorded.'  => '%2$s har %1$d registrert datter.' . I18N::PLURAL . '%2$s har %1$d registrerte døtre.',
            '%2$s has %1$d son recorded.' . I18N::PLURAL . '%2$s has %1$d sons recorded.'  => '%2$s har %1$d registrert sønn.' . I18N::PLURAL . '%2$s har %1$d registrerte sønner.',
            '%2$s has %1$d child of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d children of unknown sex recorded.'  => '%2$s har %1$d registrert barn av ukjent kjønn.' . I18N::PLURAL . '%2$s har %1$d registrerte barn av ukjent kjønn.',
            '%2$s has %1$d son and ' . I18N::PLURAL . '%2$s has %1$d sons and '  => '%2$s har %1$d registrert sønn og ' . I18N::PLURAL . '%2$s har %1$d registrerte sønner og ',
            '%d daughter recorded (%d in total).' . I18N::PLURAL . '%d daughters recorded (%d in total).'   => '%d datter (til sammen %d).' . I18N::PLURAL . '%d døtre (til sammen %d).',
            '%2$s has %1$d daughter and ' . I18N::PLURAL . '%2$s has %1$d daughters and '  => '%2$s har %1$d registrert datter og ' . I18N::PLURAL . '%2$s har %1$d registrerte døtre og ',
            '%d child of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d children of unknown sex recorded (%d in total).'  => '%d barn av ukjent kjønn (til sammen %d).' . I18N::PLURAL . '%d barn av ukjent kjønn (til sammen %d).',
            '%2$s has %1$d son, ' . I18N::PLURAL . '%2$s has %1$d sons, '  => '%2$s har %1$d registrert sønn, ' . I18N::PLURAL . '%2$s har %1$d registrerte sønner, ',
            '%d daughter, and ' . I18N::PLURAL . '%d daughters, and '  => '%d datter, og ' . I18N::PLURAL . '%d døtre, og ',

            'Children-in-law'  => 'Svigerbarn',
            '%s has no children-in-law recorded.'  => '%s har ingen registrerte svigerbarn.',
            '%s has one daughter-in-law recorded.'  => '%s har én registrert svigerdatter.',
            '%s has one son-in-law recorded.'  => '%s har én registrert svigersønn.',
            '%s has one child-in-law of unknown sex recorded.'  => '%s har ett registrert svigerbarn av ukjent kjønn.',
            '%2$s has %1$d daughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d daughters-in-law recorded.'  => '%2$s har %1$d registrert svigerdatter.' . I18N::PLURAL . '%2$s har %1$d registrerte svigerdøtre.',
            '%2$s has %1$d son-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sons-in-law recorded.'  => '%2$s har %1$d registrert svigersønn.' . I18N::PLURAL . '%2$s har %1$d registrerte svigersønner.',
            '%2$s has %1$d child-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d children-in-law recorded.'  => '%2$s har %1$d registrert svigerbarn.' . I18N::PLURAL . '%2$s har %1$d registrerte svigerbarn.',
            '%2$s has %1$d son-in-law and ' . I18N::PLURAL . '%2$s has %1$d sons-in-law and '  => '%2$s har %1$d registrert svigersønn og ' . I18N::PLURAL . '%2$s har %1$d registrerte svigersønner og ',
            '%d daughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d daughters-in-law recorded (%d in total).'   => '%d svigerdatter (til sammen %d).' . I18N::PLURAL . '%d svigerdøtre (til sammen %d).',
            '%2$s has %1$d daughter-in-law and ' . I18N::PLURAL . '%2$s has %1$d daughters-in-law and '  => '%2$s har %1$d registrert svigerdatter og ' . I18N::PLURAL . '%2$s har %1$d registrerte svigerdøtre og ',
            '%d child-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d children-in-law of unknown sex recorded (%d in total).'  => '%d svigerbarn av ukjent kjønn (til sammen %d).' . I18N::PLURAL . '%d svigerbarn av ukjent kjønn (til sammen %d).',
            '%2$s has %1$d son-in-law, ' . I18N::PLURAL . '%2$s has %1$d sons-in-law, '  => '%2$s har %1$d registrert svigersønn, ' . I18N::PLURAL . '%2$s har %1$d registrerte svigersønner, ',
            '%d daughter-in-law, and ' . I18N::PLURAL . '%d daughters-in-law, and '  => '%d svigerdatter, og ' . I18N::PLURAL . '%d svigerdøtre, og ',

            'Grandchildren'  => 'Barnebarn',
            '%s has no grandchildren recorded.'  => '%s har ingen registrerte barnebarn.',
            '%s has one granddaughter recorded.'  => '%s har én registrert sønne-/datterdatter.',
            '%s has one grandson recorded.'  => '%s har én registrert sønne-/dattersønn.',
            '%s has one grandchild of unknown sex recorded.'  => '%s har ett registrert barnebarn av ukjent kjønn.',
            '%2$s has %1$d granddaughter recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters recorded.'  => '%2$s har %1$d registrert sønne-/datterdatter.' . I18N::PLURAL . '%2$s har %1$d registrerte sønne-/datterdøtre.',
            '%2$s has %1$d grandson recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons recorded.'  => '%2$s har %1$d registrert sønne-/dattersønn.' . I18N::PLURAL . '%2$s har %1$d registrerte sønne-/dattersønner.',
            '%2$s has %1$d grandchild of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandchildren of unknown sex recorded.'  => '%2$s har %1$d registrert barnebarn av ukjent kjønn.' . I18N::PLURAL . '%2$s har %1$d registrerte barnebarn av ukjent kjønn.',
            '%2$s has %1$d grandson and ' . I18N::PLURAL . '%2$s has %1$d grandsons and '  => '%2$s har %1$d registrert sønne-/dattersønn og ' . I18N::PLURAL . '%2$s har %1$d registrerte sønne-/dattersønner og ',
            '%d granddaughter recorded (%d in total).' . I18N::PLURAL . '%d granddaughters recorded (%d in total).'   => '%d sønne-/datterdatter (til sammen %d).' . I18N::PLURAL . '%d sønne-/datterdøtre (til sammen %d).',
            '%2$s has %1$d granddaughter and ' . I18N::PLURAL . '%2$s has %1$d granddaughters and '  => '%2$s har %1$d registrert sønne-/datterdatter og ' . I18N::PLURAL . '%2$s har %1$d registrerte sønne-/datterdøtre og ',
            '%d grandchild of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandchildren of unknown sex recorded (%d in total).'  => '%d barnebarn av ukjent kjønn (til sammen %d).' . I18N::PLURAL . '%d barnebarn av ukjent kjønn (til sammen %d).',
            '%2$s has %1$d grandson, ' . I18N::PLURAL . '%2$s has %1$d grandsons, '  => '%2$s har %1$d registrert sønne-/dattersønn, ' . I18N::PLURAL . '%2$s har %1$d registrerte sønne-/dattersønner, ',
            '%d granddaughter, and ' . I18N::PLURAL . '%d granddaughters, and '  => '%d sønne-/datterdatter, og ' . I18N::PLURAL . '%d sønne-/datterdøtre, og ',

            'Grandchildren-in-law'  => 'Svigerbarnebarn',
            '%s has no grandchildren-in-law recorded.'  => '%s har ingen registrerte svigerbarnebarn.',
            '%s has one granddaughter-in-law recorded.'  => '%s har ett registrert svigerbarnebarn.',
            '%s has one grandson-in-law recorded.'  => '%s har ett registrert svigerbarnebarn.',
            '%s has one grandchild-in-law of unknown sex recorded.'  => '%s har ett registrert svigerbarnebarn av ukjent kjønn.',
            '%2$s has %1$d granddaughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters-in-law recorded.'  => '%2$s har %1$d registrert svigerbarnebarn.' . I18N::PLURAL . '%2$s har %1$d registrerte svigerbarnebarn.',
            '%2$s has %1$d grandson-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons-in-law recorded.'  => '%2$s har %1$d registrert svigerbarnebarn.' . I18N::PLURAL . '%2$s har %1$d registrerte svigerbarnebarn.',
            '%2$s has %1$d grandchild-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandchildren-in-law of unknown sex recorded.'  => '%2$s har %1$d registrert svigerbarnebarn av ukjent kjønn.' . I18N::PLURAL . '%2$s har %1$d registrerte svigerbarnebarn av ukjent kjønn.',
            '%2$s has %1$d grandson-in-law and ' . I18N::PLURAL . '%2$s has %1$d grandsons-in-law and '  => '%2$s har %1$d registrert svigerbarnebarn og ' . I18N::PLURAL . '%2$s har %1$d registrerte svigerbarnebarn og ',
            '%d granddaughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d granddaughters-in-law recorded (%d in total).'  => '%d svigerbarnebarn (til sammen %d).' . I18N::PLURAL . '%d svigerbarnebarn (til sammen %d).',
            '%2$s has %1$d granddaughter-in-law and ' . I18N::PLURAL . '%2$s has %1$d granddaughters-in-law and '  => '%2$s har %1$d registrert svigerbarnebarn og ' . I18N::PLURAL . '%2$s har %1$d registrerte svigerbarnebarn og ',
            '%d grandchild-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandchildren-in-law of unknown sex recorded (%d in total).'  => '%d svigerbarnebarn av ukjent kjønn (til sammen %d).' . I18N::PLURAL . '%d svigerbarnebarn av ukjent kjønn (til sammen %d).',
            '%2$s has %1$d grandson-in-law, ' . I18N::PLURAL . '%2$s has %1$d grandsons-in-law, '  => '%2$s har %1$d registrert svigerbarnebarn, ' . I18N::PLURAL . '%2$s har %1$d registrerte svigerbarnebarn, ',
            '%d granddaughter-in-law, and ' . I18N::PLURAL . '%d granddaughters-in-law, and '  => '%d svigerbarnebarn og ' . I18N::PLURAL . '%d svigerbarnebarn og ',
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
            'Family part (generation relative to proband)' => 'Familiedeel (generatie ten opzichte van proband)',
            'Show name of proband as short name or as full name?' => 'Naam van proband weergeven als korte naam of als volledige naam?',
            'Show options to filter the results?' => 'Filteropties weergeven?',
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
            'This allows a user to filter the members of the extended family by gender and if they are alive or dead.'
                => 'Hiermee kan een gebruiker de leden van de uitgebreide familie filteren op geslacht en of ze levend of dood zijn.',
            'Should a summary block be shown?' => 'Moet een samenvattingsblok worden weergeven?',
            'The summary contains information about the extended family in total.' => 'De samenvatting bevat informatie over de totalen van de uitgebreide familie.',
            'Show summary' => 'Samenvatting weergeven',
            'Count the members of the partner chains as members of the extended family?'
                => 'Tellen de leden van de partnerketens mee als leden van de uitgebreide familie?',
            'If you select "no", then the additional members in the partner chains will not be counted to the total number of individuals in the extended family.'
                => 'Als u "nee" kiest, worden de extra leden in de partnerketens niet meegeteld bij het totaalaantal personen in de uitgebreide familie.',
            'And these persons and families will be not selected when a user decides to copy the extended family to the clippings cart.'
                => 'En deze personen en gezinnen zullen niet geselecteerd worden wanneer een gebruiker besluit om de uitgebreide familie naar de stamboomknipsels te kopiëren.',
            'But even in this case, you can copy these persons and families to the clippings cart by using a special menu topic of the custom module "enhanced clippings cart": "add partner chains for an individual".'
                => 'Maar ook in dat geval kunnen deze personen en gezinnen naar de stamboomknipsels worden gekopieerd worden door de volgende optie in het menu van de aangepaste module "uitgebreide stamboomknipsels" te gebruiken: "voeg partnerketens toe voor één persoon".',
            'This is only relevant if you have chosen in the above table, that the partner chains should be shown as a part of the extended family.'
                => 'Dit is alleen relevant als u er in bovenstaande tabel voor heeft gekozen om de partnerketens weer te geven als deel van de uitgebreide familie.',
            'Include them' => 'Opnemen',
            'Show a button "copy to clippings cart"?' => 'Een knop "kopiëren naar stamboomknipsels" weergeven?',
            'This allows a user to copy all members of the extended family to the clippings cart.'
                => 'Hiermee kan een gebruiker alle leden van de uitgebreide familie naar de stamboomknipsels kopiëren.',
            'Show button' => 'Knop weergeven',

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
            'copy all members of the extended family to the clippings cart' => 'kopieer alle leden van de uitgebreide familie naar de stamboomknipsels',
            'copy to clippings cart' => 'kopiëren naar stamboomknipsels',

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
            'died as infant' => 'minder dan 1 jaar oud',
            'linkage challenged' => 'koppeling betwist',
            'linkage disproven' => 'koppeling weerlegd',
            'linkage proven' => 'koppeling bewezen',

            'Marriage' => 'Huwelijk',
            'Ex-marriage' => 'Ex-huwelijk',
            'Partnership' => 'Relatie',
            'Fiancée' => 'Verloving',
            ' with ' => ' met ',

            'Biological grandparents of father' => 'Biologische grootouders van de vader',
            'Biological grandparents of mother' => 'Biologische grootouders van de moeder',
            'Biological grandparents of parent' => 'Biologische grootouders van een ouder',
            'Stepparents of biological parent of father' => 'Stiefouders van een biologische ouder van de vader',
            'Stepparents of biological parent of mother' => 'Stiefouders van een biologische ouder van de moeder',
            'Stepparents of biological grandparent' => 'Stiefouders van een biologische grootouder',
            'Parents of stepparent of father' => 'Ouders van een stiefouder van de vader',
            'Parents of stepparent of mother' => 'Ouders van een stiefouder van de moeder',
            'Parents of stepparent of parent' => 'Ouders van een stiefouder van een ouder',
            'Grandparents of stepparent' => 'Grootouders van een stiefouder',
            'Biological great-grandparents' => 'Biologische overgrootouders',
            'Biological parents of father' => 'Biologische ouders van de vader',
            'Biological parents of mother' => 'Biologische ouders van de moeder',
            'Biological parents of parent' => 'Biologische ouders van een ouder',
            'Stepparents of father' => 'Stiefouders van de vader',
            'Stepparents of mother' => 'Stiefouders van de moeder',
            'Stepparents of parent' => 'Stiefouders van een ouder',
            'Parents of stepparent' => 'Ouders van een stiefouder',
            'Biological grandparents' => 'Biologische grootouders',
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
            'Partners of biological grandchildren' => 'Partners van biologische kleinkinderen',
            'Partners of stepchildren of children' => 'Partners van stiefkinderen van kinderen',
            'Partners of children of stepchildren' => 'Partners van kinderen van stiefkinderen',
            'Partners of stepchildren of stepchildren' => 'Partners van stiefkinderen van stiefkinderen',

            'He' => 'hem',
            'She' => 'haar',
            'He/she' => 'hem/haar',
            'Mr.' => 'de heer',
            'Mrs.' => 'mevrouw',
            'No family available' => 'Geen familie gevonden',
            'Summary for the shown extended family' => 'Samenvatting voor de getoonde uitgebreide familie',
            'The extended family has only %1$s as a member.' . I18N::PLURAL . 'The extended family of %1$s has %2$d members (including %1$s).'
                => 'De uitgebreide familie heeft alleen %1$s als lid.' . I18N::PLURAL . 'De uitgebreide familie van %1$s heeft %2$d leden',
            '(additional members of the partner chains are not counted)'
                => '(extra leden van de partnerketens worden niet meegeteld).',
            'Some of them are member in more than one part of the extended family.'
                => 'Sommigen van hen zijn lid van meer dan één deel van de uitgebreide familie.',
            '%s has no %s recorded.' => 'Voor %s zijn geen %s geregistreerd.',
            '%s has no %s, and no %s recorded.' => 'Voor %s zijn geen %s en geen %s geregistreerd.',

            'Father\'s family (%d)' => 'Familie van de vader (%d)',
            'Mother\'s family (%d)' => 'Familie van de moeder (%d)',
            'Father\'s and Mother\'s family (%d)' => 'Familie van de vader en de moeder (%d)',
            'Grandparents %1$s (%2$s) of stepfather %3$s' => 'Grootouders %1$s (%2$s) van de stiefvader %3$s',
            'Grandparents %1$s (%2$s) of stepmother %3$s' => 'Grootouders %1$s (%2$s) van de stiefmoeder %3$s',
            'Grandparents %1$s (%2$s) of stepparent %3$s' => 'Grootouders %1$s (%2$s) van de stiefouder %3$s',
            'Stepparents %1$s (%2$s) of %3$s' => 'Stiefouders %1$s (%2$s) van %3$s',
            'Parents %1$s (%2$s) of stepfather %3$s' => 'Ouders %1$s (%2$s) van de stiefvader %3$s',
            'Parents %1$s (%2$s) of stepmother %3$s' => 'Ouders %1$s (%2$s) van de stiefmoeder %3$s',
            'Parents %1$s (%2$s) of stepparent %3$s' => 'Ouders %1$s (%2$s) van de stiefouder %3$s',
            'Parents %1$s of %2$s' => 'Ouders %1$s van %2$s',
            'Parents %1$s (%2$s) of %3$s' => 'Ouders %1$s (%2$s) van %3$s',
            'Partners of %s' => 'Partners van %s',
            'Brother %1$s of partner %2$s' => 'Broer %1$s van partner %2$s',
            'Sister %1$s of partner %2$s' => 'Zus %1$s van partner %2$s',
            'Sibling %1$s of partner %2$s' => 'Broer/zus %1$s van partner %2$s',

            'Great-grandparents' => 'Overgrootouders',
            '%s has no great-grandparents recorded.' => 'Voor %s zijn geen overgrootouders geregistreerd.',
            '%s has one great-grandmother recorded.' => 'Voor %s is een overgrootmoeder geregistreerd.',
            '%s has one great-grandfather recorded.' => 'Voor %s is een overgrootvader geregistreerd.',
            '%s has one great-grandparent of unknown sex recorded.' => 'Voor %s is een overgrootouder van onbekend geslacht geregistreerd.',
            '%2$s has %1$d great-grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandmothers recorded.'
                => 'Voor %2$s is %1$d overgrootmoeder geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d overgrootmoeders geregistreerd',
            '%2$s has %1$d great-grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandfathers recorded.'
                => 'Voor %2$s is %1$d overgrootvader geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d overgrootvaders geregistreerd.',
            '%2$s has %1$d great-grandparent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandparents of unknown sex recorded.'
                => 'Voor %2$s is %1$d overgrootouder van onbekend geslacht geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d overgrootouders van onbekend geslacht geregistreerd.',
            '%2$s has %1$d great-grandfather and ' . I18N::PLURAL . '%2$s has %1$d great-grandfathers and '
                => 'Voor %2$s zijn %1$d overgrootvader en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d overgrootvaders en ',
            '%d great-grandmother recorded (%d in total).' . I18N::PLURAL . '%d great-grandmothers recorded (%d in total).'
                => '%d overgrootmoeder geregistreerd (%d in totaal).' . I18N::PLURAL . '%d overgrootmoeders geregistreerd (%d in totaal).',
            '%2$s has %1$d great-grandmother and ' . I18N::PLURAL . '%2$s has %1$d great-grandmothers and '
                => 'Voor %2$s zijn %1$d overgrootmoeder en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d overgrootmoeders en ',
            '%d great-grandparent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d great-grandparents of unknown sex recorded (%d in total).'
                => '%d overgrootouder van onbekend geslacht geregistreerd (%d in totaal).' . I18N::PLURAL . '%d overgrootouders van onbekend geslacht geregistreerd (%d in totaal).',
            '%2$s has %1$d great-grandfather, ' . I18N::PLURAL . '%2$s has %1$d great-grandfathers, '
                => 'Voor %2$s zijn %1$d overgrootvader, ' . I18N::PLURAL . 'Voor %2$s zijn %1$d overgrootvaders, ',
            '%d great-grandmother, and ' . I18N::PLURAL . '%d great-grandmothers, and '
                => '%d overgrootmoeder en ' . I18N::PLURAL . '%d overgrootmoeder en ',

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
            '%2$s has %1$d aunt by marriage and ' . I18N::PLURAL . '%2$s has %1$d aunts by marriage and '
                => 'Voor %2$s zijn %1$d aangetrouwde tante en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d aangetrouwde tantes en ',
            '%d uncle or aunt by marriage of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d uncles or aunts by marriage of unknown sex recorded (%d in total).'
                => '%d aangetrouwde oom/tante van onbekend geslacht geregistreerd (%d in totaal).' . I18N::PLURAL . '%d aangetrouwde ooms/tantes van onbekend geslacht geregistreerd (%d in totaal).',
            '%2$s has %1$d uncle by marriage, ' . I18N::PLURAL . '%2$s has %1$d uncles by marriage, '
                => 'Voor %2$s zijn %1$d aangetrouwde oom, ' . I18N::PLURAL . 'Voor %2$s zijn %1$d aangetrouwde ooms, ',
            '%d aunt by marriage, and ' . I18N::PLURAL . '%d aunts by marriage, and '
                => '%d aangetrouwde tante en ' . I18N::PLURAL . '%d aangetrouwde tantes en ',

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
            '%2$s has %1$d mother and ' . I18N::PLURAL . '%2$s has %1$d mothers and '
                => 'Voor %2$s zijn %1$d moeder en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d moeders en ',
            '%d parent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d parents of unknown sex recorded (%d in total).'
                => '%d ouder van onbekend geslacht geregistreerd (%d in totaal).' . I18N::PLURAL . '%d ouders van onbekend geslacht geregistreerd (%d in totaal).',
            '%2$s has %1$d father, ' . I18N::PLURAL . '%2$s has %1$d fathers, '
                => 'Voor %2$s zijn %1$d vader, ' . I18N::PLURAL . 'Voor %2$s zijn %1$d vaders, ',
            '%d mother, and ' . I18N::PLURAL . '%d mothers, and '
                => '%d moeder en ' . I18N::PLURAL . '%d moeders en ',

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
            '%2$s has %1$d mother-in-law and ' . I18N::PLURAL . '%2$s has %1$d mothers-in-law and '
                => 'Voor %2$s zijn %1$d schoonmoeder en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoonmoeders en ',
            '%d parent-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d parents-in-law of unknown sex recorded (%d in total).'
                => '%d schoonouder van onbekend geslacht geregistreerd (%d in totaal).' . I18N::PLURAL . '%d schoonouders van onbekend geslacht geregistreerd (%d in totaal).',
            '%2$s has %1$d father-in-law, ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law, '
                => 'Voor %2$s zijn %1$d schoonvader, ' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoonvaders, ',
            '%d mother-in-law, and ' . I18N::PLURAL . '%d mothers-in-law, and '
                => '%d schoonmoeder en ' . I18N::PLURAL . '%d schoonmoeders en ',

            'Co-parents-in-law' => 'Ouders van schoonkinderen',
            '%s has no co-parents-in-law recorded.' => 'Voor %s zijn geen ouders van schoonkinderen geregistreerd.',
            '%s has one co-mother-in-law recorded.' => 'Voor %s is een moeder van schoonkinderen geregistreerd.',
            '%s has one co-father-in-law recorded.' => 'Voor %s is een vader van schoonkinderen geregistreerd.',
            '%s has one co-parent-in-law of unknown sex recorded.' => 'Voor %s is een ouder (van onbekend geslacht) van schoonkinderen geregistreerd.',
            '%2$s has %1$d co-mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law recorded.'
                => 'Voor %2$s is %1$d moeder van schoonkinderen geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d moeders van schoonkinderen geregistreerd.',
            '%2$s has %1$d co-father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law recorded.'
                => 'Voor %2$s is %1$d vader van schoonkinderen geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d vaders van schoonkinderen geregistreerd.',
            '%2$s has %1$d co-parent-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d co-parents-in-law of unknown sex recorded.'
                => 'Voor %2$s is %1$d ouder (van onbekend geslacht) van schoonkinderen geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d ouders (van onbekend geslacht) van schoonkinderen geregistreerd.',
            '%2$s has %1$d co-father-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law and '
                => 'Voor %2$s zijn %1$d vader en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d vaders en ',
            '%d co-mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-mothers-in-law recorded (%d in total).'
                => '%d moeder van schoonkinderen geregistreerd (%d in totaal).' . I18N::PLURAL . '%d moeders van schoonkinderen geregistreerd (%d in totaal).',
            '%2$s has %1$d co-mother-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law and '
                => 'Voor %2$s zijn %1$d moeder en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d moeders en ',
            '%d co-parent-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d co-parents-in-law of unknown sex recorded (%d in total).'
                => '%d ouder (van onbekend geslacht) van schoonkinderen geregistreerd (%d in totaal).' . I18N::PLURAL . '%d ouders (van onbekend geslacht) van schoonkinderen geregistreerd (%d in totaal).',
            '%2$s has %1$d co-father-in-law, ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law, '
                => 'Voor %2$s zijn %1$d vader, ' . I18N::PLURAL . 'Voor %2$s zijn %1$d vaders, ',
            '%d co-mother-in-law, and ' . I18N::PLURAL . '%d co-mothers-in-law, and '
                => '%d moeder en ' . I18N::PLURAL . '%d moeders en ',

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
            '%1$d female partner in this partner chain recorded (%2$d in total, including %3$s).' . I18N::PLURAL . '%1$d female partners in this partner chain recorded (%2$d in total, including %3$s).'
                => '%1$d vrouwelijke partner in deze partnerketen geregistreerd (%2$d in totaal, inclusief %3$s).' . I18N::PLURAL . '%1$d vrouwelijke partners in deze partnerketen geregistreerd (%2$d in totaal, inclusief %3$s).',
            '%d female partner and ' . I18N::PLURAL . '%d female partners and '
                => '%d vrouwelijke partner en ' . I18N::PLURAL . '%d vrouwelijke partners en ',
            '%1$d partner of unknown sex in this partner chain recorded (%2$d in total, including %3$s).' . I18N::PLURAL . '%1$d partners of unknown sex in this partner chain recorded (%2$d in total, including %3$s).'
                => '%1$d partner van onbekend geslacht in deze partnerketen geregistreerd (%2$d in totaal, inclusief %3$s).' . I18N::PLURAL . '%1$d partners van onbekend geslacht in deze partnerketen geregistreerd (%2$d in totaal, inclusief %3$s).',
            '%2$s has %1$d female partner and ' . I18N::PLURAL . '%2$s has %1$d female partners and '
                => 'Voor %2$s zijn %1$d vrouwelijke partner en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d vrouwelijke partners en ',
            '%2$s has %1$d male partner, ' . I18N::PLURAL . '%2$s has %1$d male partners, '
                => 'Voor %2$s zijn %1$d mannelijke partner, ' . I18N::PLURAL . 'Voor %2$s zijn %1$d mannelijke partners, ',
            '%d female partner, and ' . I18N::PLURAL . '%d female partners, and '
                => '%d vrouwelijke partner en ' . I18N::PLURAL . '%d vrouwelijke partners en ',
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
                => 'Voor %2$s is %1$d broer/zus/partner (van onbekend geslacht) van een zwager/schoonzus geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d broers/zussen/partners (van onbekend geslacht) van zwagers/schoonzussen geregistreerd.',
            '%2$s has %1$d co-brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law and '
                => 'Voor %2$s zijn %1$d broer/mannelijke partner en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d broers/mannelijke partners en ',
            '%d co-sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-sisters-in-law recorded (%d in total).'
                => '%d zus/vrouwelijke partner van zwagers/schoonzussen geregistreerd (%d in totaal).' . I18N::PLURAL . '%d zussen/vrouwelijke partners van zwagers/schoonzussen geregistreerd (%d in totaal).',
            '%2$s has %1$d co-sister-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-sisters-in-law and '
                => 'Voor %2$s zijn %1$d zus/vrouwelijke partner en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d zussen/vrouwelijke partners en ',
            '%d co-sibling-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d co-siblings-in-law of unknown sex recorded (%d in total).'
                => '%d broer/zus/partner (van onbekend geslacht) van zwagers/schoonzussen geregistreerd (%d in totaal).' . I18N::PLURAL . '%d broers/zussen/partners (van onbekend geslacht) van zwagers/schoonzussen geregistreerd (%d in totaal).',
            '%2$s has %1$d co-brother-in-law, ' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law, '
                => 'Voor %2$s zijn %1$d broer/mannelijke partner, ' . I18N::PLURAL . 'Voor %2$s zijn %1$d broers/mannelijke partners, ',
            '%d co-sister-in-law, and ' . I18N::PLURAL . '%d co-sisters-in-law, and '
                => '%d zus/vrouwelijke partner en ' . I18N::PLURAL . '%d zussen/vrouwelijke partners en ',

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

            'Grandchildren-in-law' => 'Schoonkleinkinderen',
            '%s has no grandchildren-in-law recorded.' => 'Voor %s zijn geen schoonkleinkinderen geregistreerd.',
            '%s has one granddaughter-in-law recorded.' => 'Voor %s is een schoonkleindochter geregistreerd.',
            '%s has one grandson-in-law recorded.' => 'Voor %s is een schoonkleinzoon geregistreerd.',
            '%s has one grandchild-in-law of unknown sex recorded.' => 'Voor %s is een schoonkleinkind van onbekend geslacht geregistreerd.',
            '%2$s has %1$d granddaughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters-in-law recorded.'
            => 'Voor %2$s is %1$d schoonkleindochter geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoonkleindochters geregistreerd.',
            '%2$s has %1$d grandson-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons-in-law recorded.'
            => 'Voor %2$s is %1$d schoonkleinzoon geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoonkleinzonen geregistreerd.',
            '%2$s has %1$d grandchild-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandchildren-in-law of unknown sex recorded.'
            => 'Voor %2$s is %1$d schoonkleinkind van onbekend geslacht geregistreerd.' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoonkleinkinderen van onbekend geslacht geregistreerd.',
            '%2$s has %1$d grandson-in-law and ' . I18N::PLURAL . '%2$s has %1$d grandsons-in-law and '
            => 'Voor %2$s zijn %1$d schoonkleinzoon en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoonkleinzonen en ',
            '%d granddaughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d granddaughters-in-law recorded (%d in total).'
            => '%d schoonkleindochter geregistreerd (%d in totaal).' . I18N::PLURAL . '%d schoonkleindochters geregistreerd (%d in totaal).',
            '%2$s has %1$d granddaughter-in-law and ' . I18N::PLURAL . '%2$s has %1$d granddaughters-in-law and '
            => 'Voor %2$s zijn %1$d schoonkleindochter en ' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoonkleindochters en ',
            '%d grandchild-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandchildren-in-law of unknown sex recorded (%d in total).'
            => '%d schoonkleinkind van onbekend geslacht geregistreerd (%d in totaal).' . I18N::PLURAL . '%d schoonkleinkinderen van onbekend geslacht geregistreerd (%d in totaal).',
            '%2$s has %1$d grandson-in-law, ' . I18N::PLURAL . '%2$s has %1$d grandsons-in-law, '
            => 'Voor %2$s zijn %1$d schoonkleinzoon, ' . I18N::PLURAL . 'Voor %2$s zijn %1$d schoonkleinzonen, ',
            '%d granddaughter-in-law, and ' . I18N::PLURAL . '%d granddaughters-in-law, and '
            => '%d schoonkleindochter en ' . I18N::PLURAL . '%d schoonkleindochters en ',
        ];
    }

    /**
     * @return array
     */
    public static function russianTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => 'Родственники',
            'A tab showing the extended family of an individual.' => 'Вкладка с родственниками человека',
            'In which sequence should the parts of the extended family be shown?' => 'В какой последовательности будут показаны блоки родственников?',
            'Family part (generation relative to proband)' => 'Родственники (поколение относительно указанного)',
            'Show name of proband as short name or as full name?' => 'Показать имя исходного человека кратко или полностью?',
            'Show options to filter the results (gender and alive/dead)?' => 'Показать параметры фильтрации результатов (по полу и жив/мёртв)?',
            'Show filter options' => 'Показать параметры фильтрации',
            'How should empty parts of extended family be presented?' => 'Как отображать пустые блоки родственников?',
            'Show empty block' => 'Показать пустые блоки',
            'yes, always at standard location' => 'да, всегда в обычном месте',
            'no, but collect messages about empty blocks at the end' => 'нет, но собирать сообщения о пустых блоках в конце',
            'never' => 'никогда',
            'The short name is based on the probands Rufname or nickname. If these are not available, the first of the given names is used, if one is given. Otherwise the last name is used.' => 'Краткое имя основано на имени или прозвище исходного человека. Если они недоступны, используется первое указанное. В противном случае используется фамилия.',
            'Show short name' => 'Показать короткое имя',
            'Show labels in special situations?' => 'Показать ярлыки в особых ситуациях?',
            'Labels (or stickers) are used for example for adopted persons or foster children.' => 'Ярлыки (или метки) используются, например, для усыновлённых или приёмных детей.',
            'Show labels' => 'Показать ярлыки',
            'Use the compact design?' => 'Использовать компактный дизайн?',
            'Use the compact design' => 'Использовать компактный дизайн',
            'The compact design only shows the name and life span for each person. The enriched design also shows a photo (if this is activated for this tree) as well as birth and death information.' => 'Компактный дизайн показывает только имя и продолжительность жизни каждого человека. В улучшенном дизайне также отображается фотография (если она активирована для этого дерева), а также информация о рождении и смерти.',
            'Show parameters of extended family part?' => 'Показать параметры по части родственников?',
            'Display of additional information for each part of the extended family, such as the generation shift and the coefficient of relationship, which is a measure of the degree of consanguinity.' => 'Отображение дополнительной информации для каждой части родственников, такой как сдвиг поколения и коэффициент соотношения степени родства.',
            'Show parameters' => 'Показать параметры',
            'This allows a user to filter the members of the extended family by gender and if they are alive or dead.'
                => 'Это позволяет пользователю фильтровать родственников по полу, живы или мертвы.',
            'Should a summary block be shown?' => 'Должен ли быть показан блок сводки?',
            'The summary contains information about the extended family in total.' => 'В сводке содержится общая информация о родственниках.',
            'Show summary' => 'Показать сводку',
            'Count the members of the partner chains as members of the extended family?'
                => 'Считать ли супругов родственниками?',
            'If you select "no", then the additional members in the partner chains will not be counted to the total number of individuals in the extended family.'
                => 'Если вы выберете "нет", то партнеры не будут засчитываться в общее число родственников.',
            'And these persons and families will be not selected when a user decides to copy the extended family to the clippings cart.'
                => 'И эти люди и семьи не будут выбраны, когда пользователь решит скопировать расширенное семейство в корзину вырезок.',
            'But even in this case, you can copy these persons and families to the clippings cart by using a special menu topic of the custom module "enhanced clippings cart": "add partner chains for an individual".'
                => 'Но даже в этом случае вы можете скопировать этих людей и семьи в корзину вырезок, используя специальный раздел меню расширенного модуля корзин вырезок: "добавить цепочки партнеров для отдельного человека".',
            'This is only relevant if you have chosen, that the partner chains should be shown as a part of the extended family.'
                => 'Это важно только в том случае, если выбрано, что партнеры должны отображаться как родственники.',
            'Include them' => 'Включая их',
            'Show a button "copy to clippings cart"?' => 'Показать кнопку "добавить в корзину вырезок"?',
            'This allows a user to copy all members of the extended family to the clippings cart.'
                => 'Это позволяет пользователю копировать всех родственников в корзину вырезок.',
            'Show button' => 'Показать кнопку',

            'generation +%s' => '+%s поколение',
            'same generation' => 'То же поколение',
            'generation %s' => '%s поколение',
            'relationship coefficient: %.1f' => 'Коэффициент родства: %.1f',
            'no blood relationship' => 'Нет кровного родства',

            'don\'t use this filter' => 'не использовать этот фильтр',
            'show only male persons' => 'показать только мужчин',
            'show only female persons' => 'показать только женщин',
            'show only persons of unknown gender' => 'показать только с неизвестным полом',
            'show only alive persons' => 'показать только живых',
            'show only dead persons' => 'показать только умерших',
            'alive' => 'живые',
            'dead' => 'умершие',
            'a dead person' => 'умерший человек',
            'a living person' => 'живой человек',
            'not a male person' => 'не мужчина',
            'not a female person' => 'не женщина',
            'not a person of unknown gender' => 'не с неизвестным полом',

            'twin' => 'двойняшка',
            'triplet' => 'тройняшка',
            'quadruplet' => 'четверняшка',
            'quintuplet' => 'пятерняшка',
            'sextuplet' => 'шестерняшка',
            'septuplet' => 'семерняшка',
            'octuplet' => 'восьмерняшка',
            'nonuplet' => 'девятерняшка',
            'decuplet' => 'десятерняшка',
            'stillborn' => 'мёртворожденный',
            'died as infant' => 'умерший в младенчестве',
            'linkage challenged' => 'связь оспоренная',
            'linkage disproven' => 'связь опровергнутая',
            'linkage proven' => 'связь подтверждённая',

            'Marriage' => 'В браке',
            'Ex-marriage' => 'В разводе',
            'Partnership' => 'По линии',
            'Fianc?e' => 'Помолвка',
            ' with ' => ' с ',

            'Biological grandparents of father' => 'Прадедушки и прабабушки по отцу',
            'Biological grandparents of mother' => 'Прадедушки и прабабушки по матери',
            'Biological grandparents of parent' => 'Прадедушки и прабабушки',
            'Stepparents of biological parent of father' => 'Приёмные родители родителя отца',
            'Stepparents of biological parent of mother' => 'Приёмные родители родителя матери',
            'Stepparents of biological grandparent' => 'Приёмные родители дедушки или бабушки',
            'Parents of stepparent of father' => 'Родители приёмного родителя отца',
            'Parents of stepparent of mother' => 'Родители приёмного родителя матери',
            'Parents of stepparent of parent' => 'Родители приёмного родителя отца или матери',
            'Grandparents of stepparent' => 'Дедушки и бабаушки приёмных родителей',
            'Biological great-grandparents' => 'Прадедушки и прабабушки',
            'Biological parents of father' => 'Дедушка и бабушка по отцу',
            'Biological parents of mother' => 'Дедушка и бабушка по матери',
            'Biological parents of parent' => 'Дедушка и бабушка по родителю',
            'Stepparents of father' => 'Приёмные родители отца',
            'Stepparents of mother' => 'Приёмные родители матери',
            'Stepparents of parent' => 'Приёмные родители отца или матери',
            'Parents of stepparent' => 'Родители приёмного отца или матери',
            'Biological grandparents' => 'Дедушки и бабушки',
            'Siblings of father' => 'Дяди и тёти по отцу',
            'Siblings of mother' => 'Дяди и тёти по матери',
            'Full siblings of biological parents' => 'Кровные братья и сестры',
            'Siblings-in-law of father' => 'Супруги дядь и тёть по отцу',
            'Siblings-in-law of mother' => 'Супруги дядь и тёть по матери',
            'Biological parents' => 'Родители',
            'Stepparents' => 'Приёмные родители',
            'Parents-in-law of biological children' => 'Сваты через родных детей',
            'Parents-in-law of stepchildren' => 'Сваты через приёмных детей',
            'Full siblings' => 'Родные братья и сёстры',
            'Half siblings' => 'Сводные братья и сёстры',
            'Stepsiblings' => 'Приёмные братья и сёстры',
            'Children of full siblings of father' => 'Дети родных братьев и сестёр отца',
            'Children of full siblings of mother' => 'Дети родных братьев и сестёр матери',
            'Children of full siblings of parent' => 'Дети родных братьев и сестёр родителей',
            'Children of half siblings of father' => 'Дети сводных братьев и сестёр отца',
            'Children of half siblings of mother' => 'Дети сводных братьев и сестёр матери',
            'Children of half siblings of parent' => 'Дети сводных братьев и сестёр родителей',
            'Siblings of partners' => 'Братья и сёстры супругов',
            'Partners of siblings' => 'Супруги братьев и сестёр',
            'Siblings of siblings-in-law' => 'Братья и сёстры братьев и сестёр',
            'Partners of siblings-in-law' => 'Супруги братьев и сестёр супруга(и)',
            'Children of full siblings of biological parents' => 'Дети родных братьев и сестёр родителей',
            'Children of siblings' => 'Дети братьев и сестёр',
            'Children of full siblings' => 'Дети родных братьев и сестёр',
            'Siblings\' stepchildren' => 'Приёмные дети братьев и сестёр',
            'Children of siblings of partners' => 'Дети братьев и сестёр супруга(и)',
            'Biological children' => 'Дети',
            'Stepchildren' => 'Приёмные дети',
            'Stepchild' => 'Приёмный ребёнок',
            'Stepson' => 'Пасынок',
            'Stepdaughter' => 'Падчерица',
            'Partners of biological children' => 'Супруги родных детей',
            'Partners of stepchildren' => 'Супруги приёмных детей',
            'Biological grandchildren' => 'Родные внуки и внучки',
            'Stepchildren of children' => 'Приёмные внуки и внучки от родных детей',
            'Children of stepchildren' => 'Дети от приёмных детей',
            'Stepchildren of stepchildren' => 'Приёмные внуки и внучки от приёмных детей',
            'Partners of biological grandchildren' => 'Супруги внуков и внучек',
            'Partners of stepchildren of children' => 'Супруги приёмных детей детей',
            'Partners of children of stepchildren' => 'Супруги детей приёмных детей',
            'Partners of stepchildren of stepchildren' => 'Супруги приёмных детей приёмных детей',

            'He' => 'Ему',
            'She' => 'Ей',
            'He/she' => 'Ему/ей',
            'Mr.' => 'Г-н',
            'Mrs.' => 'Г-жа',
            'No family available' => 'Родственников не найдено',
            'Summary for the shown extended family' => 'Сводка по родственникам',
            'The extended family of %1$s has one member.' . I18N::PLURAL . 'The extended family of %1$s has %2$d members.'
                => 'Родственников у %1$s имеется только один.' . I18N::PLURAL . '%1$s имеет %2$d родственников.' . I18N::PLURAL . '%1$s имеет %2$d родственников.',
            '(additional members of the partner chains are not counted)' => '(дополнительные супружеские цепочки не учитываются)',
            'Some of them are member in more than one part of the extended family.' => 'Некоторые из них связаны несколькими родственными связями.',
            '%s has no %s recorded.' => '%s не имеет %s записей.',
            '%s has no %s, and no %s recorded.' => '%s не имеет %s и %s записей.',

            'Father\'s family (%d)' => 'Родственников по отцу (%d)',
            'Mother\'s family (%d)' => 'Родственников по матери (%d)',
            'Father\'s and Mother\'s family (%d)' => 'Родственников по отцу и по матери (%d)',
            'Grandparents %1$s (%2$s) of stepfather %3$s' => 'Дедушки и бабушки %1$s (%2$s) отчима %3$s',
            'Grandparents %1$s (%2$s) of stepmother %3$s' => 'Дедушки и бабушки %1$s (%2$s) мачехи %3$s',
            'Grandparents %1$s (%2$s) of stepparent %3$s' => 'Дедушки и бабушки %1$s (%2$s) приёмного родителя %3$s',
            'Stepparents %1$s (%2$s) of %3$s' => 'Приёмные родители %1$s (%2$s) у %3$s',
            'Parents %1$s (%2$s) of stepfather %3$s' => 'Родители %1$s (%2$s) у отчима %3$s',
            'Parents %1$s (%2$s) of stepmother %3$s' => 'Родители %1$s (%2$s) у мачехи %3$s',
            'Parents %1$s (%2$s) of stepparent %3$s' => 'Родители %1$s (%2$s) у приёмного родителя %3$s',
            'Parents %1$s of %2$s' => 'Родители %1$s у %2$s',
            'Parents %1$s (%2$s) of %3$s' => 'Родители %1$s (%2$s) у %3$s',
            'Partners of %s' => 'Супруги %s',
            'Brother %1$s of partner %2$s' => 'Брат %1$s супруга(и) %2$s',
            'Sister %1$s of partner %2$s' => 'Сестра %1$s супруга(и) %2$s',
            'Sibling %1$s of partner %2$s' => 'Сестра или брат %1$s супруга(и) %2$s',

            'Great-grandparents' => 'Прадедушки и прабабушки',
            '%s has no great-grandparents recorded.' => '%s не имеет записанных прадедушек или прабабушек.',
            '%s has one great-grandmother recorded.' => '%s имеет одну записанную прабабушку.',
            '%s has one great-grandfather recorded.' => '%s имеет одного записанного прадедушку.',
            '%s has one great-grandparent of unknown sex recorded.' => '%s имеет одного записанного прадедушку или прабабушку.',
            '%2$s has %1$d great-grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandmothers recorded.'
                => '%2$s имеет %1$d прабабушку записанной.' . I18N::PLURAL . '%2$s имеет %1$d прабабушек записанными.' . I18N::PLURAL . '%2$s имеет %1$d прабабушек записанными.',
            '%2$s has %1$d great-grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandfathers recorded.'
                => '%2$s имеет %1$d прадедушку записанным.' . I18N::PLURAL . '%2$s имеет %1$d прадедушек записанными.' . I18N::PLURAL . '%2$s имеет %1$d прадедушек записанными.',
            '%2$s has %1$d great-grandparent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandparents of unknown sex recorded.'
                => '%2$s имеет %1$d прадедушку или прабабушку записанного.' . I18N::PLURAL . '%2$s имеет %1$d прадедушек или прабабушек записанными.' . I18N::PLURAL . '%2$s имеет %1$d прадедушек или прабабушек записанными.',
            '%2$s has %1$d great-grandfather and ' . I18N::PLURAL . '%2$s has %1$d great-grandfathers and '
                => '%2$s имеет %1$d прадедушку и ' . I18N::PLURAL . '%2$s имеет %1$d прадедушек и ' . I18N::PLURAL . '%2$s имеет %1$d прадедушек и ',
            '%d great-grandmother recorded (%d in total).' . I18N::PLURAL . '%d great-grandmothers recorded (%d in total).'
                => '%d прабабушку записанными (всего %d).' . I18N::PLURAL . '%d прабабушек записанными (всего %d).' . I18N::PLURAL . '%d прабабушек записанными (всего %d).',
            '%2$s has %1$d great-grandmother and ' . I18N::PLURAL . '%2$s has %1$d great-grandmothers and '
                => '%2$s имеет %1$d прабабушку и ' . I18N::PLURAL . '%2$s имеет %1$d прабабушек и ' . I18N::PLURAL . '%2$s имеет %1$d прабабушек и ',
            '%d great-grandparent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d great-grandparents of unknown sex recorded (%d in total).'
                => '%d прадедушку или прабабушку записанными (всего %d).' . I18N::PLURAL . '%d прадедушек или прабабушек записанными (всего %d).' . I18N::PLURAL . '%d прадедушек или прабабушек записанными (всего %d).',
            '%2$s has %1$d great-grandfather, ' . I18N::PLURAL . '%2$s has %1$d great-grandfathers, '
                => '%2$s имеет %1$d прадедушку, ' . I18N::PLURAL . '%2$s имеет %1$d прадедушек, ' . I18N::PLURAL . '%2$s имеет %1$d прадедушек, ',
            '%d great-grandmother, and ' . I18N::PLURAL . '%d great-grandmothers, and '
                => '%d прабабушку, и ' . I18N::PLURAL . '%d прабабушек, и ' . I18N::PLURAL . '%d прабабушек, и ',

            'Grandparents' => 'Дедушки и бабушки',
            '%s has no grandparents recorded.' => '%s не имеет записанных дедушек или бабушек.',
            '%s has one grandmother recorded.' => '%s имеет одну записанную бабушку.',
            '%s has one grandfather recorded.' => '%s имеет одного записанного дедушку.',
            '%s has one grandparent of unknown sex recorded.' => '%s имеет одного записанного дедушку или бабушку.',
            '%2$s has %1$d grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d grandmothers recorded.'
                => '%2$s имеет %1$d бабушку записанной.' . I18N::PLURAL . '%2$s имеет %1$d бабушек записанными.' . I18N::PLURAL . '%2$s имеет %1$d бабушек записанными.',
            '%2$s has %1$d grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d grandfathers recorded.'
                => '%2$s имеет %1$d дедушку записанным.' . I18N::PLURAL . '%2$s имеет %1$d дедушек записанными.' . I18N::PLURAL . '%2$s имеет %1$d дедушек записанными.',
            '%2$s has %1$d grandparent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandparents of unknown sex recorded.'
                => '%2$s имеет %1$d дедушку или бабушку записанного.' . I18N::PLURAL . '%2$s имеет %1$d дедушек или бабушек записанными.' . I18N::PLURAL . '%2$s имеет %1$d дедушек или бабушек записанными.',
            '%2$s has %1$d grandfather and ' . I18N::PLURAL . '%2$s has %1$d grandfathers and '
                => '%2$s имеет %1$d дедушку и ' . I18N::PLURAL . '%2$s имеет %1$d дедушек и ' . I18N::PLURAL . '%2$s имеет %1$d дедушек и ',
            '%d grandmother recorded (%d in total).' . I18N::PLURAL . '%d grandmothers recorded (%d in total).'
                => '%d бабушку записанными (всего %d).' . I18N::PLURAL . '%d бабушек записанными (всего %d).' . I18N::PLURAL . '%d бабушек записанными (всего %d).',
            '%2$s has %1$d grandmother and ' . I18N::PLURAL . '%2$s has %1$d grandmothers and '
                => '%2$s имеет %1$d бабушку и ' . I18N::PLURAL . '%2$s имеет %1$d бабушек и ' . I18N::PLURAL . '%2$s имеет %1$d бабушек и ',
            '%d grandparent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandparents of unknown sex recorded (%d in total).'
                => '%d дедушку или бабушку записанными (всего %d).' . I18N::PLURAL . '%d дедушек или бабушек записанными (всего %d).' . I18N::PLURAL . '%d дедушек или бабушек записанными (всего %d).',
            '%2$s has %1$d grandfather, ' . I18N::PLURAL . '%2$s has %1$d grandfathers, '
                => '%2$s имеет %1$d дедушку, ' . I18N::PLURAL . '%2$s имеет %1$d дедушек, ' . I18N::PLURAL . '%2$s имеет %1$d дедушек, ',
            '%d grandmother, and ' . I18N::PLURAL . '%d grandmothers, and '
                => '%d бабушку, и ' . I18N::PLURAL . '%d бабушек, и ' . I18N::PLURAL . '%d бабушек, и ',

            'Uncles and Aunts' => 'Дяди и тёти',
            '%s has no uncles or aunts recorded.' => '%s не имеет записанных дядь или тёть.',
            '%s has one aunt recorded.' => '%s имеет одну записанную тётю.',
            '%s has one uncle recorded.' => '%s имеет одного записанного дядю.',
            '%s has one uncle or aunt of unknown sex recorded.' => '%s имеет одного записанного дядю или тётю.',
            '%2$s has %1$d aunt recorded.' . I18N::PLURAL . '%2$s has %1$d aunts recorded.'
                => '%2$s имеет %1$d тётю записанной.' . I18N::PLURAL . '%2$s имеет %1$d тёть записанными.' . I18N::PLURAL . '%2$s имеет %1$d тёть записанными.',
            '%2$s has %1$d uncle recorded.' . I18N::PLURAL . '%2$s has %1$d uncles recorded.'
                => '%2$s имеет %1$d дядю записанным.' . I18N::PLURAL . '%2$s имеет %1$d дядь записанными.' . I18N::PLURAL . '%2$s имеет %1$d дядь записанными.',
            '%2$s has %1$d uncle or aunt of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d uncles or aunts of unknown sex recorded.'
                => '%2$s имеет %1$d дядю или тётю записанного.' . I18N::PLURAL . '%2$s имеет %1$d дядь или тёть записанными.' . I18N::PLURAL . '%2$s имеет %1$d дядь или тёть записанными.',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and '
                => '%2$s имеет %1$d дядю и ' . I18N::PLURAL . '%2$s имеет %1$d дядь и ' . I18N::PLURAL . '%2$s имеет %1$d дядь и ',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).'
                => '%d тётю записанными (всего %d).' . I18N::PLURAL . '%d тёть записанными (всего %d).' . I18N::PLURAL . '%d тёть записанными (всего %d).',
            '%2$s has %1$d aunt and ' . I18N::PLURAL . '%2$s has %1$d aunts and '
                => '%2$s имеет %1$d тётю и ' . I18N::PLURAL . '%2$s имеет %1$d тёть и ' . I18N::PLURAL . '%2$s имеет %1$d тёть и ',
            '%d uncle or aunt of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d uncles or aunts of unknown sex recorded (%d in total).'
                => '%d дядю или тётю записанными (всего %d).' . I18N::PLURAL . '%d дядь или тёть записанными (всего %d).' . I18N::PLURAL . '%d дядь или тёть записанными (всего %d).',
            '%2$s has %1$d uncle, ' . I18N::PLURAL . '%2$s has %1$d uncles, '
                => '%2$s имеет %1$d дядю, ' . I18N::PLURAL . '%2$s имеет %1$d дядь, ' . I18N::PLURAL . '%2$s имеет %1$d дядь, ',
            '%d aunt, and ' . I18N::PLURAL . '%d aunts, and '
                => '%d тётю, и ' . I18N::PLURAL . '%d тёть, и ' . I18N::PLURAL . '%d тёть, и ',

            'Uncles and Aunts by marriage' => 'Супруги дядь и тёть',
            '%s has no uncles or aunts by marriage recorded.' => '%s не имеет записанных супругов дядь или тёть.',
            '%s has one aunt by marriage recorded.' => '%s имеет одну записанную супругу дяди.',
            '%s has one uncle by marriage recorded.' => '%s имеет одного записанного супруга тёти.',
            '%s has one uncle or aunt by marriage of unknown sex recorded.' => '%s имеет одного записанного супруга дяди или тёти.',
            '%2$s has %1$d aunt by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d aunts by marriage recorded.'
                => '%2$s имеет %1$d тётю записанной.' . I18N::PLURAL . '%2$s имеет %1$d тёть записанными.' . I18N::PLURAL . '%2$s имеет %1$d тёть записанными.',
            '%2$s has %1$d uncle by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d uncles by marriage recorded.'
                => '%2$s имеет %1$d дядю записанным.' . I18N::PLURAL . '%2$s имеет %1$d дядь записанными.' . I18N::PLURAL . '%2$s имеет %1$d дядь записанными.',
            '%2$s has %1$d uncle or aunt by marriage of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d uncles or aunts by marriage of unknown sex recorded.'
                => '%2$s имеет %1$d дядю или тётю записанного.' . I18N::PLURAL . '%2$s имеет %1$d дядь или тёть записанными.' . I18N::PLURAL . '%2$s имеет %1$d дядь или тёть записанными.',
            '%2$s has %1$d uncle by marriage and ' . I18N::PLURAL . '%2$s has %1$d uncles by marriage and '
                => '%2$s имеет %1$d дядю и ' . I18N::PLURAL . '%2$s имеет %1$d дядь и ' . I18N::PLURAL . '%2$s имеет %1$d дядь и ',
            '%d aunt by marriage recorded (%d in total).' . I18N::PLURAL . '%d aunts by marriage recorded (%d in total).'
                => '%d тётю записанными (всего %d).' . I18N::PLURAL . '%d тёть записанными (всего %d).' . I18N::PLURAL . '%d тёть записанными (всего %d).',
            '%2$s has %1$d aunt by marriage and ' . I18N::PLURAL . '%2$s has %1$d aunts by marriage and '
                => '%2$s имеет %1$d тётю и ' . I18N::PLURAL . '%2$s имеет %1$d тёть и ' . I18N::PLURAL . '%2$s имеет %1$d тёть и ',
            '%d uncle or aunt by marriage of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d uncles or aunts by marriage of unknown sex recorded (%d in total).'
                => '%d дядю или тётю записанными (всего %d).' . I18N::PLURAL . '%d дядь или тёть записанными (всего %d).' . I18N::PLURAL . '%d дядь или тёть записанными (всего %d).',
            '%2$s has %1$d uncle by marriage, ' . I18N::PLURAL . '%2$s has %1$d uncles by marriage, '
                => '%2$s имеет %1$d дядю, ' . I18N::PLURAL . '%2$s имеет %1$d дядь, ' . I18N::PLURAL . '%2$s имеет %1$d дядь, ',
            '%d aunt by marriage, and ' . I18N::PLURAL . '%d aunts by marriage, and '
                => '%d тётю, и ' . I18N::PLURAL . '%d тёть, и ' . I18N::PLURAL . '%d тёть, и ',

            'Parents' => 'Родители',
            '%s has no parents recorded.' => '%s не имеет записанных отца и матери.',
            '%s has one mother recorded.' => '%s имеет записанную мать.',
            '%s has one father recorded.' => '%s имеет записанного отца.',
            '%s has one parent of unknown sex recorded.' => '%s имеет записанного отца или мать.',
            '%2$s has %1$d mother recorded.' . I18N::PLURAL . '%2$s has %1$d mothers recorded.'
                => '%2$s имеет %1$d мать записанной.' . I18N::PLURAL . '%2$s имеет %1$d матерей записанными.' . I18N::PLURAL . '%2$s имеет %1$d матерей записанными.',
            '%2$s has %1$d father recorded.' . I18N::PLURAL . '%2$s has %1$d fathers recorded.'
                => '%2$s имеет %1$d отца записанным.' . I18N::PLURAL . '%2$s имеет %1$d отцов записанными.' . I18N::PLURAL . '%2$s имеет %1$d отцов записанными.',
            '%2$s has %1$d parent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d parents of unknown sex recorded.'
                => '%2$s имеет %1$d отца или мать записанным.' . I18N::PLURAL . '%2$s имеет %1$d отцов или матерей записанными.' . I18N::PLURAL . '%2$s имеет %1$d отцов или матерей записанными.',
            '%2$s has %1$d father and ' . I18N::PLURAL . '%2$s has %1$d fathers and '
                => '%2$s имеет %1$d отца и ' . I18N::PLURAL . '%2$s имеет %1$d отцов и ' . I18N::PLURAL . '%2$s имеет %1$d отцов и ',
            '%d mother recorded (%d in total).' . I18N::PLURAL . '%d mothers recorded (%d in total).'
                => '%d мать записанными (всего %d).' . I18N::PLURAL . '%d матерей записанными (всего %d).' . I18N::PLURAL . '%d матерей записанными (всего %d).',
            '%2$s has %1$d mother and ' . I18N::PLURAL . '%2$s has %1$d mothers and '
                => '%2$s имеет %1$d мать и ' . I18N::PLURAL . '%2$s имеет %1$d матерей и ' . I18N::PLURAL . '%2$s имеет %1$d матерей и ',
            '%d parent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d parents of unknown sex recorded (%d in total).'
                => '%d отца или мать записанными (всего %d).' . I18N::PLURAL . '%d отцов или матерей записанными (всего %d).' . I18N::PLURAL . '%d отцов или матерей записанными (всего %d).',
            '%2$s has %1$d father, ' . I18N::PLURAL . '%2$s has %1$d fathers, '
                => '%2$s имеет %1$d отца, ' . I18N::PLURAL . '%2$s имеет %1$d отцов, ' . I18N::PLURAL . '%2$s имеет %1$d отцов, ',
            '%d mother, and ' . I18N::PLURAL . '%d mothers, and '
                => '%d мать, и ' . I18N::PLURAL . '%d матерей, и ' . I18N::PLURAL . '%d матерей, и ',

            'Parents-in-law' => 'Родители супругов (тесть, тёща, свёкр, свекровь)',
            '%s has no parents-in-law recorded.' => '%s не имеет записанных родителей супругов.',
            '%s has one mother-in-law recorded.' => '%s имеет записанную мать супруга(и).',
            '%s has one father-in-law recorded.' => '%s имеет записанного отца супруга(и).',
            '%s has one parent-in-law of unknown sex recorded.' => '%s имеет записанного отца или мать супруга(и).',
            '%2$s has %1$d mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d mothers-in-law recorded.'
                => '%2$s имеет %1$d мать записанной.' . I18N::PLURAL . '%2$s имеет %1$d матерей записанными.' . I18N::PLURAL . '%2$s имеет %1$d матерей записанными.',
            '%2$s has %1$d father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d fathers-in-law recorded.'
                => '%2$s имеет %1$d отца записанным.' . I18N::PLURAL . '%2$s имеет %1$d отцов записанными.' . I18N::PLURAL . '%2$s имеет %1$d отцов записанными.',
            '%2$s has %1$d parent-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d parents-in-law of unknown sex recorded.'
                => '%2$s имеет %1$d отца или мать записанным.' . I18N::PLURAL . '%2$s имеет %1$d отцов или матерей записанными.' . I18N::PLURAL . '%2$s имеет %1$d отцов или матерей записанными.',
            '%2$s has %1$d father-in-law and ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law and '
                => '%2$s имеет %1$d отца и ' . I18N::PLURAL . '%2$s имеет %1$d отцов и ' . I18N::PLURAL . '%2$s имеет %1$d отцов и ',
            '%d mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d mothers-in-law recorded (%d in total).'
                => '%d мать записанными (всего %d).' . I18N::PLURAL . '%d матерей записанными (всего %d).' . I18N::PLURAL . '%d матерей записанными (всего %d).',
            '%2$s has %1$d mother-in-law and ' . I18N::PLURAL . '%2$s has %1$d mothers-in-law and '
                => '%2$s имеет %1$d мать и ' . I18N::PLURAL . '%2$s имеет %1$d матерей и ' . I18N::PLURAL . '%2$s имеет %1$d матерей и ',
            '%d parent-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d parents-in-law of unknown sex recorded (%d in total).'
                => '%d отца или мать записанными (всего %d).' . I18N::PLURAL . '%d отцов или матерей записанными (всего %d).' . I18N::PLURAL . '%d отцов или матерей записанными (всего %d).',
            '%2$s has %1$d father-in-law, ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law, '
                => '%2$s имеет %1$d отца, ' . I18N::PLURAL . '%2$s имеет %1$d отцов, ' . I18N::PLURAL . '%2$s имеет %1$d отцов, ',
            '%d mother-in-law, and ' . I18N::PLURAL . '%d mothers-in-law, and '
                => '%d мать, и ' . I18N::PLURAL . '%d матерей, и ' . I18N::PLURAL . '%d матерей, и ',

            'Co-parents-in-law' => 'Сваты',
            '%s has no co-parents-in-law recorded.' => '%s не имеет записанных сватов.',
            '%s has one co-mother-in-law recorded.' => '%s имеет записанную сватью.',
            '%s has one co-father-in-law recorded.' => '%s имеет записанного свата.',
            '%s has one co-parent-in-law of unknown sex recorded.' => '%s имеет записанного свата или сватью.',
            '%2$s has %1$d co-mother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law recorded.'
                => '%2$s имеет %1$d сватью записанной.' . I18N::PLURAL . '%2$s имеет %1$d сватьи записанными.' . I18N::PLURAL . '%2$s имеет %1$d сватий записанными.',
            '%2$s has %1$d co-father-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law recorded.'
                => '%2$s имеет %1$d свата записанным.' . I18N::PLURAL . '%2$s имеет %1$d сватов записанными.' . I18N::PLURAL . '%2$s имеет %1$d сватов записанными.',
            '%2$s has %1$d co-parent-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d co-parents-in-law of unknown sex recorded.'
                => '%2$s имеет %1$d свата или сватью записанным.' . I18N::PLURAL . '%2$s имеет %1$d сватов или сватий записанными.' . I18N::PLURAL . '%2$s имеет %1$d сватов или сватий записанными.',
            '%2$s has %1$d co-father-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law and '
                => '%2$s имеет %1$d свата и ' . I18N::PLURAL . '%2$s имеет %1$d сватов и ' . I18N::PLURAL . '%2$s имеет %1$d сватов и ',
            '%d co-mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-mothers-in-law recorded (%d in total).'
                => '%d сватью записанными (всего %d).' . I18N::PLURAL . '%d сватий записанными (всего %d).' . I18N::PLURAL . '%d сватий записанными (всего %d).',
            '%2$s has %1$d co-mother-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law and '
                => '%2$s имеет %1$d сватью и ' . I18N::PLURAL . '%2$s имеет %1$d сватий и ' . I18N::PLURAL . '%2$s имеет %1$d сватий и ',
            '%d co-parent-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d co-parents-in-law of unknown sex recorded (%d in total).'
                => '%d свата или сватью записанными (всего %d).' . I18N::PLURAL . '%d сватов или сватий записанными (всего %d).' . I18N::PLURAL . '%d сватов или сватий записанными (всего %d).',
            '%2$s has %1$d co-father-in-law, ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law, '
                => '%2$s имеет %1$d свата, ' . I18N::PLURAL . '%2$s имеет %1$d сватов, ' . I18N::PLURAL . '%2$s имеет %1$d сватов, ',
            '%d co-mother-in-law, and ' . I18N::PLURAL . '%d co-mothers-in-law, and '
                => '%d сватью, и ' . I18N::PLURAL . '%d сватий, и ' . I18N::PLURAL . '%d сватий, и ',

            'Partners' => 'Супруги',
            'Partner of ' => 'Супруги у ',
            '%s has no partners recorded.' => '%s не имеет записанных супругов.',
            '%s has one female partner recorded.' => '%s имеет записанную супругу.',
            '%s has one male partner recorded.' => '%s имеет записанного супруга.',
            '%s has one partner of unknown sex recorded.' => '%s имеет записанного супруга или супругу.',
            '%2$s has %1$d female partner recorded.' . I18N::PLURAL . '%2$s has %1$d female partners recorded.'
                => '%2$s имеет %1$d супругу записанной.' . I18N::PLURAL . '%2$s имеет %1$d супруги записанными.' . I18N::PLURAL . '%2$s имеет %1$d супруг записанными.',
            '%2$s has %1$d male partner recorded.' . I18N::PLURAL . '%2$s has %1$d male partners recorded.'
                => '%2$s имеет %1$d супруга записанным.' . I18N::PLURAL . '%2$s имеет %1$d супругов записанными.' . I18N::PLURAL . '%2$s имеет %1$d супругов записанными.',
            '%2$s has %1$d partner of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d partners of unknown sex recorded.'
                => '%2$s имеет %1$d супруга или супругу записанным.' . I18N::PLURAL . '%2$s имеет %1$d супруга или супруги записанными.' . I18N::PLURAL . '%2$s имеет %1$d супругов или супруг записанными.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and '
                => '%2$s имеет %1$d супруга и ' . I18N::PLURAL . '%2$s имеет %1$d супругов и ' . I18N::PLURAL . '%2$s имеет %1$d супругов и ',
            '%2$s has %1$d female partner and ' . I18N::PLURAL . '%2$s has %1$d female partners and '
                => '%2$s имеет %1$d супругу и ' . I18N::PLURAL . '%2$s имеет %1$d супруги и ' . I18N::PLURAL . '%2$s имеет %1$d супруг и ',
            '%d female partner recorded (%d in total).' . I18N::PLURAL . '%d female partners recorded (%d in total).'
                => '%d супругу записанными (всего %d).' . I18N::PLURAL . '%d супруги записанными (всего %d).' . I18N::PLURAL . '%d супруг записанными (всего %d).',
            '%2$s has %1$d partner and ' . I18N::PLURAL . '%2$s has %1$d partners and '
                => '%2$s имеет %1$d супруга и ' . I18N::PLURAL . '%2$s имеет %1$d супругов и ' . I18N::PLURAL . '%2$s имеет %1$d супругов и ',
            '%d male partner of female partners recorded (%d in total).' . I18N::PLURAL . '%d male partners of female partners recorded (%d in total).'
                => '%d супруга супругу записанными (всего %d).' . I18N::PLURAL . '%d супругов супруг записанными (всего %d).' . I18N::PLURAL . '%d супругов супруг записанными (всего %d).',
            '%d female partner of male partners recorded (%d in total).' . I18N::PLURAL . '%d female partners of male partners recorded (%d in total).'
                => '%d супругу супруга записанными (всего %d).' . I18N::PLURAL . '%d супруги супругов записанными (всего %d).' . I18N::PLURAL . '%d супруг супругов записанными (всего %d).',

            'Partner chains' => 'Супружеские связи',
            '%s has no members of a partner chain recorded.' => '%s не имеет записанных супружеских связей.',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and '
                => '%2$s имеет %1$d супруга и ' . I18N::PLURAL . '%2$s имеет %1$d супругов и ' . I18N::PLURAL . '%2$s имеет %1$d супругов и ',
            '%d female partner in this partner chain recorded (%d in total).' . I18N::PLURAL . '%d female partners in this partner chain recorded (%d in total).'
                => '%d супругу записанными в этой супружеской связи (всего %d).' . I18N::PLURAL . '%d супруги записанными в этой супружеской связи (всего %d).' . I18N::PLURAL . '%d супруг записанными в этой супружеской связи (всего %d).',
            '%d female partner and ' . I18N::PLURAL . '%d female partners and '
                => '%d супругу и ' . I18N::PLURAL . '%d супруги и ' . I18N::PLURAL . '%d супруг и ',
            '%d partner of unknown sex in this partner chain recorded (%d in total).' . I18N::PLURAL . '%d partners of unknown sex in this partner chain recorded (%d in total).'
                => '%d супруга или супругу записанными в этой супружеской связи (всего %d).' . I18N::PLURAL . '%d супругов или супруги записанными в этой супружеской связи (всего %d).' . I18N::PLURAL . '%d супругов или супруг записанными в этой супружеской связи (всего %d).',
            '%2$s has %1$d female partner and ' . I18N::PLURAL . '%2$s has %1$d female partners and '
                => '%2$s имеет %1$d супругу и ' . I18N::PLURAL . '%2$s имеет %1$d супруги и ' . I18N::PLURAL . '%2$s имеет %1$d супруг и ',
            '%d partner of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d partners of unknown sex recorded (%d in total).'
                => '%d супруга или супругу записанными (всего %d).' . I18N::PLURAL . '%d супругов или супруги записанными (всего %d).' . I18N::PLURAL . '%d супругов или супруг записанными (всего %d).',
            '%2$s has %1$d male partner, ' . I18N::PLURAL . '%2$s has %1$d male partners, '
                => '%2$s имеет %1$d супруга, ' . I18N::PLURAL . '%2$s имеет %1$d супругов, ' . I18N::PLURAL . '%2$s имеет %1$d супругов, ',
            '%d female partner, and ' . I18N::PLURAL . '%d female partners, and '
                => '%d супругу, и ' . I18N::PLURAL . '%d супруги, и ' . I18N::PLURAL . '%d супруг, и ',
            'There are %d branches in the partner chain. ' => 'В супружеской цепи имеется %d ветвей. ',
            'The longest branch in the partner chain to %2$s consists of %1$d partners (including %3$s).' => 'Самая длинная ветвь в супружеской цепи для %2$s состоит из %1$d супругов (включая %3$s).',
            'The longest branch in the partner chain consists of %1$d partners (including %2$s).' => 'Самая длинная ветвь в супружеской цепи состоит из %1$d супругов (включая %2$s).',

            'Siblings' => 'Братья и сёстры',
            '%s has no siblings recorded.' => '%s не имеет записанных братьев и сестёр.',
            '%s has one sister recorded.' => '%s имеет записанную сестру.',
            '%s has one brother recorded.' => '%s имеет записанного брата.',
            '%s has one sibling of unknown sex recorded.' => '%s имеет записанного брата или сестру.',
            '%2$s has %1$d sister recorded.' . I18N::PLURAL . '%2$s has %1$d sisters recorded.'
                => '%2$s имеет %1$d сестру записанной.' . I18N::PLURAL . '%2$s имеет %1$d сестёр записанными.' . I18N::PLURAL . '%2$s имеет %1$d сестёр записанными.',
            '%2$s has %1$d brother recorded.' . I18N::PLURAL . '%2$s has %1$d brothers recorded.'
                => '%2$s имеет %1$d брата записанным.' . I18N::PLURAL . '%2$s имеет %1$d братьев записанными.' . I18N::PLURAL . '%2$s имеет %1$d братьев записанными.',
            '%2$s has %1$d sibling of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d siblings of unknown sex recorded.'
                => '%2$s имеет %1$d брата или сестру записанным.' . I18N::PLURAL . '%2$s имеет %1$d братьев или сестёр записанными.' . I18N::PLURAL . '%2$s имеет %1$d братьев или сестёр записанными.',
            '%2$s has %1$d brother and ' . I18N::PLURAL . '%2$s has %1$d brothers and '
                => '%2$s имеет %1$d брата и ' . I18N::PLURAL . '%2$s имеет %1$d братьев и ' . I18N::PLURAL . '%2$s имеет %1$d братьев и ',
            '%d sister recorded (%d in total).' . I18N::PLURAL . '%d sisters recorded (%d in total).'
                => '%d сестру записанными (всего %d).' . I18N::PLURAL . '%d сестёр записанными (всего %d).' . I18N::PLURAL . '%d сестёр записанными (всего %d).',
            '%2$s has %1$d sister and ' . I18N::PLURAL . '%2$s has %1$d sisters and '
                => '%2$s имеет %1$d сестру и ' . I18N::PLURAL . '%2$s имеет %1$d сестёр и ' . I18N::PLURAL . '%2$s имеет %1$d сестёр и ',
            '%d sibling of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d siblings of unknown sex recorded (%d in total).'
                => '%d брата или сестру записанными (всего %d).' . I18N::PLURAL . '%d братьев или сестёр записанными (всего %d).' . I18N::PLURAL . '%d братьев или сестёр записанными (всего %d).',
            '%2$s has %1$d brother, ' . I18N::PLURAL . '%2$s has %1$d brothers, '
                => '%2$s имеет %1$d брата, ' . I18N::PLURAL . '%2$s имеет %1$d братьев, ' . I18N::PLURAL . '%2$s имеет %1$d братьев, ',
            '%d sister, and ' . I18N::PLURAL . '%d sisters, and '
                => '%d сестру, и ' . I18N::PLURAL . '%d сестёр, и ' . I18N::PLURAL . '%d сестёр, и ',

            'Siblings-in-law' => 'Братья и сёстры супругов (деверь, золовка, шурин, свояченица)',
            '%s has no siblings-in-law recorded.' => '%s не имеет записанных братьев и сестёр.',
            '%s has one sister-in-law recorded.' => '%s имеет записанную сестру.',
            '%s has one brother-in-law recorded.' => '%s имеет записанного брата.',
            '%s has one sibling-in-law of unknown sex recorded.' => '%s имеет записанного брата или сестру.',
            '%2$s has %1$d sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sisters-in-law recorded.'
                => '%2$s имеет %1$d сестру записанной.' . I18N::PLURAL . '%2$s имеет %1$d сестёр записанными.' . I18N::PLURAL . '%2$s имеет %1$d сестёр записанными.',
            '%2$s has %1$d brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d brothers-in-law recorded.'
                => '%2$s имеет %1$d брата записанным.' . I18N::PLURAL . '%2$s имеет %1$d братьев записанными.' . I18N::PLURAL . '%2$s имеет %1$d братьев записанными.',
            '%2$s has %1$d sibling-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d siblings-in-law of unknown sex recorded.'
                => '%2$s имеет %1$d брата или сестру записанным.' . I18N::PLURAL . '%2$s имеет %1$d братьев или сестёр записанными.' . I18N::PLURAL . '%2$s имеет %1$d братьев или сестёр записанными.',
            '%2$s has %1$d brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law and '
                => '%2$s имеет %1$d брата и ' . I18N::PLURAL . '%2$s имеет %1$d братьев и ' . I18N::PLURAL . '%2$s имеет %1$d братьев и ',
            '%d sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d sisters-in-law recorded (%d in total).'
                => '%d сестру записанными (всего %d).' . I18N::PLURAL . '%d сестёр записанными (всего %d).' . I18N::PLURAL . '%d сестёр записанными (всего %d).',
            '%2$s has %1$d sister-in-law and ' . I18N::PLURAL . '%2$s has %1$d sisters-in-law and '
                => '%2$s имеет %1$d сестру и ' . I18N::PLURAL . '%2$s имеет %1$d сестёр и ' . I18N::PLURAL . '%2$s имеет %1$d сестёр и ',
            '%d sibling-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d siblings-in-law of unknown sex recorded (%d in total).'
                => '%d брата или сестру записанными (всего %d).' . I18N::PLURAL . '%d братьев или сестёр записанными (всего %d).' . I18N::PLURAL . '%d братьев или сестёр записанными (всего %d).',
            '%2$s has %1$d brother-in-law, ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law, '
                => '%2$s имеет %1$d брата, ' . I18N::PLURAL . '%2$s имеет %1$d братьев, ' . I18N::PLURAL . '%2$s имеет %1$d братьев, ',
            '%d sister-in-law, and ' . I18N::PLURAL . '%d sisters-in-law, and '
                => '%d сестру, и ' . I18N::PLURAL . '%d сестёр, и ' . I18N::PLURAL . '%d сестёр, и ',

            'Co-siblings-in-law' => 'Братья и сёстры супругов (по отношению друг к другу)',
            '%s has no co-siblings-in-law recorded.' => '%s не имеет записанных братьев и сестёр.',
            '%s has one co-sister-in-law recorded.' => '%s имеет записанную сестру.',
            '%s has one co-brother-in-law recorded.' => '%s имеет записанного брата.',
            '%s has one co-sibling-in-law of unknown sex recorded.' => '%s имеет записанного брата или сестру.',
            '%2$s has %1$d co-sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-sisters-in-law recorded.'
                => '%2$s имеет %1$d сестру записанной.' . I18N::PLURAL . '%2$s имеет %1$d сестёр записанными.' . I18N::PLURAL . '%2$s имеет %1$d сестёр записанными.',
            '%2$s has %1$d co-brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law recorded.'
                => '%2$s имеет %1$d брата записанным.' . I18N::PLURAL . '%2$s имеет %1$d братьев записанными.' . I18N::PLURAL . '%2$s имеет %1$d братьев записанными.',
            '%2$s has %1$d co-sibling-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d co-siblings-in-law of unknown sex recorded.'
                => '%2$s имеет %1$d брата или сестру записанным.' . I18N::PLURAL . '%2$s имеет %1$d братьев или сестёр записанными.' . I18N::PLURAL . '%2$s имеет %1$d братьев или сестёр записанными.',
            '%2$s has %1$d co-brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law and '
                => '%2$s имеет %1$d брата и ' . I18N::PLURAL . '%2$s имеет %1$d братьев и ' . I18N::PLURAL . '%2$s имеет %1$d братьев и ',
            '%d co-sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-sisters-in-law recorded (%d in total).'
                => '%d сестру записанными (всего %d).' . I18N::PLURAL . '%d сестёр записанными (всего %d).' . I18N::PLURAL . '%d сестёр записанными (всего %d).',
            '%2$s has %1$d co-sister-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-sisters-in-law and '
                => '%2$s имеет %1$d сестру и ' . I18N::PLURAL . '%2$s имеет %1$d сестёр и ' . I18N::PLURAL . '%2$s имеет %1$d сестёр и ',
            '%d co-sibling-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d co-siblings-in-law of unknown sex recorded (%d in total).'
                => '%d брата или сестру записанными (всего %d).' . I18N::PLURAL . '%d братьев или сестёр записанными (всего %d).' . I18N::PLURAL . '%d братьев или сестёр записанными (всего %d).',
            '%2$s has %1$d co-brother-in-law, ' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law, '
                => '%2$s имеет %1$d брата, ' . I18N::PLURAL . '%2$s имеет %1$d братьев, ' . I18N::PLURAL . '%2$s имеет %1$d братьев, ',
            '%d co-sister-in-law, and ' . I18N::PLURAL . '%d co-sisters-in-law, and '
                => '%d сестру, и ' . I18N::PLURAL . '%d сестёр, и ' . I18N::PLURAL . '%d сестёр, и ',

            'Cousins' => 'Двоюродные братья и сёстры',
            '%s has no first cousins recorded.' => '%s не имеет записанных двоюродных братьев и сестёр.',
            '%s has one female first cousin recorded.' => '%s имеет записанную двоюродную сестру.',
            '%s has one male first cousin recorded.' => '%s имеет записанного двоюродного брата.',
            '%s has one first cousin of unknown sex recorded.' => '%s имеет записанного двуюродного брата или сестру.',
            '%2$s has %1$d female first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d female first cousins recorded.'
                => '%2$s имеет %1$d сестру записанной.' . I18N::PLURAL . '%2$s имеет %1$d сестёр записанными.' . I18N::PLURAL . '%2$s имеет %1$d сестёр записанными.',
            '%2$s has %1$d male first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d male first cousins recorded.'
                => '%2$s имеет %1$d брата записанным.' . I18N::PLURAL . '%2$s имеет %1$d братьев записанными.' . I18N::PLURAL . '%2$s имеет %1$d братьев записанными.',
            '%2$s has %1$d first cousin of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d first cousins of unknown sex recorded.'
                => '%2$s имеет %1$d брата или сестру записанным.' . I18N::PLURAL . '%2$s имеет %1$d братьев или сестёр записанными.' . I18N::PLURAL . '%2$s имеет %1$d братьев или сестёр записанными.',
            '%2$s has %1$d male first cousin and ' . I18N::PLURAL . '%2$s has %1$d male first cousins and '
                => '%2$s имеет %1$d брата и ' . I18N::PLURAL . '%2$s имеет %1$d братьев и ' . I18N::PLURAL . '%2$s имеет %1$d братьев и ',
            '%d female first cousin recorded (%d in total).' . I18N::PLURAL . '%d female first cousins recorded (%d in total).'
                => '%d сестру записанными (всего %d).' . I18N::PLURAL . '%d сестёр записанными (всего %d).' . I18N::PLURAL . '%d сестёр записанными (всего %d).',
            '%2$s has %1$d female first cousin and ' . I18N::PLURAL . '%2$s has %1$d female first cousins and '
                => '%2$s имеет %1$d сестру и ' . I18N::PLURAL . '%2$s имеет %1$d сестёр и ' . I18N::PLURAL . '%2$s имеет %1$d сестёр и ',
            '%d first cousin of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d first cousins of unknown sex recorded (%d in total).'
                => '%d брата или сестру записанными (всего %d).' . I18N::PLURAL . '%d братьев или сестёр записанными (всего %d).' . I18N::PLURAL . '%d братьев или сестёр записанными (всего %d).',
            '%2$s has %1$d male first cousin, ' . I18N::PLURAL . '%2$s has %1$d male first cousins, '
                => '%2$s имеет %1$d брата, ' . I18N::PLURAL . '%2$s имеет %1$d братьев, ' . I18N::PLURAL . '%2$s имеет %1$d братьев, ',
            '%d female first cousin, and ' . I18N::PLURAL . '%d female first cousins, and '
                => '%d сестру, и ' . I18N::PLURAL . '%d сестёр, и ' . I18N::PLURAL . '%d сестёр, и ',

            'Nephews and Nieces' => 'Племянники и племянницы',
            '%s has no nephews or nieces recorded.' => '%s не имеет записанных племянников и племянниц.',
            '%s has one niece recorded.' => '%s имеет записанную племянницу.',
            '%s has one nephew recorded.' => '%s имеет записанного племянника.',
            '%s has one nephew or niece of unknown sex recorded.' => '%s имеет записанного племянника или племянницу.',
            '%2$s has %1$d niece recorded.' . I18N::PLURAL . '%2$s has %1$d nieces recorded.'
                => '%2$s имеет %1$d племянницу записанной.' . I18N::PLURAL . '%2$s имеет %1$d племянницы записанными.' . I18N::PLURAL . '%2$s имеет %1$d племянниц записанными.',
            '%2$s has %1$d nephew recorded.' . I18N::PLURAL . '%2$s has %1$d nephews recorded.'
                => '%2$s имеет %1$d племянника записанным.' . I18N::PLURAL . '%2$s имеет %1$d племянников записанными.' . I18N::PLURAL . '%2$s имеет %1$d племянников записанными.',
            '%2$s has %1$d nephew or niece of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d nephews or nieces of unknown sex recorded.'
                => '%2$s имеет %1$d племянника или племянницу записанным.' . I18N::PLURAL . '%2$s имеет %1$d племянников или племянниц записанными.' . I18N::PLURAL . '%2$s имеет %1$d племянников или племянниц записанными.',
            '%2$s has %1$d nephew and ' . I18N::PLURAL . '%2$s has %1$d nephews and '
                => '%2$s имеет %1$d племянника и ' . I18N::PLURAL . '%2$s имеет %1$d племянников и ' . I18N::PLURAL . '%2$s имеет %1$d племянников и ',
            '%d niece recorded (%d in total).' . I18N::PLURAL . '%d nieces recorded (%d in total).'
                => '%d племянницу записанными (всего %d).' . I18N::PLURAL . '%d племянниц записанными (всего %d).' . I18N::PLURAL . '%d племянниц записанными (всего %d).',
            '%2$s has %1$d niece and ' . I18N::PLURAL . '%2$s has %1$d nieces and '
                => '%2$s имеет %1$d племянницу и ' . I18N::PLURAL . '%2$s имеет %1$d племянниц и ' . I18N::PLURAL . '%2$s имеет %1$d племянниц и ',
            '%d nephew or niece of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d nephews or nieces of unknown sex recorded (%d in total).'
                => '%d племянника или племянницу записанными (всего %d).' . I18N::PLURAL . '%d племянников или племянниц записанными (всего %d).' . I18N::PLURAL . '%d племянников или племянниц записанными (всего %d).',
            '%2$s has %1$d nephew, ' . I18N::PLURAL . '%2$s has %1$d nephews, '
                => '%2$s имеет %1$d племянника, ' . I18N::PLURAL . '%2$s имеет %1$d племянников, ' . I18N::PLURAL . '%2$s имеет %1$d племянников, ',
            '%d niece, and ' . I18N::PLURAL . '%d nieces, and '
                => '%d племянницу, и ' . I18N::PLURAL . '%d племянниц, и ' . I18N::PLURAL . '%d племянниц, и ',

            'Children' => 'Дети',
            '%s has no children recorded.' => '%s не имеет записанных детей.',
            '%s has one daughter recorded.' => '%s имеет записанную дочь.',
            '%s has one son recorded.' => '%s имеет записанного сына.',
            '%s has one child of unknown sex recorded.' => '%s имеет записанного ребёнка.',
            '%2$s has %1$d daughter recorded.' . I18N::PLURAL . '%2$s has %1$d daughters recorded.'
                => '%2$s имеет %1$d дочь записанной.' . I18N::PLURAL . '%2$s имеет %1$d дочери записанными.' . I18N::PLURAL . '%2$s имеет %1$d дочерей записанными.',
            '%2$s has %1$d son recorded.' . I18N::PLURAL . '%2$s has %1$d sons recorded.'
                => '%2$s имеет %1$d сына записанным.' . I18N::PLURAL . '%2$s имеет %1$d сыновей записанными.' . I18N::PLURAL . '%2$s имеет %1$d сыновей записанными.',
            '%2$s has %1$d child of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d children of unknown sex recorded.'
                => '%2$s имеет %1$d ребёнка записанным.' . I18N::PLURAL . '%2$s имеет %1$d детей записанными.' . I18N::PLURAL . '%2$s имеет %1$d детей записанными.',
            '%2$s has %1$d son and ' . I18N::PLURAL . '%2$s has %1$d sons and '
                => '%2$s имеет %1$d сына и ' . I18N::PLURAL . '%2$s имеет %1$d сыновей и ' . I18N::PLURAL . '%2$s имеет %1$d сыновей и ',
            '%d daughter recorded (%d in total).' . I18N::PLURAL . '%d daughters recorded (%d in total).'
                => '%d дочь записанными (всего %d).' . I18N::PLURAL . '%d дочерей записанными (всего %d).' . I18N::PLURAL . '%d дочерей записанными (всего %d).',
            '%2$s has %1$d daughter and ' . I18N::PLURAL . '%2$s has %1$d daughters and '
                => '%2$s имеет %1$d дочь и ' . I18N::PLURAL . '%2$s имеет %1$d дочерей и ' . I18N::PLURAL . '%2$s имеет %1$d дочерей и ',
            '%d child of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d children of unknown sex recorded (%d in total).'
                => '%d детей записанными (всего %d).' . I18N::PLURAL . '%d детей записанными (всего %d).' . I18N::PLURAL . '%d детей записанными (всего %d).',
            '%2$s has %1$d son, ' . I18N::PLURAL . '%2$s has %1$d sons, '
                => '%2$s имеет %1$d сына, ' . I18N::PLURAL . '%2$s имеет %1$d сыновей, ' . I18N::PLURAL . '%2$s имеет %1$d сыновей, ',
            '%d daughter, and ' . I18N::PLURAL . '%d daughters, and '
                => '%d дочь, и ' . I18N::PLURAL . '%d дочерей, и ' . I18N::PLURAL . '%d дочерей, и ',

            'Children-in-law' => 'Супруги детей (зять, невестка)',
            '%s has no children-in-law recorded.' => '%s не имеет записанных супругов детей.',
            '%s has one daughter-in-law recorded.' => '%s имеет записанную невестку.',
            '%s has one son-in-law recorded.' => '%s имеет записанного зятя.',
            '%s has one child-in-law of unknown sex recorded.' => '%s имеет записанного зятя или невестку.',
            '%2$s has %1$d daughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d daughters-in-law recorded.'
                => '%2$s имеет %1$d невестку записанной.' . I18N::PLURAL . '%2$s имеет %1$d невесток записанными.' . I18N::PLURAL . '%2$s имеет %1$d невесток записанными.',
            '%2$s has %1$d son-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sons-in-law recorded.'
                => '%2$s имеет %1$d зятя записанным.' . I18N::PLURAL . '%2$s имеет %1$d зятьёв записанными.' . I18N::PLURAL . '%2$s имеет %1$d зятьёв записанными.',
            '%2$s has %1$d child-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d children-in-law recorded.'
                => '%2$s имеет %1$d зятя или невестку записанным.' . I18N::PLURAL . '%2$s имеет %1$d зятьёв или невесток записанными.' . I18N::PLURAL . '%2$s имеет %1$d зятьёв или невесток записанными.',
            '%2$s has %1$d son-in-law and ' . I18N::PLURAL . '%2$s has %1$d sons-in-law and '
                => '%2$s имеет %1$d зятя и ' . I18N::PLURAL . '%2$s имеет %1$d зятьёв и ' . I18N::PLURAL . '%2$s имеет %1$d зятьёв и ',
            '%d daughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d daughters-in-law recorded (%d in total).'
                => '%d невестку записанными (всего %d).' . I18N::PLURAL . '%d невесток записанными (всего %d).' . I18N::PLURAL . '%d невесток записанными (всего %d).',
            '%2$s has %1$d daughter-in-law and ' . I18N::PLURAL . '%2$s has %1$d daughters-in-law and '
                => '%2$s имеет %1$d невестку и ' . I18N::PLURAL . '%2$s имеет %1$d невесток и ' . I18N::PLURAL . '%2$s имеет %1$d невесток и ',
            '%d child-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d children-in-law of unknown sex recorded (%d in total).'
                => '%d зятя или невестку записанными (всего %d).' . I18N::PLURAL . '%d зятьёв или невесток записанными (всего %d).' . I18N::PLURAL . '%d зятьёв или невесток записанными (всего %d).',
            '%2$s has %1$d son-in-law, ' . I18N::PLURAL . '%2$s has %1$d sons-in-law, '
                => '%2$s имеет %1$d зятя, ' . I18N::PLURAL . '%2$s имеет %1$d зятьёв, ' . I18N::PLURAL . '%2$s имеет %1$d зятьёв, ',
            '%d daughter-in-law, and ' . I18N::PLURAL . '%d daughters-in-law, and '
                => '%d невестку, и ' . I18N::PLURAL . '%d невесток, и ' . I18N::PLURAL . '%d невесток, и ',

            'Grandchildren' => 'Внуки и внучки',
            '%s has no grandchildren recorded.' => '%s не имеет записанных внуков и внучек.',
            '%s has one granddaughter recorded.' => '%s имеет записанную внучку.',
            '%s has one grandson recorded.' => '%s имеет записанного внука.',
            '%s has one grandchild of unknown sex recorded.' => '%s имеет записанного внука или внучку.',
            '%2$s has %1$d granddaughter recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters recorded.'
                => '%2$s имеет %1$d внучку записанной.' . I18N::PLURAL . '%2$s имеет %1$d внучек записанными.' . I18N::PLURAL . '%2$s имеет %1$d внучек записанными.',
            '%2$s has %1$d grandson recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons recorded.'
                => '%2$s имеет %1$d внука записанным.' . I18N::PLURAL . '%2$s имеет %1$d внуков записанными.' . I18N::PLURAL . '%2$s имеет %1$d внуков записанными.',
            '%2$s has %1$d grandchild of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandchildren of unknown sex recorded.'
                => '%2$s имеет %1$d внука или внучку записанным.' . I18N::PLURAL . '%2$s имеет %1$d внуков или внучек записанными.' . I18N::PLURAL . '%2$s имеет %1$d внуков или внучек записанными.',
            '%2$s has %1$d grandson and ' . I18N::PLURAL . '%2$s has %1$d grandsons and '
                => '%2$s имеет %1$d внука и ' . I18N::PLURAL . '%2$s имеет %1$d внуков и ' . I18N::PLURAL . '%2$s имеет %1$d внуков и ',
            '%d granddaughter recorded (%d in total).' . I18N::PLURAL . '%d granddaughters recorded (%d in total).'
                => '%d внучку записанными (всего %d).' . I18N::PLURAL . '%d внучек записанными (всего %d).' . I18N::PLURAL . '%d внучек записанными (всего %d).',
            '%2$s has %1$d granddaughter and ' . I18N::PLURAL . '%2$s has %1$d granddaughters and '
                => '%2$s имеет %1$d внучку и ' . I18N::PLURAL . '%2$s имеет %1$d внучек и ' . I18N::PLURAL . '%2$s имеет %1$d внучек и ',
            '%d grandchild of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandchildren of unknown sex recorded (%d in total).'
                => '%d внука или внучку записанными (всего %d).' . I18N::PLURAL . '%d внуков или внучек записанными (всего %d).' . I18N::PLURAL . '%d внуков или внучек записанными (всего %d).',
            '%2$s has %1$d grandson, ' . I18N::PLURAL . '%2$s has %1$d grandsons, '
                => '%2$s имеет %1$d внука, ' . I18N::PLURAL . '%2$s имеет %1$d внуков, ' . I18N::PLURAL . '%2$s имеет %1$d внуков, ',
            '%d granddaughter, and ' . I18N::PLURAL . '%d granddaughters, and '
                => '%d внучку, и ' . I18N::PLURAL . '%d внучек, и ' . I18N::PLURAL . '%d внучек, и ',

            'Grandchildren-in-law' => 'Супруги внуков и внучек',
            '%s has no grandchildren-in-law recorded.' => '%s не имеет записанных супругов внуков и внучек.',
            '%s has one granddaughter-in-law recorded.' => '%s имеет записанную внучку.',
            '%s has one grandson-in-law recorded.' => '%s имеет записанного внука.',
            '%s has one grandchild-in-law of unknown sex recorded.' => '%s имеет записанного внука или внучку.',
            '%2$s has %1$d granddaughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters-in-law recorded.'
                => '%2$s имеет %1$d внучку записанной.' . I18N::PLURAL . '%2$s имеет %1$d внучек записанными.' . I18N::PLURAL . '%2$s имеет %1$d внучек записанными.',
            '%2$s has %1$d grandson-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons-in-law recorded.'
                => '%2$s имеет %1$d внука записанным.' . I18N::PLURAL . '%2$s имеет %1$d внуков записанными.' . I18N::PLURAL . '%2$s имеет %1$d внуков записанными.',
            '%2$s has %1$d grandchild-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandchildren-in-law of unknown sex recorded.'
                => '%2$s имеет %1$d внука или внучку записанным.' . I18N::PLURAL . '%2$s имеет %1$d внуков или внучек записанными.' . I18N::PLURAL . '%2$s имеет %1$d внуков или внучек записанными.',
            '%2$s has %1$d grandson-in-law and ' . I18N::PLURAL . '%2$s has %1$d grandsons-in-law and '
                => '%2$s имеет %1$d внука и ' . I18N::PLURAL . '%2$s имеет %1$d внуков и ' . I18N::PLURAL . '%2$s имеет %1$d внуков и ',
            '%d granddaughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d granddaughters-in-law recorded (%d in total).'
                => '%d внучку записанными (всего %d).' . I18N::PLURAL . '%d внучек записанными (всего %d).' . I18N::PLURAL . '%d внучек записанными (всего %d).',
            '%2$s has %1$d granddaughter-in-law and ' . I18N::PLURAL . '%2$s has %1$d granddaughters-in-law and '
                => '%2$s имеет %1$d внучку и ' . I18N::PLURAL . '%2$s имеет %1$d внучек и ' . I18N::PLURAL . '%2$s имеет %1$d внучек и ',
            '%d grandchild-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandchildren-in-law of unknown sex recorded (%d in total).'
                => '%d внука или внучку записанными (всего %d).' . I18N::PLURAL . '%d внуков или внучек записанными (всего %d).' . I18N::PLURAL . '%d внуков или внучек записанными (всего %d).',
            '%2$s has %1$d grandson-in-law, ' . I18N::PLURAL . '%2$s has %1$d grandsons-in-law, '
                => '%2$s имеет %1$d внука, ' . I18N::PLURAL . '%2$s имеет %1$d внуков, ' . I18N::PLURAL . '%2$s имеет %1$d внуков, ',
            '%d granddaughter-in-law, and ' . I18N::PLURAL . '%d granddaughters-in-law, and '
                => '%d внучку, и ' . I18N::PLURAL . '%d внучек, и ' . I18N::PLURAL . '%d внучек, и ',
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
            'In which sequence should the parts of the extended family be shown?' => 'V akom poradí sa majú zobraziť časti širšej rodiny?',
            'Family part' => 'Časť rodiny',
            'Show name of proband as short name or as full name?' => 'Zobraziť skrátené, alebo plné meno probanda?',
            'Show options to filter the results (gender and alive/dead)?' => 'Zobraziť možnosti na filtrovanie výsledkov (pohlavie a živí/zosnulí)?',
            'Show filter options' => 'Zobraziť voľby filtra',
            'How should empty parts of extended family be presented?' => 'Ako zobraziť prázdne bloky?',
            'Show empty block' => 'Zobraziť prázdne bloky',
            'yes, always at standard location' => 'áno, vždy na bežnom mieste',
            'no, but collect messages about empty blocks at the end' => 'nie, zobraz správy o prázdnych blokoch na konci',
            'never' => 'nikdy',
            'The short name is based on the probands Rufname or nickname. If these are not available, the first of the given names is used, if one is given. Otherwise the last name is used.' => 'Skrátené meno je buď tzv. Rufname, alebo prezývka. Ak tieto neexistujú, tak sa použije prvé krstné meno. Ak ani toto neexistuje, tak sa použije priezvisko.',
            'Show short name' => 'Zobraziť skrátené meno',
            'Show labels in special situations?' => 'Zobraziť štítky pri špecifických situáciách?',
            'Labels (or stickers) are used for example for adopted persons or foster children.' => 'Štítky sa použijú napr. pre adoptívne deti alebo deti zverené do opatery.',
            'Show labels' => 'Zobraziť štítky',
            'Use the compact design?' => 'Použiť kompaktný dizajn?',
            'Use the compact design' => 'Použiť kompaktný dizajn',
            'The compact design only shows the name and life span for each person. The enriched design also shows a photo (if this is activated for this tree) as well as birth and death information.' => 'Kompaktný dizajn zobrazuje pri každej osobe len meno a roky narodenia a úmrtia. Rozšírený dizajn zobrazuje fotku, ak je toto zobrazenie pre príslušný strom aktivivané, ako aj údaje o narodení a úmrtí.',
            'Show parameters of extended family part?' => 'Zobraziť parametere pre časti širšej rodiny?',
            'Display of additional information for each part of the extended family, such as the generation shift and the coefficient of relationship, which is a measure of the degree of consanguinity.' => 'Zobraziť dodatočné informácie pre každú časť širšej rodiny, napr. posun generácie a koeficient vzťahu, ktorý je meradlom stupňa pokrvnej príbuznosti.',
            'Show parameters' => 'Zobraziť parametre',

            'generation +%s' => 'generácia +%s',
            'same generation' => 'rovnaká generácia',
            'generation %s' => 'generácia %s',
            'relationship coefficient: %.1f' => 'koeficient príbuznosti: %.1f',
            'no blood relationship' => 'žiadna pokrvná príbuznosť',

            'don\'t use this filter' => 'nepoužiť tento filter',
            'show only male persons' => 'zobraziť len mužské osoby',
            'show only female persons' => 'zobraziť len ženské osoby',
            'show only persons of unknown gender' => 'zobraziť len osoby s neznámym pohlavím',
            'show only alive persons' => 'zobraziť len žijúce osoby',
            'show only dead persons' => 'zobraziť len zosnulé osoby',
            'alive' => 'živí',
            'dead' => 'zosnulí',
            'a dead person' => 'zosnulá osoba',
            'a living person' => 'žijúca osoba',
            'not a male person' => 'žiadna mužská osoba',
            'not a female person' => 'žiadna ženská osoba',
            'not a person of unknown gender' => 'žiadna osoba s neznámym pohlavím',

            'twin' => 'dvojča',
            'triplet' => 'trojča',
            'quadruplet' => 'štvorča',
            'quintuplet' => 'pätorča',
            'sextuplet' => 'šestorča',
            'septuplet' => 'sedmorča',
            'octuplet' => 'osmorča',
            'nonuplet' => 'devätorča',
            'decuplet' => 'desatorča',
            'stillborn' => 'mŕtvo narodené',
            'died as infant' => 'zomrel/a ako dieťa',
            'linkage challenged' => 'vzťah spochybnené',
            'linkage disproven' => 'vzťa vyvrátený',
            'linkage proven' => 'vzťah potvrdený',

            'Marriage' => 'Manželstvo',
            'Ex-marriage' => 'Rozvedené manželstvo',
            'Partnership' => 'Partnerschaft',
            'Fiancée' => 'Zasnúbenie',
            ' with ' => ' s ',

            'Biological grandparents of father' => 'Biologickí starí rodičia otca',
            'Biological grandparents of mother' => 'Biologickí starí rodičia matky',
            'Biological grandparents of parent' => 'Biologickí starí rodičia rodiča',
            'Stepparents of biological parent of father' => 'Nevlastní rodičia biologického rodiča otca',
            'Stepparents of biological parent of mother' => 'Nevlastní rodičia biologického rodiča matky',
            'Stepparents of biological grandparent' => 'Nevlastní rodičia bilogického starého rodiča',
            'Parents of stepparent of father' => 'Rodičia nevlastného rodiča otca',
            'Parents of stepparent of mother' => 'Rodičia nevlastného rodiča matky',
            'Parents of stepparent of parent' => 'Rodičia nevlastného rodiča rodiča',
            'Grandparents of stepparent' => 'Starí rodičia nevlastného rodiča',
            'Biological great-grandparents' => 'Biologickí prarodičia',
            'Biological parents of father' => 'Biologickí rodičia otca',
            'Biological parents of mother' => 'Biologickí rodičia matky',
            'Biological parents of parent' => 'Biologickí rodičia rodiča',
            'Stepparents of father' => 'Nevlastní rodičia otca',
            'Stepparents of mother' => 'Nevlastní rodičia matky',
            'Stepparents of parent' => 'Nevlastní rodičia rodiča',
            'Parents of stepparent' => 'Rodičia nevlastného rodiča',
            'Biological grandparents' => 'Biologickí starí rodičia',
            'Siblings of father' => 'Otcovi súrodenci',
            'Siblings of mother' => 'Matkini súrodenci',
            'Full siblings of biological parents' => 'Pokrvní súrodenci biologických rodičov',
            'Siblings-in-law of father' => 'Otcovi švagrovia a švagriné',
            'Siblings-in-law of mother' => 'Matkini švagrovia a švagrovia',
            'Biological parents' => 'Biologickí rodičia',
            'Stepparents' => 'Nevlastní rodičia',
            'Parents-in-law of biological children' => 'Svokrovci biologických detí',
            'Parents-in-law of stepchildren' => 'Svokrovci nevlastných detí',
            'Full siblings' => 'Súrodenci',
            'Half siblings' => 'Poloviční súrodenci',
            'Stepsiblings' => 'Nevlastní súrodenci',
            'Children of full siblings of father' => 'Deti otcových súrodencov',
            'Children of full siblings of mother' => 'Deti matkiných súrodencov',
            'Children of full siblings of parent' => 'Deti súrodencov jedného z rodičov',
            'Children of half siblings of father' => 'Deti otcových polovičných súrodencov',
            'Children of half siblings of mother' => 'Deti matkiných polovičných súrodencov',
            'Children of half siblings of parent' => 'Deti polovičných súrodencov jedného z rodičov',
            'Siblings of partners' => 'Súrodenci partnera',
            'Partners of siblings' => 'Partneri súrodencov',
            'Siblings of siblings-in-law' => 'Súrodenci švagrov a švagrín',
            'Partners of siblings-in-law' => 'Partneri švagrov a švagrín',
            'Children of full siblings of biological parents' => 'Deti súrodencov biologických rodičov',
            'Children of siblings' => 'Deti súrodencov',
            'Children of full siblings' => 'Deti vlastných súrodencov',
            'Siblings\' stepchildren' => 'Nevlastné deti súrodencov',
            'Children of siblings of partners' => 'Deti súrodencov partnera',
            'Biological children' => 'Biologické deti',
            'Stepchildren' => 'Nevlastné deti',
            'Stepchild' => 'Nevlastné dieťa',
            'Stepson' => 'Nevlastný syn',
            'Stepdaughter' => 'Nevlastná dcéra',
            'Partners of biological children' => 'Partneri vlastných detí',
            'Partners of stepchildren' => 'Partneri nevlastných detí',
            'Biological grandchildren' => 'Biologické vnúčatá',
            'Stepchildren of children' => 'Nevlastné deti detí',
            'Children of stepchildren' => 'Deti nevlastných detí',
            'Stepchildren of stepchildren' => 'Nevlastné deti nevlastných detí',
            'Partners of biological grandchildren' => 'Partner biologického vnúčaťa',
            'Partners of stepchildren of children' => 'Partner nevlastného dieťaťa dieťaťa',
            'Partners of children of stepchildren' => 'Partner dieťaťa nevlastného dieťaťa',
            'Partners of stepchildren of stepchildren' => 'Partner nevlastného dieťaťa nevlastného dieťaťa',

            'He' => 'On',
            'She' => 'Ona',
            'He/she' => 'On/ona',
            'Mr.' => 'Pán',
            'Mrs.' => 'Pani',
            'No family available' => 'Nenašla sa žiadna rodina',
            'Summary for the shown extended family' => 'Sumár zobrazenej širšej rodiny',
            'The extended family of %1$s has one member.' . I18N::PLURAL . 'The extended family of %1$s has %2$d members.'
                => '%1$s má v širšej rodine jedného člena.' . I18N::PLURAL . '%1$s má v širšej rodine %2$d členov.' . I18N::PLURAL . '%1$s má v širšej rodine %2$d členov.',
            '%s has no %s recorded.' => '%s nemá zaznamenané %s.',
            '%s has no %s, and no %s recorded.' => '%s nemá zaznamenané %s ani %s.',

            'Father\'s family (%d)' => 'Otcova rodina (%d)',
            'Mother\'s family (%d)' => 'Matkina rodina (%d)',
            'Father\'s and Mother\'s family (%d)' => 'Otcova a matkina rodina (%d)',
            'Grandparents %1$s (%2$s) of stepfather %3$s' => 'Starí rodičia %1$s (%2$s) nevlastného otca %3$s',
            'Grandparents %1$s (%2$s) of stepmother %3$s' => 'Starí rodičia %1$s (%2$s) nevlastnej matky %3$s',
            'Grandparents %1$s (%2$s) of stepparent %3$s' => 'Starí rodičia %1$s (%2$s) nevlastného rodiča %3$s',
            'Stepparents %1$s (%2$s) of %3$s' => 'Nevlastní rodičia %1$s (%2$s) osoby %3$s',
            'Parents %1$s (%2$s) of stepfather %3$s' => 'Rodičia %1$s (%2$s) nevlastného otca %3$s',
            'Parents %1$s (%2$s) of stepmother %3$s' => 'Rodičia %1$s (%2$s) nevlastnej matky %3$s',
            'Parents %1$s (%2$s) of stepparent %3$s' => 'Rodičia %1$s (%2$s) nevlastného rodiča %3$s',
            'Parents %1$s of %2$s' => 'Rodičia %1$s osoby %2$s',
            'Parents %1$s (%2$s) of %3$s' => 'Rodičia %1$s (%2$s) osoby %3$s',
            'Partners of %s' => 'Partneri osoby %s',
            'Brother %1$s of partner %2$s' => 'Brat %1$s partnera %2$s',
            'Sister %1$s of partner %2$s' => 'Sestra %1$s partnera %2$s',
            'Sibling %1$s of partner %2$s' => 'Súrodenec %1$s partnera %2$s',

            'Great-grandparents' => 'Prastarí rodičia',
            '%s has no great-grandparents recorded.' => '%s nemá zaznamených žiadnych prarodičov.',
            '%s has one great-grandmother recorded.' => '%s má zaznamenanú jednu prastarú matku.',
            '%s has one great-grandfather recorded.' => '%s má zaznamenaného jedného prastarého otca.',
            '%s has one great-grandparent of unknown sex recorded.' => '%s má zaznamenaného jedného prastarého rodiča s neznámym pohlavím.',
            '%2$s has %1$d great-grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandmothers recorded.'
                => '%2$s má zaznamenanú %1$d prastarú matku.' . I18N::PLURAL . '%2$s má zaznamenané %1$d prastaré matky.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d prastarých matiek.',
            '%2$s has %1$d great-grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandfathers recorded.'
                => '%2$s má zaznamenaného %1$d prastarého otca.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d prastarých otcov.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d prastarých otcov.',
            '%2$s has %1$d great-grandparent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandparents of unknown sex recorded.'
                => '%2$s má zaznamenaného %1$d prastarého rodiča s neznámym pohlavím.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d prastarých rodičov s neznámym pohlavím.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d prastarých rodičov s neznámym pohlavím.',
            '%2$s has %1$d great-grandfather and ' . I18N::PLURAL . '%2$s has %1$d great-grandfathers and '
                => '%2$s má zaznamenaného %1$d prastarého otca a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d prastarých otcov a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d prastarých otcov a ',
            '%d great-grandmother recorded (%d in total).' . I18N::PLURAL . '%d great-grandmothers recorded (%d in total).'
                => '%d prastarú matku (spolu %d).' . I18N::PLURAL . '%d prastaré matky (spolu %d).' . I18N::PLURAL . '%d prastarých matiek (spolu %d).',
            '%2$s has %1$d great-grandmother and ' . I18N::PLURAL . '%2$s has %1$d great-grandmothers and '
                => '%2$s má zaznamenanú %1$d prastarú matku a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d prastaré matky a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d prastarých matiek a ',
            '%d great-grandparent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d great-grandparents of unknown sex recorded (%d in total).'
                => '%d prastarého rodiča s neznámym pohlavím (spolu %d).' . I18N::PLURAL . '%d prastarých rodičov s neznámym pohlavím (spolu %d).' . I18N::PLURAL . '%d prastarých rodičov s neznámym pohlavím (spolu %d).',
            '%2$s has %1$d great-grandfather, ' . I18N::PLURAL . '%2$s has %1$d great-grandfathers, '
                => '%2$s má zaznamenaného %1$d prastarého otca, ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d prastarých otcov, ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d prastarých otcov, ',
            '%d great-grandmother, and ' . I18N::PLURAL . '%d great-grandmothers, and '
                => '%d prastarú matku a ' . I18N::PLURAL . '%d prastaré matky a ' . I18N::PLURAL . '%d prastarých matiek a ',

            'Grandparents' => 'Starí rodičia',
            '%s has no grandparents recorded.' => '%s nemá zaznamenaných žiadnych starých rodičov.',
            '%s has one grandmother recorded.' => '%s má zaznamenanú jednu starú mamu.',
            '%s has one grandfather recorded.' => '%s má zaznamenaného jedného starého otca.',
            '%s has one grandparent of unknown sex recorded.' => '%s má zaznamenaného jedného starého rodiča s neznámym pohlavím.',
            '%2$s has %1$d grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d grandmothers recorded.'
                => '%2$s má zaznamenanú %1$d starú matku.' . I18N::PLURAL . '%2$s má zaznamenané %1$d staré matky.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d starých matiek.',
            '%2$s has %1$d grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d grandfathers recorded.'
                => '%2$s má zaznamenaného %1$d starého otca.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d starých otcov.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d starých otcov.',
            '%2$s has %1$d grandparent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandparents of unknown sex recorded.'
                => '%2$s má zaznamenaného %1$d starého rodiča s neznámym pohlavím.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d starých rodičov s neznámym pohlavím.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d starých rodičov s neznámym pohlavím.',
            '%2$s has %1$d grandfather and ' . I18N::PLURAL . '%2$s has %1$d grandfathers and '
                => '%2$s má zaznamenaného %1$d starého otca a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d starých otcov a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d starých otcov a ',
            '%d grandmother recorded (%d in total).' . I18N::PLURAL . '%d grandmothers recorded (%d in total).'
                => '%d starú matku (spolu %d).' . I18N::PLURAL . '%d staré matky (spolu %d).' . I18N::PLURAL . '%d starých matiek (spolu %d).',
            '%2$s has %1$d grandmother and ' . I18N::PLURAL . '%2$s has %1$d grandmothers and '
                => '%2$s má zaznamenanú %1$d starú matku a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d staré matky a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d starých matiek a ',
            '%d grandparent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandparents of unknown sex recorded (%d in total).'
                => '%d starého rodiča s neznámym pohlavím (spolu %d).' . I18N::PLURAL . '%d starých rodičov s neznámym pohlavím (spolu %d).' . I18N::PLURAL . '%d starých rodičov s neznámym pohlavím (spolu %d).',
            '%2$s has %1$d grandfather, ' . I18N::PLURAL . '%2$s has %1$d grandfathers, '
                => '%2$s má zaznamenaného %1$d starého otca, ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d starých otcov, ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d starých otcov, ',
            '%d grandmother, and ' . I18N::PLURAL . '%d grandmothers, and '
                => '%d starú matku a ' . I18N::PLURAL . '%d staré matky a ' . I18N::PLURAL . '%d starých matiek a ',

            'Uncles and Aunts' => 'Strýkovia a tety',
            '%s has no uncles or aunts recorded.' => '%s nemá zaznamenaného žiadneho strýka alebo tetu.',
            '%s has one aunt recorded.' => '%s má zaznamenanú jednu tetu.',
            '%s has one uncle recorded.' => '%s má zaznamenaného jedného strýka.',
            '%s has one uncle or aunt of unknown sex recorded.' => '%s má zaznamenaného jedného strýka alebo tetu s neznámym pohlavím.',
            '%2$s has %1$d aunt recorded.' . I18N::PLURAL . '%2$s has %1$d aunts recorded.'
                => '%2$s má zaznamenanú %1$d tetu.' . I18N::PLURAL . '%2$s má zaznamenané %1$d tety.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d tiet.',
            '%2$s has %1$d uncle recorded.' . I18N::PLURAL . '%2$s has %1$d uncles recorded.'
                => '%2$s má zaznamenaného %1$d strýka.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d strýkov.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d strýkov.',
            '%2$s has %1$d uncle or aunt of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d uncles or aunts of unknown sex recorded.'
                => '%2$s má zaznamenaného %1$d strýka alebo tetu s neznámym pohlavím.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d strýkov alebo tiet s neznámym pohlavím.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d strýkov alebo tiet s neznámym pohlavím.',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and '
                => '%2$s má zaznamenaného %1$d strýka a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d strýkov a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d strýkov a ',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).'
                => '%d tetu (spolu %d).' . I18N::PLURAL . '%d tety (spolu %d).' . I18N::PLURAL . '%d tiet (spolu %d).',
            '%2$s has %1$d aunt and ' . I18N::PLURAL . '%2$s has %1$d aunts and '
                => '%2$s má zaznamenanú %1$d tetu a ' . I18N::PLURAL . '%2$s má zaznamenanú %1$d tety a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d tiet a ',
            '%d uncle or aunt of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d uncles or aunts of unknown sex recorded (%d in total).'
                => '%d strýka alebo tetu s neznámym pohlavím (spolu %d).' . I18N::PLURAL . '%d strýkov alebo tiet s neznámym pohlavím (spolu %d).' . I18N::PLURAL . '%d strýkov alebo tiet s neznámym pohlavím (spolu %d).',
            '%2$s has %1$d uncle, ' . I18N::PLURAL . '%2$s has %1$d uncles, '
                => '%2$s má zaznamenaného %1$d strýka, ' . I18N::PLURAL . '%2$s má zaznamenaného %1$d strýkov, ' . I18N::PLURAL . '%2$s má zaznamenaného %1$d strýkov, ',
            '%d aunt, and ' . I18N::PLURAL . '%d aunts, and '
                => '%d tetu a ' . I18N::PLURAL . '%d tety a ' . I18N::PLURAL . '%d tiet a ',

            'Uncles and Aunts by marriage' => 'Strýkovia a tety získané sobášom',
            '%s has no uncles or aunts by marriage recorded.' => '%s nemá zaznamenaných žiadnych strýkov a tety získaných sobášom.',
            '%s has one aunt by marriage recorded.' => '%s má zaznamenanú jednu tetu získanú sobášom.',
            '%s has one uncle by marriage recorded.' => '%s má zaznamenaného jedého strýka získaného sobášom.',
            '%s has one uncle or aunt by marriage of unknown sex recorded.' => '%s má zaznamenaného jedného strýka alebo tetu získaných sobášom s neznámym pohlavím.',
            '%2$s has %1$d aunt by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d aunts by marriage recorded.'
                => '%2$s má zaznamenanú %1$d tetu získanú sobášom.' . I18N::PLURAL . '%2$s má zaznamenané %1$d tety získané sobášom.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d tiet získaných sobášom.',
            '%2$s has %1$d uncle by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d uncles by marriage recorded.'
                => '%2$s má zaznamenaného %1$d strýka získaného sobášom.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d strýkov získaných sobášom.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d strýkov získaných sobášom.',
            '%2$s has %1$d uncle or aunt by marriage of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d uncles or aunts by marriage of unknown sex recorded.'
                => '%2$s má zaznamenaného %1$d strýka alebo tetu získaných manželstvom s neznámym pohlavím.' . I18N::PLURAL . '%2$s má zaznamenaného %1$d strýkov alebo tiet získaných manželstvom s neznámym pohlavím.' . I18N::PLURAL . '%2$s má zaznamenaného %1$d strýkov alebo tiet získaných manželstvom s neznámym pohlavím.',
            '%2$s has %1$d uncle by marriage and ' . I18N::PLURAL . '%2$s has %1$d uncles by marriage and '
                => '%2$s má zaznamenaného %1$d strýka získaného manželstvom a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d strýkov získaných manželstvom a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d strýkov získaných manželstvom a ',
            '%d aunt by marriage recorded (%d in total).' . I18N::PLURAL . '%d aunts by marriage recorded (%d in total).'
                => '%d tetu získanú manželstvom (spolu %d).' . I18N::PLURAL . '%d tety získané manželstvom (spolu %d).' . I18N::PLURAL . '%d tiet získaných manželstvom (spolu %d).',
            '%2$s has %1$d aunt by marriage and ' . I18N::PLURAL . '%2$s has %1$d aunts by marriage and '
                => '%2$s má zaznamenanú %1$d tetu získanú manželstvom a ' . I18N::PLURAL . '%2$s má zaznamenané %1$d tety získané manželstvom a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d tiet získanývh manželstvom a ',
            '%d uncle or aunt by marriage of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d uncles or aunts by marriage of unknown sex recorded (%d in total).'
                => '%d strýka alebo tetu získaných sobášom s neznámym pohlavím (spolu %d).' . I18N::PLURAL . '%d strýkov alebo tiet získaných sobášom s neznámym pohlavím (spolu %d).' . I18N::PLURAL . '%d strýkov alebo tiet získaných sobášom s neznámym pohlavím (spolu %d).',
            '%2$s has %1$d uncle by marriage, ' . I18N::PLURAL . '%2$s has %1$d uncles by marriage, '
                => '%2$s má zaznamenaného %1$d strýka získaného sobášom, ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d strýkov získaných sobášom, ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d strýkov získaných sobášom, ',
            '%d aunt by marriage, and ' . I18N::PLURAL . '%d aunts by marriage, and '
                => '%d tetu získanú sobášom a ' . I18N::PLURAL . '%d tety získané sobášom a ' . I18N::PLURAL . '%d tiet získaných sobášom a ',

            'Parents' => 'Rodičia',
            '%s has no parents recorded.' => '%s nemá zaznamenaných žiadnych rodičov.',
            '%s has one mother recorded.' => '%s má zaznamenanú jednu matku.',
            '%s has one father recorded.' => '%s má zaznamenaného jedného otca.',
            '%s has one parent of unknown sex recorded.' => '%s má zaznamenaného jedného rodiča s neznámym pohlavím.',
            '%2$s has %1$d mother recorded.' . I18N::PLURAL . '%2$s has %1$d mothers recorded.'
                => '%2$s má zaznamenanú %1$d matku.' . I18N::PLURAL . '%2$s má zaznamenané %1$d matky.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d matiek.',
            '%2$s has %1$d father recorded.' . I18N::PLURAL . '%2$s has %1$d fathers recorded.'
                => '%2$s má zaznamenaného %1$d otca.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d otcov.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d otcov.',
            '%2$s has %1$d parent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d parents of unknown sex recorded.'
                => '%2$s má zaznamenaného %1$d rodiča s neznámym pohlavím.' . I18N::PLURAL . '%2$s má zaznamenaného %1$d rodičov s neznámym pohlavím.' . I18N::PLURAL . '%2$s má zaznamenaného %1$d rodičov s neznámym pohlavím.',
            '%2$s has %1$d father and ' . I18N::PLURAL . '%2$s has %1$d fathers and '
                => '%2$s má zaznamenaného %1$d otca a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d otcov a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d otcov a ',
            '%d mother recorded (%d in total).' . I18N::PLURAL . '%d mothers recorded (%d in total).'
                => '%d matku (spolu %d).' . I18N::PLURAL . '%d matky (spolu %d).' . I18N::PLURAL . '%d matiek (spolu %d).',
            '%d parent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d parents of unknown sex recorded (%d in total).'
                => '%d rodiča s neznámym pohlavím (spolu %d).' . I18N::PLURAL . '%d rodičov s neznámym pohlavím (spolu %d).' . I18N::PLURAL . '%d rodičov s neznámym pohlavím (spolu %d).',
            '%2$s has %1$d father, ' . I18N::PLURAL . '%2$s has %1$d fathers, '
                => '%2$s má zaznamenaného %1$d otca, ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d otcov, ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d otcov, ',
            '%d mother, and ' . I18N::PLURAL . '%d mothers, and '
                => '%d matku a ' . I18N::PLURAL . '%d matky a ' . I18N::PLURAL . '%d matiek a ',

            '%s has no siblings recorded.' => '%s nemá zaznamenaných žiadnych súrodencov.',
            '%s has one sister recorded.' => '%s má zaznamenanú jednu sestru.',
            '%s has one brother recorded.' => '%s má zaznamenaného jedného brata.',
            '%s has one brother or sister recorded.' => '%s má jedného súrodenca.',
            '%2$s has %1$d sister recorded.' . I18N::PLURAL . '%2$s has %1$d sisters recorded.'
                => '%2$s má zaznamenanú %1$d sestru.' . I18N::PLURAL . '%2$s má zaznamenané %1$d setry.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d sestier.',
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
            '%s has one nephew or niece recorded.' => '%s má zaznamenaného jedného synovca alebo jednu neter.',
            '%2$s has %1$d niece recorded.' . I18N::PLURAL . '%2$s has %1$d nieces recorded.'
                => '%2$s má zaznamenanú %1$d neter.' . I18N::PLURAL . '%2$s má zaznamenané %1$d netere.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d neterí.',
            '%2$s has %1$d nephew recorded.' . I18N::PLURAL . '%2$s has %1$d nephews recorded.'
                => '%2$s má zaznamenaného %1$d synovca.' . I18N::PLURAL . '%2$s má zaznamenaných %1$d synovcov.' . I18N::PLURAL . '%2$s zaznamenaných %1$d synovcov.',
            '%2$s has %1$d nephew and ' . I18N::PLURAL . '%2$s has %1$d nephews and '
                => '%2$s má zaznamenaného %1$d synovca a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d synovcov a ' . I18N::PLURAL . '%2$s má zaznamenaných %1$d synovcov a ',
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
            'Summary for the shown extended family' => 'Summary for the shown extended family',
            'The extended family of %1$s has one member.' . I18N::PLURAL . 'The extended family of %1$s has %2$d members.'
                => 'The extended family of %1$s has one member.' . I18N::PLURAL . 'The extended family of %1$s has %2$d members.',
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
            'Parents of stepparent' => 'Bố mẹ của bố mẹ kế',
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
            'Summary for the shown extended family' => 'Summary for the shown extended family',
            'The extended family of %1$s has one member.' . I18N::PLURAL . 'The extended family of %1$s has %2$d members.'
                => 'The extended family of %1$s has one member.' . I18N::PLURAL . 'The extended family of %1$s has %2$d members.',
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
     *
     * @return array
     */
    public static function chineseSimplifiedTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => '大家庭',
            'A tab showing the extended family of an individual.'=>'显示本人大家庭的选项卡。',
            'In which sequence should the parts of the extended family be shown?'=>'大家庭的各位部分应该按什么顺序显示？',
            'Family part'=>'家庭部分',
            'Show name of proband as short name or as full name?'=>'先证者的姓名是简称还是全名？',
            'Show options to filter the results (gender and alive/dead)?'=>'显示过滤结果的选项（性别和活/死）？',
            'Show filter options'=>'显示过滤器选项',
            'How should empty parts of extended family be presented?'=>'大家庭的空部分应该如何呈现？',
            'Show empty block'=>'显示空块',
            'yes, always at standard location'=>'是的，总是在标准地点',
            'no, but collect messages about empty blocks at the end'=>'没有，但是在最后收集关于空块的消息',
            'never'=>'从不',
            'The short name is based on the probands Rufname or nickname. If these are not available, the first of the given names is used, if one is given. Otherwise the last name is used.'=>'简称基于先证者的姓名或昵称。如果这些名称不可用，则使用给定名称中的第一位（如果给定）。否则将使用姓氏。',
            'Show short name'=>'显示短名称',
            'Show labels in special situations?'=>'在特殊情况下显示标签？',
            'Labels (or stickers) are used for example for adopted persons or foster children.'=>'标签（或贴纸）用于收养人或寄养儿童。',
            'Show labels'=>'显示标签',
            'Use the compact design?'=>'使用紧凑型设计？',
            'Use the compact design'=>'使用紧凑的设计',
            'The compact design only shows the name and life span for each person. The enriched design also shows a photo (if this is activated for this tree) as well as birth and death information.'=>'紧凑的设计只显示每位人的姓名和寿命。丰富的设计还显示了一张照片（如果这是为这棵树激活的）以及出生和死亡信息。',

            'don\t use this filter'=>'不要使用此筛选器',
            'show only male persons'=>'只显示男性',
            'show only female persons'=>'只显示女性',
            'show only persons of unknown gender'=>'只显示未知性别的人',
            'show only alive persons'=>'只显示活着的人',
            'show only dead persons'=>'只显示死人',
            'alive'=>'活着的',
            'dead'=>'死去的',
            'a dead person'=>'死人',
            'a living person'=>'活人',
            'not a male person'=>'不是男性',
            'not a female person'=>'不是女性',
            'not a person of unknown gender'=>'不是一位性别不明的人',

            'twin'=>'双胞胎',
            'triplet'=>'三胞胎',
            'quadruplet'=>'四胞胎',
            'quintuplet'=>'五胞胎',
            'sextuplet'=>'六胞胎',
            'septuplet'=>'七胞胎',
            'octuplet'=>'八胞胎',
            'nonuplet'=>'九胞胎',
            'decuplet'=>'十胞胎',
            'stillborn'=>'死胎',
            'died as infant'=>'在婴儿时期就去世了',
            'linkage challenged'=>'联系受到挑战',
            'linkage disproven'=>'连锁反证',
            'linkage proven'=>'链接已被证明',

            'Marriage'=>'婚内',
            'Ex-marriage'=>'前任',
            'Partnership'=>'婚姻关系',
            'Fiancée'=>'未婚妻',
            ' with '=>'：',
            'Biological parents of father'=>'父亲的亲生父母',
            'Biological parents of mother'=>'母亲的亲生父母',
            'Biological grandparents of father'=>'父亲的亲生祖父母',
            'Biological grandparents of mother'=>'母亲的亲生祖父母',
            'Biological parents of parent'=>'亲生父母',
            'Biological great-grandparents'=>'亲生曾祖父母',
            'Stepparents of father'=>'继父',
            'Stepparents of mother'=>'继母',
            'Stepparents of parent'=>'父母的继父母',
            'Parents of stepparent'=>'继父或继母的父母',
            'Siblings of father'=>'父亲的兄弟姐妹',
            'Siblings of mother'=>'母亲的兄弟姐妹',
            'Siblings-in-law of father'=>'父亲兄弟姐妹的配偶',
            'Siblings-in-law of mother'=>'母亲兄弟姐妹的配偶',
            'Biological parents'=>'亲生父母',
            'Stepparents'=>'继父母',
            'Parents-in-law of biological children'=>'亲生子女的岳父母\公婆',
            'Parents-in-law of stepchildren'=>'继子女的岳父母\公婆',
            'Full siblings'=>'兄弟姐妹',
            'Half siblings'=>'同父异母的兄弟姐妹',
            'Stepsiblings'=>'继兄弟姐妹',
            'Children of full siblings of father'=>'父亲的兄弟姐妹的子女',
            'Children of full siblings of mother'=>'母亲兄弟姐妹的子女',
            'Children of full siblings of parent'=>'父母的兄弟姐妹的子女',
            'Children of half siblings of father'=>'同父异母兄弟姐妹的子女',
            'Children of half siblings of mother'=>'母亲同父异母兄弟姐妹的子女',
            'Children of half siblings of parent'=>'同父异母兄弟姐妹的子女',
            'Siblings of partners'=>'配偶的兄弟姐妹',
            'Partners of siblings'=>'兄弟姐妹的配偶',
            'Siblings of siblings-in-law'=>'姐妹夫\姨子的兄弟姐妹',
            'Partners of siblings-in-law'=>'姊夫\叔子\姨子的配偶',
            'Children of siblings'=>'兄弟姐妹的子女',
            'Children of full siblings'=>'兄弟姐妹的子女',
            'Siblings\' stepchildren'=>'兄弟姐妹的继子女',
            'Children of siblings of partners'=>'配偶兄弟姐妹的子女',
            'Children of full siblings of biological parents' => '亲生父母的亲兄弟姐妹的子女',
            'Biological children'=>'亲生子女',
            'Stepchildren'=>'继子女',
            'Stepchild'=>'继子',
            'Stepson'=>'继子',
            'Stepdaughter'=>'继女',
            'Partners of biological children'=>'亲生子女的配偶',
            'Partners of biological grandchildren'=>'亲生孙辈的配偶',
            'Partners of stepchildren'=>'继子女的配偶',
            'Biological grandchildren'=>'亲生孙辈',
            'Stepchildren of children'=>'孩子的继子女',
            'Children of stepchildren'=>'继子女的子女',
            'Stepchildren of stepchildren'=>'继子女的继子女',
            'no blood relationship'=>'没有血缘关系',
            'relationship coefficient: %.1f'=>'血缘相关系数：%.1f',
            'generation +%s' => '辈份 +%s 辈 ',
            'generation %s' => '辈份 %s 辈 ',
            'same generation'=>'同辈人 ',

            'He'=>'他',
            'She'=>'她',
            'He/she'=>'他/她',
            'Mr.'=>'先生',
            'Mrs.'=>'夫人',
            'No family available'=>'没有家人',
            'Summary for the shown extended family'=>'所示大家庭的摘要',
            'The extended family of %1$s has one member.'. I18N::PLURAL .'The extended family of %1$s has %2$d members.'=>'%1$s的大家庭有%2$d位成员。',

            '%s has no %s recorded.'=>'%没有记录%s。',
            '%s has no %s, and no %s recorded.'=>'%s没有%s，也没有%s记录。',

            'Father\s family (%d)'=>'父亲的家庭（%d）',
            'Mother\s family (%d)'=>'母亲的家庭（%d）',
            'Father\s and Mother\'s family (%d)'=>'父亲和母亲的家庭（%d）',
            'Parents %1$s of %2$s'=>'家长%1$s（生%2$s）',
            'Parents %1$s (%2$s) of %3$s'=>'家长%1$s（%2$s）生%3$s',
            'Partners of %s'=>'%s配偶',
            'Brother %1$s of partner %2$s'=>'配偶%2$s的兄弟%1$s',
            'Sister %1$s of partner %2$s'=>'配偶%2$s的姐妹%1$s',
            'Sibling %1$s of partner %2$s'=>'配偶%2$s的兄弟%1$s',

            'Great-grandparents'  => '曾祖父辈',
            '%s has no great-grandparents recorded.'  => '%s没有曾祖父辈的记录。',
            '%s has one great-grandmother recorded.'  => '%s有一个曾祖母的记录。',
            '%s has one great-grandfather recorded.'  => '%s有一个曾祖父的记录。',
            '%s has one great-grandparent of unknown sex recorded.'  => '%s有一个曾祖辈的记录。',
            '%2$s has %1$d great-grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandmothers recorded.'  => '%s有%1$d个曾祖母的记录。',
            '%2$s has %1$d great-grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandfathers recorded.'  => '%s有%1$d个曾祖父的记录。',
            '%2$s has %1$d great-grandparent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandparents of unknown sex recorded.'  => '%s有%1$d个曾祖父辈的记录。',
            '%2$s has %1$d great-grandfather and ' . I18N::PLURAL . '%2$s has %1$d great-grandfathers and '  => '%2$s记录有%1$d个曾祖父和',
            '%d great-grandmother recorded (%d in total).' . I18N::PLURAL . '%d great-grandmothers recorded (%d in total).'  => '%d个曾祖母 (共%d位).',
            '%2$s has %1$d great-grandmother and ' . I18N::PLURAL . '%2$s has %1$d great-grandmothers and '  => '%2$s有%1$d位曾祖母和',
            '%d great-grandparent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d great-grandparents of unknown sex recorded (%d in total).'  => '%d位曾祖辈 (共%d位)',
            '%2$s has %1$d great-grandfather,' . I18N::PLURAL . '%2$s has %1$d great-grandfathers,'  => '%2$s有%1$d位曾祖父',
            '%d great-grandmother, and ' . I18N::PLURAL . '%d great-grandmothers, and '  => '%d位曾祖母和',

            'Grandparents'=>'祖父辈',
            'Biological grandparents'=>'亲生祖父母',
            '%s has no grandparents recorded.'=>'%s没有祖父母的记录。',
            '%s has one grandmother recorded.'=>'%s有一位祖母的记录。',
            '%s has one grandfather recorded.'=>'%s有一位祖父的记录。',
            '%s has one grandparent recorded.'=>'%s有一位祖父母的记录。',
            '%2$s has %1$d grandmother recorded. '. I18N::PLURAL .'%2$s has %1$d grandmothers recorded.'=>'%2$s有%1$d位祖母',
            '%2$s has %1$d grandfather recorded. '. I18N::PLURAL .'%2$s has %1$d grandfathers recorded.'=>'%2$s有%1$d位祖父',
            '%2$s has %1$d grandfather and '. I18N::PLURAL .'%2$s has %1$d grandfathers and '=>'%2$s有%1$d位祖父和',
            '%d grandmother recorded (%d in total).'. I18N::PLURAL .'%d grandmothers recorded (%d in total).'=>'%d位祖母（共%d位）。',

            'Uncles and Aunts'=>'叔父舅父姑妈和姨妈',
            'Full siblings of biological parents'=>'亲生父母的兄弟姐妹',
            '%s has no uncles or aunts recorded.'=>'%s没有记录叔父舅父姑妈或姨妈。',
            '%s has one aunt recorded.'=>'%s有一位姑妈(姨妈)的记录。',
            '%s has one uncle recorded.'=>'%s有一位叔(舅)父的记录。',
            '%s has one uncle or aunt recorded.'=>'%s有一位叔(舅)父或姑妈(姨妈)的记录。',
            '%2$s has %1$d aunt recorded.'. I18N::PLURAL .'%2$s has %1$d aunts recorded.'=>'%2$s有%1$d姑妈(姨妈)。',
            '%2$s has %1$d uncle recorded.'. I18N::PLURAL .'%2$s has %1$d uncles recorded.'=>'%2$s有%1$d位叔(舅)父。',
            '%2$s has %1$d uncle and '. I18N::PLURAL .'%2$s has %1$d uncles and '=>'%2$s有%1$d位叔(舅)父和',
            '%d aunt recorded (%d in total).'. I18N::PLURAL .'%d aunts recorded (%d in total).'=>'%d位姑妈(姨妈)（共%d位）。',

            'Uncles and Aunts by marriage'=>'姑父、姨父、婶婶或舅娘',
            '%s has no uncles or aunts by marriage recorded.'=>'%s没有记录姑父、姨父、婶婶或舅娘。',
            '%s has one aunt by marriage recorded.'=>'%s有一位婶婶或舅娘记录。',
            '%s has one uncle by marriage recorded.'=>'%s有一位姑父或姨父记录。',
            '%s has one uncle or aunt by marriage recorded.'=>'%s有一位姑父、姨父、婶婶或舅娘。',
            '%2$s has %1$d aunt by marriage recorded.'. I18N::PLURAL .'%2$s has %1$d aunts by marriage recorded.'=>'%2$s有%1$d位婶婶(舅娘)',
            '%2$s has %1$d uncle by marriage recorded.'. I18N::PLURAL .'%2$s has %1$d uncles by marriage recorded.'=>'%2$s有%1$d位姑父(姨父)。',
            '%2$s has %1$d uncle by marriage and '. I18N::PLURAL .'%2$s has %1$d uncles by marriage and '=>'%2$s有%1$d位姑父(姨父)和',
            '%d aunt by marriage recorded (%d in total).'. I18N::PLURAL .'%d aunts by marriage recorded (%d in total).'=>'%d位婶婶(舅娘)（共%d位）。',

            'Parents'=>'父亲母亲',
            '%s has no parents recorded.'=>'%s没有父母的记录。',
            '%s has one mother recorded.'=>'%s有一位母亲的记录。',
            '%s has one father recorded.'=>'%s有一位父亲的记录。',
            '%s has one parent recorded.'=>'%s有单亲记录。',
            '%2$s has %1$d mother recorded.'. I18N::PLURAL .'%2$s has %1$d mothers recorded.'=>'%2$s有%1$d位母亲',
            '%2$s has %1$d father recorded.'. I18N::PLURAL .'%2$s has %1$d fathers recorded.'=>'%2$s有%1$d位父亲',
            '%2$s has %1$d father and '. I18N::PLURAL .'%2$s has %1$d fathers and '=>'%2$s有%1$d位父亲和',
            '%d mother recorded (%d in total).'. I18N::PLURAL .'%d mothers recorded (%d in total).'=>'%d名母亲的记录（共%d位）。',

            'Parents-in-law'=>'岳父母（公婆）',
            '%s has no parents-in-law recorded.'=>'%s没有岳父母（公婆）的记录。',
            '%s has one mother-in-law recorded.'=>'%s有一位岳母（婆婆）的记录。',
            '%s has one father-in-law recorded.'=>'%s有一位岳父（公公）的记录。',
            '%s has one parent-in-law recorded.'=>'%s有一位岳父母（公婆）。',
            '%2$s has %1$d mother-in-law recorded. '. I18N::PLURAL .'%2$s has %1$d mothers-in-law recorded.'=>'%2$s有%1$d位岳母（婆婆）',
            '%2$s has %1$d father-in-law recorded. '. I18N::PLURAL .'%2$s has %1$d fathers-in-law recorded.'=>'%2$s有%1$d位岳父（公公）',
            '%2$s has %1$d father-in-law and '. I18N::PLURAL .'%2$s has %1$d fathers-in-law and '=>'%2$s有%1$d位岳父（公公）和',
            '%d mother-in-law recorded (%d in total).'. I18N::PLURAL .'%d mothers-in-law recorded (%d in total).'=>'%d位岳母（婆婆）的记录（共%d位）。',

            'Co-parents-in-law'=>'儿女亲家',
            '%s has no co-parents-in-law recorded.'=>'%s没有儿女亲家记录。',
            '%s has one co-mother-in-law recorded.'=>'%s有一位亲家母的记录。',
            '%s has one co-father-in-law recorded.'=>'%s有一位亲家公的记录。',
            '%s has one co-parent-in-law recorded.'=>'%s有一位儿女亲家记录。',
            '%2$s has %1$d co-mother-in-law recorded. '. I18N::PLURAL .'%2$s has %1$d co-mothers-in-law recorded.'=>'%2$s有%1$d位亲家母',
            '%2$s has %1$d co-father-in-law recorded. '. I18N::PLURAL .'%2$s has %1$d co-fathers-in-law recorded.'=>'%2$s有%1$d位亲家公',
            '%2$s has %1$d co-father-in-law and '. I18N::PLURAL .'%2$s has %1$d co-fathers-in-law and '=>'%2$s有%1$d位亲家公和',
            '%d co-mother-in-law recorded (%d in total).'. I18N::PLURAL .'%d co-mothers-in-law recorded (%d in total).'=>'%d位亲家母（共%d）。',

            'Siblings'=>'兄弟姐妹',
            '%s has no siblings recorded.'=>'%s没有兄弟姐妹的记录。',
            '%s has one sister recorded.'=>'%s有一位姐妹的记录。',
            '%s has one brother recorded.'=>'%s有一位兄弟的记录。',
            '%s has one brother or sister recorded.'=>'%s有一个兄弟姐妹的记录。',
            '%2$s has %1$d sister recorded.'. I18N::PLURAL .'%2$s has %1$d sisters recorded.'=>'%2$s有%1$d位姐妹',
            '%2$s has %1$d brother recorded.'. I18N::PLURAL .'%2$s has %1$d brothers recorded.'=>'%2$s有%1$d位兄弟',
            '%2$s has %1$d brother and '. I18N::PLURAL .'%2$s has %1$d brothers and '=>'%2$s有%1$d位兄弟和',
            '%d sister recorded (%d in total).'. I18N::PLURAL .'%d sisters recorded (%d in total).'=>'%d位姐妹的记录（共%d位）',

            'Siblings-in-law'=>'姐(妹)夫\叔子\嫂子\弟媳\舅子\姨子',
            '%s has no siblings-in-law recorded.'=>'%s没有嫂子(姑姐妹\弟媳\姨子)。',
            '%s has one sister-in-law recorded.'=>'%s有一位嫂子(姑姐妹\弟媳\姨子)。',
            '%s has one brother-in-law recorded.'=>'%s有一位姐(妹)夫或舅子的记录。',
            '%s has one sibling-in-law recorded.'=>'%s有一个子妹配偶的记录。',
            '%2$s has %1$d sister-in-law recorded.'. I18N::PLURAL .'%2$s has %1$d sisters-in-law recorded.'=>'%2$s有%1$d位嫂子(姑姐妹\弟媳\姨子)',
            '%2$s has %1$d brother-in-law recorded.'. I18N::PLURAL .'%2$s has %1$d brothers-in-law recorded.'=>'%2$s有%1$d位姐夫(妹夫\叔子\舅子)',
            '%2$s has %1$d brother-in-law and '. I18N::PLURAL .'%2$s has %1$d brothers-in-law and '=>'%2$s有%1$d位姐夫(妹夫\叔子\舅子)和',
            '%d sister-in-law recorded (%d in total).'. I18N::PLURAL .'%d sisters-in-law recorded (%d in total).'=>'%d位嫂子(姑姐妹\弟媳\姨子)（共%d位）',

            'Co-siblings-in-law'=>'姻亲：舅母子\妯娌\连襟\姊夫',
            '%s has no co-siblings-in-law recorded.'=>'%s没有妯娌、连襟、姊夫记录。',
            '%s has one co-sister-in-law recorded.'=>'%s有一位舅母子\妯娌记录。',
            '%s has one co-brother-in-law recorded.'=>'%s有一位连襟\姊兄弟记录。',
            '%s has one co-sibling-in-law recorded.'=>'%s有一位舅母子\妯娌\连襟\姊夫记录。',
            '%2$s has %1$d co-sister-in-law recorded.'. I18N::PLURAL .'%2$s has %1$d co-sisters-in-law recorded.'=>'%2$s有%1$d位舅母子\妯娌',
            '%2$s has %1$d co-brother-in-law recorded.'. I18N::PLURAL .'%2$s has %1$d co-brothers-in-law recorded.'=>'%2$s有%1$d位连襟\姊夫',
            '%2$s has %1$d co-brother-in-law and '. I18N::PLURAL .'%2$s has %1$d co-brothers-in-law and '=>'%2$s有%1$d位连襟\姊夫和',
            '%d co-sister-in-law recorded (%d in total).'. I18N::PLURAL .'%d co-sisters-in-law recorded (%d in total).'=>'%d名舅母子\妯娌（共%d位）',

            'Partners'=>'配偶',
            'Partner of '=>'配偶：',
            '%s has no partners recorded.'=>'%s没有配偶的记录。',
            '%s has one female partner recorded.'=>'%s有一位妻子。',
            '%s has one male partner recorded.'=>'%s有一名丈夫。',
            '%s has one partner recorded.'=>'%s有一位配偶。',
            '%2$s has %1$d female partner recorded.'. I18N::PLURAL .'%2$s has %1$d female partners recorded.'=>'%2$s有%1$d位配偶',
            '%2$s has %1$d male partner recorded.'. I18N::PLURAL .'%2$s has %1$d male partners recorded.'=>'%2$s有%1$d位配偶',
            '%2$s has %1$d male partner and '. I18N::PLURAL .'%2$s has %1$d male partners and '=>'%2$s有%1$d名丈夫和',
            '%2$s has %1$d female partner and '. I18N::PLURAL .'%2$s has %1$d female partners and '=>'%2$s有%1$d名妻子和',
            '%d female partner recorded (%d in total).'. I18N::PLURAL .'%d female partners recorded (%d in total).'=>'%d位配偶（共%d位）',
            '%d male partner recorded (%d in total).'. I18N::PLURAL .'%d male partners recorded (%d in total).'=>'%d位配偶（共%d位）',
            '%d male partner of female partners recorded (%d in total).' . I18N::PLURAL . '%d male partners of female partners recorded (%d in total).'=> '%d位妻子的配偶(共%d位)',
            '%d female partner of male partners recorded (%d in total).' . I18N::PLURAL . '%d female partners of male partners recorded (%d in total).'=> '%d位丈夫的配偶(共%d位)',

            'Partner chains'=>'配偶系列',
            '%s has no members of a partner chain recorded.'=>'%s没有记录配偶链的成员。',
            'There are %d branches in the partner chain. '=>'配偶链中有%d位分支。',
            'The longest branch in the partner chain to %2$s consists of %1$d partners (including %3$s).'=>'%2$s配偶链中最长的分支由%1$d位配偶（包括%3$s）组成。',
            'The longest branch in the partner chain consists of %1$d partners (including %2$s).'=>'配偶链中最长的分支由%1$d位配偶（包括%2$s）组成。',
            '%d female partner in this partner chain recorded (%d in total). '. I18N::PLURAL .'%d female partners in this partner chain recorded (%d in total).'=>'%此配偶链中有d名女性配偶（%d总计）',

            'Cousins'=>'堂表亲',
            '%s has no first cousins recorded.'=>'%s没有表亲记录',
            '%s has one female first cousin recorded.'=>'%s有一位堂表姐妹的记录。',
            '%s has one male first cousin recorded.'=>'%s有一位堂表兄弟的记录。',
            '%s has one first cousin recorded.'=>'%s有一位堂表亲的记录。',
            '%2$s has %1$d female first cousin recorded.'. I18N::PLURAL .'%2$s has %1$d female first cousins recorded.'=>'%2$s有%1$d位堂表姐妹。',
            '%2$s has %1$d male first cousin recorded.'. I18N::PLURAL .'%2$s has %1$d male first cousins recorded.'=>'%2$s有%1$d位堂表兄弟',
            '%2$s has %1$d male first cousin and '. I18N::PLURAL .'%2$s has %1$d male first cousins and '=>'%2$s有%1$d位堂表兄弟和',
            '%d female first cousin recorded (%d in total).'. I18N::PLURAL .'%d female first cousins recorded (%d in total).'=>'%d位堂表姐妹（共%d位）。',

            'Nephews and Nieces'=>'侄子和侄女',
            '%s has no nephews or nieces recorded.'=>'%s没有侄子或侄女的记录。',
            '%s has one niece recorded.'=>'%s有一位侄女的记录。',
            '%s has one nephew recorded.'=>'%s有一位侄子的记录。',
            '%s has one nephew or niece recorded.'=>'%s有一位侄子或侄女的记录。',
            '%2$s has %1$d niece recorded. '. I18N::PLURAL .'%2$s has %1$d nieces recorded.'=>'%2$s有%1$d位侄女',
            '%2$s has %1$d nephew recorded. '. I18N::PLURAL .'%2$s has %1$d nephews recorded.'=>'%2$s有%1$d位侄子',
            '%2$s has %1$d nephew and '. I18N::PLURAL .'%2$s has %1$d nephews and '=>'%2$s有%1$d位侄子和',
            '%d niece recorded (%d in total).'. I18N::PLURAL .'%d nieces recorded (%d in total).'=>'%d位侄女记录（共%d位）',

            'Children'=>'子女',
            '%s has no children recorded.'=>'%s没有子女的记录。',
            '%s has one daughter recorded.'=>'%s有一个女儿。',
            '%s has one son recorded.'=>'%s有一个儿子的记录。',
            '%s has one child recorded.'=>'%s有一个子女。',
            '%2$s has %1$d daughter recorded.'. I18N::PLURAL .'%2$s has %1$d daughters recorded.'=>'%2$s有%1$d个女儿',
            '%2$s has %1$d son recorded.'. I18N::PLURAL .'%2$s has %1$d sons recorded.'=>'%2$s有%1$d个儿子',
            '%2$s has %1$d son and '. I18N::PLURAL .'%2$s has %1$d sons and '=>'%2$s有%1$d个儿子和',
            '%d daughter recorded (%d in total).'. I18N::PLURAL .'%d daughters recorded (%d in total).'=>'%d个女儿（共%d位）。',

            'Children-in-law'=>'儿媳和女婿',
            '%s has no children-in-law recorded.'=>'%s没有儿媳和女婿记录。',
            '%s has one daughter-in-law recorded.'=>'%s有一个儿媳的记录。',
            '%s has one son-in-law recorded.'=>'%s有一个女婿的记录。',
            '%s has one child-in-law recorded.'=>'%s有一个儿媳或女婿的记录。',
            '%2$s has %1$d daughter-in-law recorded.'. I18N::PLURAL .'%2$s has %1$d daughters-in-law recorded.'=>'%2$s有%1$d位儿媳',
            '%2$s has %1$d son-in-law recorded.'. I18N::PLURAL .'%2$s has %1$d sons-in-law recorded.'=>'%2$s有%1$d位女婿记录',
            '%2$s has %1$d son-in-law and '. I18N::PLURAL .'%2$s has %1$d sons-in-law and '=>'%2$s有%1$d位女婿和',
            '%d daughter-in-law recorded (%d in total).'. I18N::PLURAL .'%d daughters-in-law recorded (%d in total).'=>'%d位儿媳（共%d位）。',

            'Grandchildren'=>'孙辈',
            '%s has no grandchildren recorded.'=>'%s没有孙辈的记录。',
            '%s has one granddaughter recorded.'=>'%s有一个孙女。',
            '%s has one grandson recorded.'=>'%s有一个孙子。',
            '%s has one grandchild recorded.'=>'%s有一位孙辈的记录。',
            '%2$s has %1$d granddaughter recorded.'. I18N::PLURAL .'%2$s has %1$d granddaughters recorded.'=>'%2$s有%1$d位孙女',
            '%2$s has %1$d grandson recorded.'. I18N::PLURAL .'%2$s has %1$d grandsons recorded.'=>'%2$s有%1$d位孙子',
            '%2$s has %1$d grandson and '. I18N::PLURAL .'%2$s has %1$d grandsons and '=>'%2$s有%1$d位孙子和',
            '%d granddaughter recorded (%d in total).'. I18N::PLURAL .'%d granddaughters recorded (%d in total).'=>'%d位孙女记录（共%d位）',

            'Grandchildren-in-law' => '孙媳妇和孙女婿',
            '%s has no grandchildren-in-law recorded.' => '%s没有孙媳妇和孙女婿的记录。',
            '%s has one granddaughter-in-law recorded.' => '%s有一位孙媳妇',
            '%s has one grandson-in-law recorded.' => '%s有一位孙女婿',
            '%s has one grandchild-in-law of unknown sex recorded.' => '%s有一位孙辈的配偶',
            '%2$s has %1$d granddaughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters-in-law recorded.'
            => '%2$s有%1$d位孙媳妇',
            '%2$s has %1$d grandson-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons-in-law recorded.'
            => '%2$s有%1$d位孙女婿',
            '%2$s has %1$d grandchild-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandchildren-in-law of unknown sex recorded.'
            => '%s有%1$d位孙辈的配偶',
            '%2$s has %1$d grandson-in-law and ' . I18N::PLURAL . '%2$s has %1$d grandsons-in-law and '
            => '%2$s有%1$d位孙女婿和',
            '%d granddaughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d granddaughters-in-law recorded (%d in total).'
            => '%d位孙媳妇（共%d位）',
            '%2$s has %1$d granddaughter-in-law and ' . I18N::PLURAL . '%2$s has %1$d granddaughters-in-law and '
            => '%2$s有%1$d位孙媳妇和',
            '%d grandchild-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandchildren-in-law of unknown sex recorded (%d in total).'
            => '%d位孙辈的配偶（共%d位）。',
        ];
    }

    /**
     *
     * @return array
     */
    public static function chineseTraditionalTranslations(): array
    {
        // Note the special characters used in plural and context-sensitive translations.
        return [
            'Extended family' => '大家庭',
            'A tab showing the extended family of an individual.' => '顯示本人大家庭的選項卡。',
            'In which sequence should the parts of the extended family be shown?' => '大家庭的各位部分應該按什麽順序顯示？',
            'Family part' => '家庭部分',
            'Show name of proband as short name or as full name?' => '先證者的姓名是簡稱還是全名？',
            'Show options to filter the results (gender and alive/dead)?' => '顯示過濾結果的選項（性別和活/死）？',
            'Show filter options' => '顯示過濾器選項',
            'How should empty parts of extended family be presented?' => '大家庭的空部分應該如何呈現？',
            'Show empty block' => '顯示空塊',
            'yes, always at standard location' => '是的，總是在標準地點',
            'no, but collect messages about empty blocks at the end' => '沒有，但是在最後收集關於空塊的消息',
            'never' => '從不',
            'The short name is based on the probands Rufname or nickname. If these are not available, the first of the given names is used, if one is given. Otherwise the last name is used.' => '簡稱基於先證者的姓名或昵稱。如果這些名稱不可用，則使用給定名稱中的第一位（如果給定）。否則將使用姓氏。',
            'Show short name' => '顯示短名稱',
            'Show labels in special situations?' => '在特殊情況下顯示標簽？',
            'Labels (or stickers) are used for example for adopted persons or foster children.' => '標簽（或貼紙）用於收養人或寄養兒童。',
            'Show labels' => '顯示標簽',
            'Use the compact design?' => '使用緊湊型設計？',
            'Use the compact design' => '使用緊湊的設計',
            'The compact design only shows the name and life span for each person. The enriched design also shows a photo (if this is activated for this tree) as well as birth and death information.' => '緊湊的設計只顯示每位人的姓名和壽命。豐富的設計還顯示了一張照片（如果這是為這棵樹激活的）以及出生和死亡信息。',

            'don\t use this filter' => '不要使用此篩選器',
            'show only male persons' => '只顯示男性',
            'show only female persons' => '只顯示女性',
            'show only persons of unknown gender' => '只顯示未知性別的人',
            'show only alive persons' => '只顯示活著的人',
            'show only dead persons' => '只顯示死人',
            'alive' => '活著的',
            'dead' => '死去的',
            'a dead person' => '死人',
            'a living person' => '活人',
            'not a male person' => '不是男性',
            'not a female person' => '不是女性',
            'not a person of unknown gender' => '不是一位性別不明的人',

            'twin' => '雙胞胎',
            'triplet' => '三胞胎',
            'quadruplet' => '四胞胎',
            'quintuplet' => '五胞胎',
            'sextuplet' => '六胞胎',
            'septuplet' => '七胞胎',
            'octuplet' => '八胞胎',
            'nonuplet' => '九胞胎',
            'decuplet' => '十胞胎',
            'stillborn' => '死胎',
            'died as infant' => '在嬰兒時期就去世了',
            'linkage challenged' => '聯系受到挑戰',
            'linkage disproven' => '連鎖反證',
            'linkage proven' => '鏈接已被證明',

            'Marriage' => '婚內',
            'Ex-marriage' => '前任',
            'Partnership' => '婚姻關系',
            'Fiancée' => '未婚妻',
            ' with ' => '：',
            'Biological parents of father' => '父親的親生父母',
            'Biological parents of mother' => '母親的親生父母',
            'Biological grandparents of father' => '父親的親生祖父母',
            'Biological grandparents of mother' => '母親的親生祖父母',
            'Biological parents of parent' => '親生父母',
            'Biological great-grandparents' => '親生曾祖父母',
            'Stepparents of father' => '繼父',
            'Stepparents of mother' => '繼母',
            'Stepparents of parent' => '父母的繼父母',
            'Parents of stepparent' => '繼父或繼母的父母',
            'Siblings of father' => '父親的兄弟姐妹',
            'Siblings of mother' => '母親的兄弟姐妹',
            'Siblings-in-law of father' => '父親兄弟姐妹的配偶',
            'Siblings-in-law of mother' => '母親兄弟姐妹的配偶',
            'Biological parents' => '親生父母',
            'Stepparents' => '繼父母',
            'Parents-in-law of biological children' => '親生子女的嶽父母\公婆',
            'Parents-in-law of stepchildren' => '繼子女的嶽父母\公婆',
            'Full siblings' => '兄弟姐妹',
            'Half siblings' => '同父異母的兄弟姐妹',
            'Stepsiblings' => '繼兄弟姐妹',
            'Children of full siblings of father' => '父親的兄弟姐妹的子女',
            'Children of full siblings of mother' => '母親兄弟姐妹的子女',
            'Children of full siblings of parent' => '父母的兄弟姐妹的子女',
            'Children of half siblings of father' => '同父異母兄弟姐妹的子女',
            'Children of half siblings of mother' => '母親同父異母兄弟姐妹的子女',
            'Children of half siblings of parent' => '同父異母兄弟姐妹的子女',
            'Siblings of partners' => '配偶的兄弟姐妹',
            'Partners of siblings' => '兄弟姐妹的配偶',
            'Siblings of siblings-in-law' => '姐妹夫\姨子的兄弟姐妹',
            'Partners of siblings-in-law' => '姊夫\叔子\姨子的配偶',
            'Children of siblings' => '兄弟姐妹的子女',
            'Children of full siblings' => '兄弟姐妹的子女',
            'Siblings\' stepchildren' => '兄弟姐妹的繼子女',
            'Children of siblings of partners' => '配偶兄弟姐妹的子女',
            'Children of full siblings of biological parents' => '親生父母的親兄弟姐妹的子女',
            'Biological children' => '親生子女',
            'Stepchildren' => '繼子女',
            'Stepchild' => '繼子',
            'Stepson' => '繼子',
            'Stepdaughter' => '繼女',
            'Partners of biological children' => '親生子女的配偶',
            'Partners of biological grandchildren' => '親生孫輩的配偶',
            'Partners of stepchildren' => '繼子女的配偶',
            'Biological grandchildren' => '親生孫輩',
            'Stepchildren of children' => '孩子的繼子女',
            'Children of stepchildren' => '繼子女的子女',
            'Stepchildren of stepchildren' => '繼子女的繼子女',
            'no blood relationship' => '沒有血緣關系',
            'relationship coefficient: %.1f' => '血緣相關系數：%.1f',
            'generation +%s' => '輩份 +%s 輩 ',
            'generation %s' => '輩份 %s 輩 ',
            'same generation' => '同輩人 ',

            'He' => '他',
            'She' => '她',
            'He/she' => '他/她',
            'Mr.' => '先生',
            'Mrs.' => '夫人',
            'No family available' => '沒有家人',
            'Summary for the shown extended family' => '所示大家庭的摘要',
            'The extended family of %1$s has one member.' . I18N::PLURAL . 'The extended family of %1$s has %2$d members.' => '%1$s的大家庭有%2$d位成員。',

            '%s has no %s recorded.' => '%沒有記錄%s。',
            '%s has no %s, and no %s recorded.' => '%s沒有%s，也沒有%s記錄。',

            'Father\s family (%d)' => '父親的家庭（%d）',
            'Mother\s family (%d)' => '母親的家庭（%d）',
            'Father\s and Mother\'s family (%d)' => '父親和母親的家庭（%d）',
            'Parents %1$s of %2$s' => '家長%1$s（生%2$s）',
            'Parents %1$s (%2$s) of %3$s' => '家長%1$s（%2$s）生%3$s',
            'Partners of %s' => '%s配偶',
            'Brother %1$s of partner %2$s' => '配偶%2$s的兄弟%1$s',
            'Sister %1$s of partner %2$s' => '配偶%2$s的姐妹%1$s',
            'Sibling %1$s of partner %2$s' => '配偶%2$s的兄弟%1$s',

            'Great-grandparents' => '曾祖父輩',
            '%s has no great-grandparents recorded.' => '%s沒有曾祖父輩的記錄。',
            '%s has one great-grandmother recorded.' => '%s有一個曾祖母的記錄。',
            '%s has one great-grandfather recorded.' => '%s有一個曾祖父的記錄。',
            '%s has one great-grandparent of unknown sex recorded.' => '%s有一個曾祖輩的記錄。',
            '%2$s has %1$d great-grandmother recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandmothers recorded.' => '%s有%1$d個曾祖母的記錄。',
            '%2$s has %1$d great-grandfather recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandfathers recorded.' => '%s有%1$d個曾祖父的記錄。',
            '%2$s has %1$d great-grandparent of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d great-grandparents of unknown sex recorded.' => '%s有%1$d個曾祖父輩的記錄。',
            '%2$s has %1$d great-grandfather and ' . I18N::PLURAL . '%2$s has %1$d great-grandfathers and ' => '%2$s記錄有%1$d個曾祖父和',
            '%d great-grandmother recorded (%d in total).' . I18N::PLURAL . '%d great-grandmothers recorded (%d in total).' => '%d個曾祖母 (共%d位).',
            '%2$s has %1$d great-grandmother and ' . I18N::PLURAL . '%2$s has %1$d great-grandmothers and ' => '%2$s有%1$d位曾祖母和',
            '%d great-grandparent of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d great-grandparents of unknown sex recorded (%d in total).' => '%d位曾祖輩 (共%d位)',
            '%2$s has %1$d great-grandfather,' . I18N::PLURAL . '%2$s has %1$d great-grandfathers,' => '%2$s有%1$d位曾祖父',
            '%d great-grandmother, and ' . I18N::PLURAL . '%d great-grandmothers, and ' => '%d位曾祖母和',

            'Grandparents' => '祖父輩',
            'Biological grandparents' => '親生祖父母',
            '%s has no grandparents recorded.' => '%s沒有祖父母的記錄。',
            '%s has one grandmother recorded.' => '%s有一位祖母的記錄。',
            '%s has one grandfather recorded.' => '%s有一位祖父的記錄。',
            '%s has one grandparent recorded.' => '%s有一位祖父母的記錄。',
            '%2$s has %1$d grandmother recorded. ' . I18N::PLURAL . '%2$s has %1$d grandmothers recorded.' => '%2$s有%1$d位祖母',
            '%2$s has %1$d grandfather recorded. ' . I18N::PLURAL . '%2$s has %1$d grandfathers recorded.' => '%2$s有%1$d位祖父',
            '%2$s has %1$d grandfather and ' . I18N::PLURAL . '%2$s has %1$d grandfathers and ' => '%2$s有%1$d位祖父和',
            '%d grandmother recorded (%d in total).' . I18N::PLURAL . '%d grandmothers recorded (%d in total).' => '%d位祖母（共%d位）。',

            'Uncles and Aunts' => '叔父舅父姑媽和姨媽',
            'Full siblings of biological parents' => '親生父母的兄弟姐妹',
            '%s has no uncles or aunts recorded.' => '%s沒有記錄叔父舅父姑媽或姨媽。',
            '%s has one aunt recorded.' => '%s有一位姑媽(姨媽)的記錄。',
            '%s has one uncle recorded.' => '%s有一位叔(舅)父的記錄。',
            '%s has one uncle or aunt recorded.' => '%s有一位叔(舅)父或姑媽(姨媽)的記錄。',
            '%2$s has %1$d aunt recorded.' . I18N::PLURAL . '%2$s has %1$d aunts recorded.' => '%2$s有%1$d姑媽(姨媽)。',
            '%2$s has %1$d uncle recorded.' . I18N::PLURAL . '%2$s has %1$d uncles recorded.' => '%2$s有%1$d位叔(舅)父。',
            '%2$s has %1$d uncle and ' . I18N::PLURAL . '%2$s has %1$d uncles and ' => '%2$s有%1$d位叔(舅)父和',
            '%d aunt recorded (%d in total).' . I18N::PLURAL . '%d aunts recorded (%d in total).' => '%d位姑媽(姨媽)（共%d位）。',

            'Uncles and Aunts by marriage' => '姑父、姨父、嬸嬸或舅娘',
            '%s has no uncles or aunts by marriage recorded.' => '%s沒有記錄姑父、姨父、嬸嬸或舅娘。',
            '%s has one aunt by marriage recorded.' => '%s有一位嬸嬸或舅娘記錄。',
            '%s has one uncle by marriage recorded.' => '%s有一位姑父或姨父記錄。',
            '%s has one uncle or aunt by marriage recorded.' => '%s有一位姑父、姨父、嬸嬸或舅娘。',
            '%2$s has %1$d aunt by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d aunts by marriage recorded.' => '%2$s有%1$d位嬸嬸(舅娘)',
            '%2$s has %1$d uncle by marriage recorded.' . I18N::PLURAL . '%2$s has %1$d uncles by marriage recorded.' => '%2$s有%1$d位姑父(姨父)。',
            '%2$s has %1$d uncle by marriage and ' . I18N::PLURAL . '%2$s has %1$d uncles by marriage and ' => '%2$s有%1$d位姑父(姨父)和',
            '%d aunt by marriage recorded (%d in total).' . I18N::PLURAL . '%d aunts by marriage recorded (%d in total).' => '%d位嬸嬸(舅娘)（共%d位）。',

            'Parents' => '父親母親',
            '%s has no parents recorded.' => '%s沒有父母的記錄。',
            '%s has one mother recorded.' => '%s有一位母親的記錄。',
            '%s has one father recorded.' => '%s有一位父親的記錄。',
            '%s has one parent recorded.' => '%s有單親記錄。',
            '%2$s has %1$d mother recorded.' . I18N::PLURAL . '%2$s has %1$d mothers recorded.' => '%2$s有%1$d位母親',
            '%2$s has %1$d father recorded.' . I18N::PLURAL . '%2$s has %1$d fathers recorded.' => '%2$s有%1$d位父親',
            '%2$s has %1$d father and ' . I18N::PLURAL . '%2$s has %1$d fathers and ' => '%2$s有%1$d位父親和',
            '%d mother recorded (%d in total).' . I18N::PLURAL . '%d mothers recorded (%d in total).' => '%d名母親的記錄（共%d位）。',

            'Parents-in-law' => '嶽父母（公婆）',
            '%s has no parents-in-law recorded.' => '%s沒有嶽父母（公婆）的記錄。',
            '%s has one mother-in-law recorded.' => '%s有一位嶽母（婆婆）的記錄。',
            '%s has one father-in-law recorded.' => '%s有一位嶽父（公公）的記錄。',
            '%s has one parent-in-law recorded.' => '%s有一位嶽父母（公婆）。',
            '%2$s has %1$d mother-in-law recorded. ' . I18N::PLURAL . '%2$s has %1$d mothers-in-law recorded.' => '%2$s有%1$d位嶽母（婆婆）',
            '%2$s has %1$d father-in-law recorded. ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law recorded.' => '%2$s有%1$d位嶽父（公公）',
            '%2$s has %1$d father-in-law and ' . I18N::PLURAL . '%2$s has %1$d fathers-in-law and ' => '%2$s有%1$d位嶽父（公公）和',
            '%d mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d mothers-in-law recorded (%d in total).' => '%d位嶽母（婆婆）的記錄（共%d位）。',

            'Co-parents-in-law' => '兒女親家',
            '%s has no co-parents-in-law recorded.' => '%s沒有兒女親家記錄。',
            '%s has one co-mother-in-law recorded.' => '%s有一位親家母的記錄。',
            '%s has one co-father-in-law recorded.' => '%s有一位親家公的記錄。',
            '%s has one co-parent-in-law recorded.' => '%s有一位兒女親家記錄。',
            '%2$s has %1$d co-mother-in-law recorded. ' . I18N::PLURAL . '%2$s has %1$d co-mothers-in-law recorded.' => '%2$s有%1$d位親家母',
            '%2$s has %1$d co-father-in-law recorded. ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law recorded.' => '%2$s有%1$d位親家公',
            '%2$s has %1$d co-father-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-fathers-in-law and ' => '%2$s有%1$d位親家公和',
            '%d co-mother-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-mothers-in-law recorded (%d in total).' => '%d位親家母（共%d）。',

            'Siblings' => '兄弟姐妹',
            '%s has no siblings recorded.' => '%s沒有兄弟姐妹的記錄。',
            '%s has one sister recorded.' => '%s有一位姐妹的記錄。',
            '%s has one brother recorded.' => '%s有一位兄弟的記錄。',
            '%s has one brother or sister recorded.' => '%s有一個兄弟姐妹的記錄。',
            '%2$s has %1$d sister recorded.' . I18N::PLURAL . '%2$s has %1$d sisters recorded.' => '%2$s有%1$d位姐妹',
            '%2$s has %1$d brother recorded.' . I18N::PLURAL . '%2$s has %1$d brothers recorded.' => '%2$s有%1$d位兄弟',
            '%2$s has %1$d brother and ' . I18N::PLURAL . '%2$s has %1$d brothers and ' => '%2$s有%1$d位兄弟和',
            '%d sister recorded (%d in total).' . I18N::PLURAL . '%d sisters recorded (%d in total).' => '%d位姐妹的記錄（共%d位）',

            'Siblings-in-law' => '姐(妹)夫\叔子\嫂子\弟媳\舅子\姨子',
            '%s has no siblings-in-law recorded.' => '%s沒有嫂子(姑姐妹\弟媳\姨子)。',
            '%s has one sister-in-law recorded.' => '%s有一位嫂子(姑姐妹\弟媳\姨子)。',
            '%s has one brother-in-law recorded.' => '%s有一位姐(妹)夫或舅子的記錄。',
            '%s has one sibling-in-law recorded.' => '%s有一個子妹配偶的記錄。',
            '%2$s has %1$d sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sisters-in-law recorded.' => '%2$s有%1$d位嫂子(姑姐妹\弟媳\姨子)',
            '%2$s has %1$d brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d brothers-in-law recorded.' => '%2$s有%1$d位姐夫(妹夫\叔子\舅子)',
            '%2$s has %1$d brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d brothers-in-law and ' => '%2$s有%1$d位姐夫(妹夫\叔子\舅子)和',
            '%d sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d sisters-in-law recorded (%d in total).' => '%d位嫂子(姑姐妹\弟媳\姨子)（共%d位）',

            'Co-siblings-in-law' => '姻親：舅母子\妯娌\連襟\姊夫',
            '%s has no co-siblings-in-law recorded.' => '%s沒有妯娌、連襟、姊夫記錄。',
            '%s has one co-sister-in-law recorded.' => '%s有一位舅母子\妯娌記錄。',
            '%s has one co-brother-in-law recorded.' => '%s有一位連襟\姊兄弟記錄。',
            '%s has one co-sibling-in-law recorded.' => '%s有一位舅母子\妯娌\連襟\姊夫記錄。',
            '%2$s has %1$d co-sister-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-sisters-in-law recorded.' => '%2$s有%1$d位舅母子\妯娌',
            '%2$s has %1$d co-brother-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law recorded.' => '%2$s有%1$d位連襟\姊夫',
            '%2$s has %1$d co-brother-in-law and ' . I18N::PLURAL . '%2$s has %1$d co-brothers-in-law and ' => '%2$s有%1$d位連襟\姊夫和',
            '%d co-sister-in-law recorded (%d in total).' . I18N::PLURAL . '%d co-sisters-in-law recorded (%d in total).' => '%d名舅母子\妯娌（共%d位）',

            'Partners' => '配偶',
            'Partner of ' => '配偶：',
            '%s has no partners recorded.' => '%s沒有配偶的記錄。',
            '%s has one female partner recorded.' => '%s有一位妻子。',
            '%s has one male partner recorded.' => '%s有一名丈夫。',
            '%s has one partner recorded.' => '%s有一位配偶。',
            '%2$s has %1$d female partner recorded.' . I18N::PLURAL . '%2$s has %1$d female partners recorded.' => '%2$s有%1$d位配偶',
            '%2$s has %1$d male partner recorded.' . I18N::PLURAL . '%2$s has %1$d male partners recorded.' => '%2$s有%1$d位配偶',
            '%2$s has %1$d male partner and ' . I18N::PLURAL . '%2$s has %1$d male partners and ' => '%2$s有%1$d名丈夫和',
            '%2$s has %1$d female partner and ' . I18N::PLURAL . '%2$s has %1$d female partners and ' => '%2$s有%1$d名妻子和',
            '%d female partner recorded (%d in total).' . I18N::PLURAL . '%d female partners recorded (%d in total).' => '%d位配偶（共%d位）',
            '%d male partner recorded (%d in total).' . I18N::PLURAL . '%d male partners recorded (%d in total).' => '%d位配偶（共%d位）',
            '%d male partner of female partners recorded (%d in total).' . I18N::PLURAL . '%d male partners of female partners recorded (%d in total).' => '%d位妻子的配偶(共%d位)',
            '%d female partner of male partners recorded (%d in total).' . I18N::PLURAL . '%d female partners of male partners recorded (%d in total).' => '%d位丈夫的配偶(共%d位)',

            'Partner chains' => '配偶系列',
            '%s has no members of a partner chain recorded.' => '%s沒有記錄配偶鏈的成員。',
            'There are %d branches in the partner chain. ' => '配偶鏈中有%d位分支。',
            'The longest branch in the partner chain to %2$s consists of %1$d partners (including %3$s).' => '%2$s配偶鏈中最長的分支由%1$d位配偶（包括%3$s）組成。',
            'The longest branch in the partner chain consists of %1$d partners (including %2$s).' => '配偶鏈中最長的分支由%1$d位配偶（包括%2$s）組成。',
            '%d female partner in this partner chain recorded (%d in total). ' . I18N::PLURAL . '%d female partners in this partner chain recorded (%d in total).' => '%此配偶鏈中有d名女性配偶（%d總計）',

            'Cousins' => '堂表親',
            '%s has no first cousins recorded.' => '%s沒有表親記錄',
            '%s has one female first cousin recorded.' => '%s有一位堂表姐妹的記錄。',
            '%s has one male first cousin recorded.' => '%s有一位堂表兄弟的記錄。',
            '%s has one first cousin recorded.' => '%s有一位堂表親的記錄。',
            '%2$s has %1$d female first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d female first cousins recorded.' => '%2$s有%1$d位堂表姐妹。',
            '%2$s has %1$d male first cousin recorded.' . I18N::PLURAL . '%2$s has %1$d male first cousins recorded.' => '%2$s有%1$d位堂表兄弟',
            '%2$s has %1$d male first cousin and ' . I18N::PLURAL . '%2$s has %1$d male first cousins and ' => '%2$s有%1$d位堂表兄弟和',
            '%d female first cousin recorded (%d in total).' . I18N::PLURAL . '%d female first cousins recorded (%d in total).' => '%d位堂表姐妹（共%d位）。',

            'Nephews and Nieces' => '侄子和侄女',
            '%s has no nephews or nieces recorded.' => '%s沒有侄子或侄女的記錄。',
            '%s has one niece recorded.' => '%s有一位侄女的記錄。',
            '%s has one nephew recorded.' => '%s有一位侄子的記錄。',
            '%s has one nephew or niece recorded.' => '%s有一位侄子或侄女的記錄。',
            '%2$s has %1$d niece recorded. ' . I18N::PLURAL . '%2$s has %1$d nieces recorded.' => '%2$s有%1$d位侄女',
            '%2$s has %1$d nephew recorded. ' . I18N::PLURAL . '%2$s has %1$d nephews recorded.' => '%2$s有%1$d位侄子',
            '%2$s has %1$d nephew and ' . I18N::PLURAL . '%2$s has %1$d nephews and ' => '%2$s有%1$d位侄子和',
            '%d niece recorded (%d in total).' . I18N::PLURAL . '%d nieces recorded (%d in total).' => '%d位侄女記錄（共%d位）',

            'Children' => '子女',
            '%s has no children recorded.' => '%s沒有子女的記錄。',
            '%s has one daughter recorded.' => '%s有一個女兒。',
            '%s has one son recorded.' => '%s有一個兒子的記錄。',
            '%s has one child recorded.' => '%s有一個子女。',
            '%2$s has %1$d daughter recorded.' . I18N::PLURAL . '%2$s has %1$d daughters recorded.' => '%2$s有%1$d個女兒',
            '%2$s has %1$d son recorded.' . I18N::PLURAL . '%2$s has %1$d sons recorded.' => '%2$s有%1$d個兒子',
            '%2$s has %1$d son and ' . I18N::PLURAL . '%2$s has %1$d sons and ' => '%2$s有%1$d個兒子和',
            '%d daughter recorded (%d in total).' . I18N::PLURAL . '%d daughters recorded (%d in total).' => '%d個女兒（共%d位）。',

            'Children-in-law' => '兒媳和女婿',
            '%s has no children-in-law recorded.' => '%s沒有兒媳和女婿記錄。',
            '%s has one daughter-in-law recorded.' => '%s有一個兒媳的記錄。',
            '%s has one son-in-law recorded.' => '%s有一個女婿的記錄。',
            '%s has one child-in-law recorded.' => '%s有一個兒媳或女婿的記錄。',
            '%2$s has %1$d daughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d daughters-in-law recorded.' => '%2$s有%1$d位兒媳',
            '%2$s has %1$d son-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d sons-in-law recorded.' => '%2$s有%1$d位女婿記錄',
            '%2$s has %1$d son-in-law and ' . I18N::PLURAL . '%2$s has %1$d sons-in-law and ' => '%2$s有%1$d位女婿和',
            '%d daughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d daughters-in-law recorded (%d in total).' => '%d位兒媳（共%d位）。',

            'Grandchildren' => '孫輩',
            '%s has no grandchildren recorded.' => '%s沒有孫輩的記錄。',
            '%s has one granddaughter recorded.' => '%s有一個孫女。',
            '%s has one grandson recorded.' => '%s有一個孫子。',
            '%s has one grandchild recorded.' => '%s有一位孫輩的記錄。',
            '%2$s has %1$d granddaughter recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters recorded.' => '%2$s有%1$d位孫女',
            '%2$s has %1$d grandson recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons recorded.' => '%2$s有%1$d位孫子',
            '%2$s has %1$d grandson and ' . I18N::PLURAL . '%2$s has %1$d grandsons and ' => '%2$s有%1$d位孫子和',
            '%d granddaughter recorded (%d in total).' . I18N::PLURAL . '%d granddaughters recorded (%d in total).' => '%d位孫女記錄（共%d位）',

            'Grandchildren-in-law' => '孫媳婦和孫女婿',
            '%s has no grandchildren-in-law recorded.' => '%s沒有孫媳婦和孫女婿的記錄。',
            '%s has one granddaughter-in-law recorded.' => '%s有一位孫媳婦',
            '%s has one grandson-in-law recorded.' => '%s有一位孫女婿',
            '%s has one grandchild-in-law of unknown sex recorded.' => '%s有一位孫輩的配偶',
            '%2$s has %1$d granddaughter-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d granddaughters-in-law recorded.'
            => '%2$s有%1$d位孫媳婦',
            '%2$s has %1$d grandson-in-law recorded.' . I18N::PLURAL . '%2$s has %1$d grandsons-in-law recorded.'
            => '%2$s有%1$d位孫女婿',
            '%2$s has %1$d grandchild-in-law of unknown sex recorded.' . I18N::PLURAL . '%2$s has %1$d grandchildren-in-law of unknown sex recorded.'
            => '%s有%1$d位孫輩的配偶',
            '%2$s has %1$d grandson-in-law and ' . I18N::PLURAL . '%2$s has %1$d grandsons-in-law and '
            => '%2$s有%1$d位孫女婿和',
            '%d granddaughter-in-law recorded (%d in total).' . I18N::PLURAL . '%d granddaughters-in-law recorded (%d in total).'
            => '%d位孫媳婦（共%d位）',
            '%2$s has %1$d granddaughter-in-law and ' . I18N::PLURAL . '%2$s has %1$d granddaughters-in-law and '
            => '%2$s有%1$d位孫媳婦和',
            '%d grandchild-in-law of unknown sex recorded (%d in total).' . I18N::PLURAL . '%d grandchildren-in-law of unknown sex recorded (%d in total).'
            => '%d位孫輩的配偶（共%d位）。',
        ];
    }
}
