/**
 * Совместимость ACF Pro 6.3.11 с iframe-канвой блочного редактора WordPress 7.x.
 *
 * Поля типа WYSIWYG внутри ACF-блока падали с ошибкой
 *   TypeError: Cannot read properties of undefined (reading 'buttons')
 *       at Object.buildQuicktags (acf-input.min.js)
 * и редактор показывал «Этот блок содержит ошибку и не может быть просмотрен».
 *
 * Причина: разметка поля живёт внутри <iframe name="editor-canvas">, а ACF зовёт
 * глобальный quicktags() из верхнего документа. Там элемента нет, ядро возвращает
 * «пустой» объект без свойства settings, проверка ACF `if (!instance) return`
 * его не ловит, и следующая строка читает settings.buttons у undefined.
 *
 * Ниже quicktags() возвращает false, если textarea не найдена в этом документе, —
 * это ACF обрабатывает штатно и просто пропускает панель быстрых тегов.
 * Визуальный редактор (TinyMCE) и вкладка «Текст» продолжают работать.
 *
 * Снять шим можно после обновления ACF Pro до версии с поддержкой iframe-канвы
 * (docs/BACKLOG.md, B-27).
 */
( function ( w ) {
	'use strict';

	if ( typeof w.quicktags !== 'function' || w.quicktags.nvIframeSafe ) {
		return;
	}

	var original = w.quicktags;

	function safeQuicktags( settings ) {
		if ( ! settings || ! settings.id || ! w.document.getElementById( settings.id ) ) {
			return false;
		}

		return original.apply( this, arguments );
	}

	safeQuicktags.nvIframeSafe = true;

	// Переносим собственные свойства ядра (например, quicktags.instances).
	Object.keys( original ).forEach( function ( key ) {
		safeQuicktags[ key ] = original[ key ];
	} );

	w.quicktags = safeQuicktags;
}( window ) );
