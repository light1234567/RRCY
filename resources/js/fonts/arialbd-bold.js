﻿import { jsPDF } from "jspdf"
var callAddFont = function () {
this.addFileToVFS('arialbd-bold.ttf', font);
this.addFont('arialbd-bold.ttf', 'arialbd', 'bold');
};
jsPDF.API.events.push(['addFonts', callAddFont])