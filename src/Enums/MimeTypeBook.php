<?php

namespace Koderak\FileManager\Enums;

enum MimeTypeBook: string
{
    case APPLICATION_PDF =  'application/pdf';
    case APPLICATION_MSWORD =  'application/msword';
    case APPLICATION_EXCEL =  'application/excel';
    case APPLICATION_X_EXCEL =  'application/x-excel';
    case APPLICATION_X_MSEXCEL =  'application/x-msexcel';
    case APPLICATION_VND_MS_EXCEL =  'application/vnd.ms-excel';
    case APPLICATION_MSPOWERPOINT =  'application/mspowerpoint';
    case APPLICATION_VND_MS_POWERPOINT =  'application/vnd.ms-powerpoint';
    case APPLICATION_POWERPOINT =  'application/powerpoint';
    case APPLICATION_X_MSPOWERPOINT =  'application/x-mspowerpoint';
    case TEXT_XML =  'text/xml';
    case APPLICATION_XML =  'application/xml';
    case APPLICATION_POSTSCRIPT =  'application/postscript';
    case CHEMICAL_X_PDB =  'chemical/x-pdb';
    case TEXT_PLAIN =  'text/plain';
    case APPLICATION_X_NEWTON_COMPATIBLE_PKG =  'application/x-newton-compatible-pkg';
    case APPLICATION_INF =  'application/inf';
    case APPLICATION_VND_OPENXMLFORMATS_OFFICEDOCUMENT_WORDPROCESSINGML_DOCUMENT =  'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
    case APPLICATION_VND_OPENXMLFORMATS_OFFICEDOCUMENT_WORDPROCESSINGML_TEMPLATE =  'application/vnd.openxmlformats-officedocument.wordprocessingml.template';
    case APPLICATION_VND_MS_WORD_DOCUMENT_MACROENABLED_12 =  'application/vnd.ms-word.document.macroEnabled.12';
    case APPLICATION_VND_OPENXMLFORMATS_OFFICEDOCUMENT_SPREADSHEETML_SHEET =  'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
    case APPLICATION_VND_OPENXMLFORMATS_OFFICEDOCUMENT_SPREADSHEETML_TEMPLATE =  'application/vnd.openxmlformats-officedocument.spreadsheetml.template';
    case APPLICATION_VND_MS_EXCEL_SHEET_MACROENABLED_12 =  'application/vnd.ms-excel.sheet.macroEnabled.12';
    case APPLICATION_VND_MS_EXCEL_TEMPLATE_MACROENABLED_12 =  'application/vnd.ms-excel.template.macroEnabled.12';
    case APPLICATION_VND_MS_EXCEL_ADDIN_MACROENABLED_12 =  'application/vnd.ms-excel.addin.macroEnabled.12';
    case APPLICATION_VND_MS_EXCEL_SHEET_BINARY_MACROENABLED_12 =  'application/vnd.ms-excel.sheet.binary.macroEnabled.12';
    case APPLICATION_VND_OPENXMLFORMATS_OFFICEDOCUMENT_PRESENTATIONML_PRESENTATION =  'application/vnd.openxmlformats-officedocument.presentationml.presentation';
    case APPLICATION_VND_OPENXMLFORMATS_OFFICEDOCUMENT_PRESENTATIONML_TEMPLATE =  'application/vnd.openxmlformats-officedocument.presentationml.template';
    case APPLICATION_VND_OPENXMLFORMATS_OFFICEDOCUMENT_PRESENTATIONML_SLIDESHOW =  'application/vnd.openxmlformats-officedocument.presentationml.slideshow';
    case APPLICATION_VND_MS_POWERPOINT_PRESENTATION_MACROENABLED_12 =  'application/vnd.ms-powerpoint.presentation.macroEnabled.12';
    case APPLICATION_VND_MS_POWERPOINT_TEMPLATE_MACROENABLED_12 =  'application/vnd.ms-powerpoint.template.macroEnabled.12';
    case APPLICATION_VND_MS_POWERPOINT_SLIDESHOW_MACROENABLED_12 = 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12';
}
