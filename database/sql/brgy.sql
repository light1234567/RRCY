
-- Revised MySQL dump with only the barangays of Region 11

-- Table structure for table `tbl_brgy`
DROP TABLE IF EXISTS `tbl_brgy`;
CREATE TABLE `tbl_brgy` (
  `psgc` varchar(20) NOT NULL,
  `col_brgy` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`psgc`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table `tbl_brgy`
LOCK TABLES `tbl_brgy` WRITE;
INSERT INTO `tbl_brgy` VALUES 
('112301004', 'Binancian'),
('112301006', 'Buan'),
('112301007', 'Buclad'),
('112301008', 'Cabaywa'),
('112301009', 'Camansa'),
('112301010', 'Camoning'),
('112301011', 'Canatan'),
('112301012', 'Concepcion'),
('112301013', 'Doña Andrea'),
('112301026', 'Magatos'),
('112301028', 'Napungas'),
('112301029', 'New Bantayan'),
('112301030', 'New Santiago'),
('112301031', 'Pamacaun'),
('112301032', 'Cambanogoy (Pob.)'),
('112301034', 'Sagayen'),
('112301036', 'San Vicente'),
('112301037', 'Santa Filomena'),
('112301039', 'Sonlon'),
('112301040', 'New Loon'),
('112303001', 'Alejal'),
('112303002', 'Anibongan'),
('112303003', 'Asuncion (Cuatro-Cuatro)'),
('112303005', 'Cebulano'),
('112303006', 'Guadalupe'),
('112303007', 'Ising (Pob.)'),
('112303008', 'La Paz'),
('112303010', 'Mabaus'),
('112303011', 'Mabuhay'),
('112303012', 'Magsaysay'),
('112303014', 'Mangalcal'),
('112303015', 'Minda'),
('112303016', 'New Camiling'),
('112303018', 'San Isidro'),
('112303019', 'Santo Niño'),
('112303020', 'Tibulao'),
('112303021', 'Tubod'),
('112303022', 'Tuganay'),
('112303023', 'Salvacion'),
('112303024', 'Taba'),
('112305003', 'Semong'),
('112305005', 'Florida'),
('112305006', 'Gabuyan'),
('112305007', 'Gupitan'),
('112305008', 'Capungagan'),
('112305009', 'Katipunan'),
('112305012', 'Luna'),
('112305013', 'Mabantao'),
('112305015', 'Mamacao'),
('112305018', 'Pag-asa'),
('112305021', 'Maniki (Poblacion)'),
('112305022', 'Sampao'),
('112305026', 'Sua-on'),
('112305028', 'Tiburcia'),
('112314001', 'Cabidianan'),
('112314002', 'Carcor'),
('112314003', 'Del Monte'),
('112314004', 'Del Pilar'),
('112314005', 'El Salvador'),
('112314006', 'Limba-an'),
('112314007', 'Macgum'),
('112314008', 'Mambing'),
('112314009', 'Mesaoy'),
('112314010', 'New Bohol'),
('112314011', 'New Cortez'),
('112314012', 'New Sambog'),
('112314013', 'Patrocenio'),
('112314014', 'Poblacion'),
('112314015', 'San Roque'),
('112314016', 'Santa Cruz'),
('112314017', 'Santa Fe'),
('112314018', 'Santo Niño'),
('112314019', 'Suawon'),
('112314020', 'San Jose'),
('112315001', 'A. O. Floirendo'),
('112315002', 'Datu Abdul Dadia'),
('112315003', 'Buenavista'),
('112315004', 'Cacao'),
('112315005', 'Cagangohan'),
('112315006', 'Consolacion'),
('112315007', 'Dapco'),
('112315009', 'Gredu (Pob.)'),
('112315010', 'J.P. Laurel'),
('112315011', 'Kasilak'),
('112315012', 'Katipunan'),
('112315013', 'Katualan'),
('112315014', 'Kauswagan'),
('112315015', 'Kiotoy'),
('112315016', 'Little Panay'),
('112315017', 'Lower Panaga (Roxas)'),
('112315018', 'Mabunao'),
('112315019', 'Maduao'),
('112315020', 'Malativas'),
('112315021', 'Manay'),
('112315022', 'Nanyo'),
('112315023', 'New Malaga (Dalisay)'),
('112315024', 'New Malitbog'),
('112315025', 'New Pandan (Pob.)'),
('112315026', 'New Visayas'),
('112315027', 'Quezon'),
('112315028', 'Salvacion'),
('112315029', 'San Francisco (Pob.)'),
('112315030', 'San Nicolas'),
('112315031', 'San Roque'),
('112315032', 'San Vicente'),
('112315033', 'Santa Cruz'),
('112315034', 'Santo Niño (Pob.)'),
('112315035', 'Sindaton'),
('112315036', 'Southern Davao'),
('112315037', 'Tagpore'),
('112315038', 'Tibungol'),
('112315039', 'Upper Licanan'),
('112315040', 'Waterfall'),
('112315041', 'San Pedro'),
('112317001', 'Adecor'),
('112317002', 'Anonang'),
('112317003', 'Aumbay'),
('112317004', 'Aundanao'),
('112317005', 'Balet'),
('112317006', 'Bandera'),
('112317007', 'Caliclic (Dangca-an)'),
('112317008', 'Camudmud'),
('112317009', 'Catagman'),
('112317010', 'Cawag'),
('112317011', 'Cogon'),
('112317012', 'Cogon (Talicod)'),
('112317013', 'Dadatan'),
('112317014', 'Del Monte'),
('112317015', 'Guilon'),
('112317016', 'Kanaan'),
('112317017', 'Kinawitnon'),
('112317018', 'Libertad'),
('112317019', 'Libuak'),
('112317020', 'Licup'),
('112317021', 'Limao'),
('112317022', 'Linosutan'),
('112317023', 'Mambago-A'),
('112317024', 'Mambago-B'),
('112317025', 'Miranda (Pob.)'),
('112317026', 'Moncado (Pob.)'),
('112317027', 'Pangubatan (Talicod I)'),
('112317028', 'Peñaplata (Pob.)'),
('112317029', 'Poblacion (Kaputian)'),
('112317030', 'San Agustin'),
('112317031', 'San Antonio'),
('112317032', 'San Isidro (Babak)'),
('112317033', 'San Isidro (Kaputian)'),
('112317034', 'San Jose (San Lapuz)'),
('112317035', 'San Miguel (Magamono)'),
('112317036', 'San Remigio'),
('112317037', 'Santa Cruz (Talicod II)'),
('112317038', 'Santo Niño'),
('112317039', 'Sion (Zion)'),
('112317040', 'Tagbaobo'),
('112317041', 'Tagbay'),
('112317042', 'Tagbitan-ag'),
('112317043', 'Tagdaliao'),
('112317044', 'Tagpopongan'),
('112317045', 'Tambo'),
('112317046', 'Toril'),
('112318001', 'Balagunan'),
('112318002', 'Bobongon'),
('112318003', 'Esperanza'),
('112318004', 'Kimamon'),
('112318005', 'Kinamayan'),
('112318006', 'La Libertad'),
('112318007', 'Lungaog'),
('112318008', 'Magwawa'),
('112318009', 'New Katipunan'),
('112318010', 'Pantaron'),
('112318011', 'Tibal-og (Pob.)'),
('112318013', 'San Jose'),
('112318014', 'San Miguel'),
('112318015', 'Talomo'),
('112318016', 'Casig-Ang'),
('112318017', 'New Visayas'),
('112318018', 'Salvacion'),
('112318019', 'San Vicente'),
('112318020', 'Tulalian'),
('112319001', 'Apokon'),
('112319003', 'Bincungan'),
('112319004', 'Busaon'),
('112319005', 'Canocotan'),
('112319006', 'Cuambogan'),
('112319007', 'La Filipina'),
('112319008', 'Liboganon'),
('112319009', 'Madaum'),
('112319010', 'Magdum'),
('112319011', 'Mankilam'),
('112319012', 'New Balamban'),
('112319013', 'Nueva Fuerza'),
('112319014', 'Pagsabangan'),
('112319015', 'Pandapan'),
('112319016', 'Magugpo Poblacion'),
('112319018', 'San Agustin'),
('112319019', 'San Isidro'),
('112319020', 'San Miguel (Camp 4)'),
('112319022', 'Visayan Village'),
('112319023', 'Magugpo East'),
('112319024', 'Magugpo North'),
('112319025', 'Magugpo South'),
('112319026', 'Magugpo West'),
('112322001', 'Dagohoy'),
('112322002', 'Palma Gil'),
('112322003', 'Santo Niño'),
('112323001', 'Cabay-Angan'),
('112323002', 'Dujali'),
('112323003', 'Magupising'),
('112323004', 'New Casay'),
('112323005', 'Tanglaw'),
('112324001', 'Dacudao'),
('112324002', 'Datu Balong'),
('112324003', 'Igangon'),
('112324004', 'Kipalili'),
('112324005', 'Libuton'),
('112324006', 'Linao'),
('112324007', 'Mamangan'),
('112324008', 'Monte Dujali'),
('112324009', 'Pinamuno'),
('112324010', 'Sabangan'),
('112324011', 'San Miguel'),
('112324012', 'Santo Niño'),
('112324013', 'Sawata'),
('112401001', 'Alegre'),
('112401002', 'Alta Vista'),
('112401003', 'Anonang'),
('112401004', 'Bitaug'),
('112401005', 'Bonifacio'),
('112401006', 'Buenavista'),
('112401007', 'Darapuay'),
('112401008', 'Dolo'),
('112401009', 'Eman'),
('112401010', 'Kinuskusan'),
('112401011', 'Libertad'),
('112401012', 'Linawan'),
('112401013', 'Mabuhay'),
('112401014', 'Mabunga'),
('112401015', 'Managa'),
('112401016', 'Marber'),
('112401017', 'New Clarin (Miral)'),
('112401018', 'Poblacion'),
('112401019', 'Rizal'),
('112401020', 'Santo Niño'),
('112401021', 'Sibayan'),
('112401022', 'Tinongtongan'),
('112401023', 'Tubod'),
('112401024', 'Union'),
('112401025', 'Poblacion Dos'),
('112402001', 'Acacia'),
('112402002', 'Agdao'),
('112402003', 'Alambre'),
('112402004', 'Atan-Awe'),
('112402005', 'Bago Gallera'),
('112402006', 'Bago Oshiro'),
('112402007', 'Baguio (Pob.)'),
('112402009', 'Balengaeng'),
('112402010', 'Baliok'),
('112402012', 'Bangkas Heights'),
('112402013', 'Baracatan'),
('112402014', 'Bato'),
('112402015', 'Bayabas'),
('112402016', 'Biao Escuela'),
('112402017', 'Biao Guianga'),
('112402018', 'Biao Joaquin'),
('112402019', 'Binugao'),
('112402020', 'Bucana'),
('112402021', 'Buhangin (Pob.)'),
('112402022', 'Bunawan (Pob.)'),
('112402023', 'Cabantian'),
('112402024', 'Cadalian'),
('112402026', 'Calinan (Pob.)'),
('112402027', 'Callawa'),
('112402028', 'Camansi'),
('112402029', 'Carmen'),
('112402030', 'Catalunan Grande'),
('112402031', 'Catalunan Pequeño'),
('112402032', 'Catigan'),
('112402033', 'Cawayan'),
('112402034', 'Colosas'),
('112402035', 'Communal'),
('112402036', 'Crossing Bayabas'),
('112402037', 'Dacudao'),
('112402038', 'Dalag'),
('112402039', 'Dalagdag'),
('112402040', 'Daliao'),
('112402041', 'Daliaon Plantation'),
('112402042', 'Dominga'),
('112402043', 'Dumoy'),
('112402044', 'Eden'),
('112402045', 'Fatima (Benowang)'),
('112402047', 'Gatungan'),
('112402048', 'Gumalang'),
('112402049', 'Ilang'),
('112402050', 'Indangan'),
('112402051', 'Kilate'),
('112402052', 'Lacson'),
('112402053', 'Lamanan'),
('112402054', 'Lampianao'),
('112402055', 'Langub'),
('112402056', 'Alejandra Navarro (Lasang)'),
('112402057', 'Lizada'),
('112402058', 'Los Amigos'),
('112402059', 'Lubogan'),
('112402060', 'Lumiad'),
('112402061', 'Ma-a'),
('112402062', 'Mabuhay'),
('112402063', 'Magtuod'),
('112402064', 'Mahayag'),
('112402065', 'Malabog'),
('112402066', 'Malagos'),
('112402067', 'Malamba'),
('112402068', 'Manambulan'),
('112402069', 'Mandug'),
('112402070', 'Manuel Guianga'),
('112402071', 'Mapula'),
('112402072', 'Marapangi'),
('112402073', 'Marilog'),
('112402074', 'Matina Aplaya'),
('112402075', 'Matina Crossing'),
('112402077', 'Matina Pangi'),
('112402078', 'Matina Biao'),
('112402079', 'Mintal'),
('112402080', 'Mudiang'),
('112402081', 'Mulig'),
('112402082', 'New Carmen'),
('112402083', 'New Valencia'),
('112402086', 'Pampanga'),
('112402087', 'Panacan'),
('112402088', 'Panalum'),
('112402089', 'Pandaitan'),
('112402090', 'Pangyan'),
('112402091', 'Paquibato (Pob.)'),
('112402092', 'Paradise Embak'),
('112402097', 'Riverside'),
('112402098', 'Salapawan'),
('112402099', 'Salaysay'),
('112402100', 'San Isidro (Licanan)'),
('112402101', 'Sasa'),
('112402102', 'Sibulan'),
('112402104', 'Sirawan'),
('112402105', 'Sirib'),
('112402106', 'Suawan (Tuli)'),
('112402107', 'Subasta'),
('112402108', 'Sumimao'),
('112402110', 'Tacunan'),
('112402112', 'Tagakpan'),
('112402113', 'Tagluno'),
('112402114', 'Tagurano'),
('112402115', 'Talandang'),
('112402116', 'Talomo (Pob.)'),
('112402117', 'Talomo River'),
('112402118', 'Tamayong'),
('112402119', 'Tambobong'),
('112402120', 'Tamugan'),
('112402121', 'Tapak'),
('112402122', 'Tawan-tawan'),
('112402123', 'Tibuloy'),
('112402124', 'Tibungco'),
('112402125', 'Tigatto'),
('112402126', 'Toril (Pob.)'),
('112402127', 'Tugbok (Pob.)'),
('112402128', 'Tungakalan'),
('112402129', 'Ula'),
('112402131', 'Wangan'),
('112402133', 'Wines'),
('112402134', 'Barangay 1-A (Pob.)'),
('112402135', 'Barangay 2-A (Pob.)'),
('112402136', 'Barangay 3-A (Pob.)'),
('112402137', 'Barangay 4-A (Pob.)'),
('112402138', 'Barangay 5-A (Pob.)'),
('112402139', 'Barangay 6-A (Pob.)'),
('112402140', 'Barangay 7-A (Pob.)'),
('112402141', 'Barangay 8-A (Pob.)'),
('112402142', 'Barangay 9-A (Pob.)'),
('112402143', 'Barangay 10-A (Pob.)'),
('112402144', 'Barangay 11-B (Pob.)'),
('112402145', 'Barangay 12-B (Pob.)'),
('112402146', 'Barangay 13-B (Pob.)'),
('112402147', 'Barangay 14-B (Pob.)'),
('112402148', 'Barangay 15-B (Pob.)'),
('112402149', 'Barangay 16-B (Pob.)'),
('112402150', 'Barangay 17-B (Pob.)'),
('112402151', 'Barangay 18-B (Pob.)'),
('112402152', 'Barangay 19-B (Pob.)'),
('112402153', 'Barangay 20-B (Pob.)'),
('112402154', 'Barangay 21-C (Pob.)'),
('112402155', 'Barangay 22-C (Pob.)'),
('112402156', 'Barangay 23-C (Pob.)'),
('112402157', 'Barangay 24-C (Pob.)'),
('112402158', 'Barangay 25-C (Pob.)'),
('112402159', 'Barangay 26-C (Pob.)'),
('112402160', 'Barangay 27-C (Pob.)'),
('112402161', 'Barangay 28-C (Pob.)'),
('112402162', 'Barangay 29-C (Pob.)'),
('112402163', 'Barangay 30-C (Pob.)'),
('112402164', 'Barangay 31-D (Pob.)'),
('112402165', 'Barangay 32-D (Pob.)'),
('112402166', 'Barangay 33-D (Pob.)'),
('112402167', 'Barangay 34-D (Pob.)'),
('112402168', 'Barangay 35-D (Pob.)'),
('112402169', 'Barangay 36-D (Pob.)'),
('112402170', 'Barangay 37-D (Pob.)'),
('112402171', 'Barangay 38-D (Pob.)'),
('112402172', 'Barangay 39-D (Pob.)'),
('112402173', 'Barangay 40-D (Pob.)'),
('112402174', 'Angalan'),
('112402175', 'Baganihan'),
('112402176', 'Bago Aplaya'),
('112402177', 'Bantol'),
('112402178', 'Buda'),
('112402179', 'Centro (San Juan)'),
('112402180', 'Datu Salumay'),
('112402181', 'Gov. Paciano Bangoy'),
('112402182', 'Gov. Vicente Duterte'),
('112402183', 'Gumitan'),
('112402184', 'Inayangan'),
('112402185', 'Kap. Tomas Monteverde, Sr.'),
('112402186', 'Lapu-lapu'),
('112402187', 'Leon Garcia, Sr.'),
('112402188', 'Magsaysay'),
('112402189', 'Megkawayan'),
('112402190', 'Rafael Castillo'),
('112402191', 'Saloy'),
('112402192', 'San Antonio'),
('112402193', 'Santo Niño'),
('112402194', 'Ubalde'),
('112402195', 'Waan'),
('112402196', 'Wilfredo Aquino'),
('112402197', 'Alfonso Angliongto Sr.'),
('112402198', 'Vicente Hizon Sr.'),
('112403001', 'Aplaya'),
('112403002', 'Balabag'),
('112403003', 'San Jose (Balutakay)'),
('112403004', 'Binaton'),
('112403005', 'Cogon'),
('112403006', 'Colorado'),
('112403007', 'Dawis'),
('112403008', 'Dulangan'),
('112403009', 'Goma'),
('112403010', 'Igpit'),
('112403011', 'Kiagot'),
('112403012', 'Lungag'),
('112403013', 'Mahayahay'),
('112403014', 'Matti'),
('112403019', 'Kapatagan (Rizal)'),
('112403020', 'Ruparan'),
('112403021', 'San Agustin'),
('112403022', 'San Miguel (Odaca)'),
('112403023', 'San Roque'),
('112403024', 'Sinawilan'),
('112403025', 'Soong'),
('112403026', 'Tiguman'),
('112403027', 'Tres De Mayo'),
('112403028', 'Zone 1 (Pob.)'),
('112403029', 'Zone 2 (Pob.)'),
('112403030', 'Zone 3 (Pob.)'),
('112404002', 'Balutakay'),
('112404005', 'Clib'),
('112404006', 'Guihing Aplaya'),
('112404007', 'Guihing'),
('112404008', 'Hagonoy Crossing'),
('112404009', 'Kibuaya'),
('112404010', 'La Union'),
('112404011', 'Lanuro'),
('112404012', 'Lapulabao'),
('112404013', 'Leling'),
('112404014', 'Mahayahay'),
('112404017', 'Malabang Damsite'),
('112404018', 'Maliit Digos'),
('112404019', 'New Quezon'),
('112404020', 'Paligue'),
('112404021', 'Poblacion'),
('112404022', 'Sacub'),
('112404023', 'San Guillermo'),
('112404024', 'San Isidro'),
('112404025', 'Sinayawan'),
('112404026', 'Tologan'),
('112406001', 'Abnate'),
('112406002', 'Bagong Negros'),
('112406003', 'Bagong Silang'),
('112406004', 'Bagumbayan'),
('112406005', 'Balasiao'),
('112406007', 'Bonifacio'),
('112406008', 'Bunot'),
('112406009', 'Cogon-Bacaca'),
('112406010', 'Dapok'),
('112406011', 'Ihan'),
('112406012', 'Kibongbong'),
('112406013', 'Kimlawis'),
('112406015', 'Kisulan'),
('112406016', 'Lati-an'),
('112406017', 'Manual'),
('112406018', 'Maraga-a'),
('112406019', 'Molopolo'),
('112406020', 'New Sibonga'),
('112406021', 'Panaglib'),
('112406022', 'Pasig'),
('112406023', 'Poblacion'),
('112406024', 'Pocaleel'),
('112406025', 'San Isidro'),
('112406026', 'San Jose'),
('112406027', 'San Pedro'),
('112406028', 'Santo Niño'),
('112406029', 'Tacub'),
('112406030', 'Tacul'),
('112406031', 'Waterfall'),
('112406032', 'Bulol-Salo'),
('112407001', 'Bacungan'),
('112407002', 'Balnate'),
('112407003', 'Barayong'),
('112407004', 'Blocon'),
('112407005', 'Dalawinon'),
('112407006', 'Dalumay'),
('112407007', 'Glamang'),
('112407008', 'Kanapulo'),
('112407009', 'Kasuga'),
('112407010', 'Lower Bala'),
('112407011', 'Mabini'),
('112407012', 'Malawanit'),
('112407013', 'Malongon'),
('112407014', 'New Ilocos'),
('112407015', 'Poblacion'),
('112407016', 'San Isidro'),
('112407017', 'San Miguel'),
('112407018', 'Tacul'),
('112407019', 'Tagaytay'),
('112407020', 'Upper Bala'),
('112407021', 'Maibo'),
('112407022', 'New Opon'),
('112408002', 'Baybay'),
('112408004', 'Bolton'),
('112408005', 'Bulacan'),
('112408006', 'Caputian'),
('112408007', 'Ibo'),
('112408009', 'Kiblagon'),
('112408010', 'Lapu-Lapu (Lapla)'),
('112408011', 'Mabini'),
('112408014', 'New Baclayon'),
('112408015', 'Pitu'),
('112408016', 'Poblacion'),
('112408018', 'Tagansule'),
('112408019', 'Bagumbayan'),
('112408020', 'Rizal (Parame)'),
('112408021', 'San Isidro'),
('112410001', 'Asbang'),
('112410002', 'Asinan'),
('112410003', 'Bagumbayan'),
('112410004', 'Bangkal'),
('112410005', 'Buas'),
('112410006', 'Buri'),
('112410007', 'Camanchiles'),
('112410008', 'Ceboza'),
('112410009', 'Colonsabak'),
('112410010', 'Dongan-Pekong'),
('112410012', 'Kabasagan'),
('112410013', 'Kapok'),
('112410014', 'Kauswagan'),
('112410015', 'Kibao'),
('112410016', 'La Suerte'),
('112410017', 'Langa-an'),
('112410019', 'Lower Marber'),
('112410021', 'Cabligan (Managa)'),
('112410022', 'Manga'),
('112410023', 'New Katipunan'),
('112410024', 'New Murcia'),
('112410025', 'New Visayas'),
('112410026', 'Poblacion'),
('112410027', 'Saboy'),
('112410028', 'San Jose'),
('112410029', 'San Miguel'),
('112410030', 'San Vicente'),
('112410031', 'Saub'),
('112410032', 'Sinaragan'),
('112410033', 'Sinawilan'),
('112410034', 'Tamlangon'),
('112410035', 'Towak'),
('112410036', 'Tibongbong'),
('112411001', 'Almendras (Pob.)'),
('112411002', 'Don Sergio Osmeña, Sr.'),
('112411003', 'Harada Butai'),
('112411004', 'Lower Katipunan'),
('112411005', 'Lower Limonzo'),
('112411006', 'Lower Malinao'),
('112411007', 'N C Ordaneza District (Pob.)'),
('112411008', 'Northern Paligue'),
('112411009', 'Palili'),
('112411010', 'Piape'),
('112411011', 'Punta Piape'),
('112411012', 'Quirino District (Pob.)'),
('112411013', 'San Isidro'),
('112411014', 'Southern Paligue'),
('112411015', 'Tulogan'),
('112411016', 'Upper Limonzo'),
('112411017', 'Upper Malinao'),
('112412001', 'Astorga'),
('112412002', 'Bato'),
('112412003', 'Coronon'),
('112412004', 'Darong'),
('112412005', 'Inawayan'),
('112412006', 'Jose Rizal'),
('112412009', 'Matutungan'),
('112412010', 'Melilia'),
('112412011', 'Zone I (Pob.)'),
('112412013', 'Saliducon'),
('112412014', 'Sibulan'),
('112412015', 'Sinoron'),
('112412016', 'Tagabuli'),
('112412017', 'Tibolo'),
('112412018', 'Tuban'),
('112412019', 'Zone II (Pob.)'),
('112412020', 'Zone III (Pob.)'),
('112412021', 'Zone IV (Pob.)'),
('112414001', 'Balasinon'),
('112414002', 'Buguis'),
('112414003', 'Carre'),
('112414004', 'Clib'),
('112414005', 'Harada Butai'),
('112414006', 'Katipunan'),
('112414007', 'Kiblagon'),
('112414008', 'Labon'),
('112414009', 'Laperas'),
('112414010', 'Lapla'),
('112414011', 'Litos'),
('112414012', 'Luparan'),
('112414013', 'Mckinley'),
('112414014', 'New Cebu'),
('112414015', 'Osmeña'),
('112414016', 'Palili'),
('112414017', 'Parame'),
('112414018', 'Poblacion'),
('112414020', 'Roxas'),
('112414021', 'Solongvale'),
('112414022', 'Tagolilong'),
('112414023', 'Tala-o'),
('112414024', 'Talas'),
('112414025', 'Tanwalang'),
('112414026', 'Waterfall'),
('112501001', 'Baculin'),
('112501002', 'Banao'),
('112501003', 'Batawan'),
('112501004', 'Batiano'),
('112501005', 'Binondo'),
('112501006', 'Bobonao'),
('112501007', 'Campawan'),
('112501008', 'Central (Pob.)'),
('112501009', 'Dapnan'),
('112501010', 'Kinablangan'),
('112501011', 'Lambajon'),
('112501012', 'Mahanub'),
('112501013', 'Mikit'),
('112501014', 'Salingcomot'),
('112501015', 'San Isidro'),
('112501016', 'San Victor'),
('112501017', 'Lucod'),
('112501018', 'Saoquegue'),
('112502001', 'Cabangcalan'),
('112502002', 'Caganganan'),
('112502003', 'Calubihan'),
('112502004', 'Causwagan'),
('112502005', 'Punta Linao'),
('112502006', 'Mahayag'),
('112502007', 'Maputi'),
('112502008', 'Mogbongcogon'),
('112502009', 'Panikian'),
('112502010', 'Pintatagan'),
('112502011', 'Piso Proper'),
('112502012', 'Poblacion'),
('112502013', 'San Vicente'),
('112502014', 'Rang-ay'),
('112503001', 'Cabasagan'),
('112503002', 'Caatihan'),
('112503003', 'Cawayanan'),
('112503004', 'Poblacion'),
('112503005', 'San Jose'),
('112503006', 'Sibajay'),
('112503007', 'Carmen'),
('112503008', 'Simulao'),
('112504001', 'Alvar'),
('112504002', 'Caningag'),
('112504004', 'Don Leon Balante'),
('112504005', 'Lamiawan'),
('112504006', 'Manorigao'),
('112504007', 'Mercedes'),
('112504008', 'Palma Gil'),
('112504009', 'Pichon'),
('112504010', 'Poblacion'),
('112504011', 'San Antonio'),
('112504012', 'San Jose'),
('112504013', 'San Luis'),
('112504014', 'San Miguel'),
('112504015', 'San Pedro'),
('112504016', 'Santa Fe'),
('112504017', 'Santiago'),
('112504018', 'Sobrecarey'),
('112505001', 'Abijod'),
('112505002', 'Alegria'),
('112505003', 'Aliwagwag'),
('112505004', 'Aragon'),
('112505005', 'Baybay'),
('112505009', 'Maglahus'),
('112505010', 'Mainit'),
('112505011', 'Malibago'),
('112505012', 'San Alfonso'),
('112505013', 'San Antonio'),
('112505014', 'San Miguel'),
('112505015', 'San Rafael'),
('112505016', 'San Vicente'),
('112505017', 'Santa Filomena'),
('112505018', 'Taytayan'),
('112505019', 'Poblacion'),
('112506001', 'Anitap'),
('112506002', 'Manuel Roxas'),
('112506003', 'Don Aurelio Chicote'),
('112506004', 'Lavigan'),
('112506005', 'Luzon'),
('112506006', 'Magdug'),
('112506007', 'Monserrat'),
('112506008', 'Nangan'),
('112506009', 'Oregon'),
('112506010', 'Poblacion'),
('112506011', 'Pundaguitan'),
('112506012', 'Sergio Osmeña'),
('112506013', 'Surop'),
('112506014', 'Tagabebe'),
('112506015', 'Tamban'),
('112506016', 'Tandang Sora'),
('112506017', 'Tibanban'),
('112506018', 'Tiblawan'),
('112506019', 'Upper Tibanban'),
('112506020', 'Crispin Dela Cruz'),
('112507001', 'Bagumbayan'),
('112507003', 'Cabadiangan'),
('112507006', 'Calapagan'),
('112507008', 'Cocornon'),
('112507009', 'Corporacion'),
('112507010', 'Don Mariano Marcos'),
('112507011', 'Ilangay'),
('112507013', 'Langka'),
('112507014', 'Lantawan'),
('112507015', 'Limbahan'),
('112507016', 'Macangao'),
('112507017', 'Magsaysay'),
('112507019', 'Mahayahay'),
('112507021', 'Maragatas'),
('112507022', 'Marayag'),
('112507024', 'New Visayas'),
('112507028', 'Poblacion'),
('112507029', 'San Isidro'),
('112507030', 'San Jose'),
('112507032', 'Tagboa'),
('112507033', 'Tagugpo'),
('112508001', 'Capasnan'),
('112508002', 'Cayawan'),
('112508003', 'Central (Pob.)'),
('112508004', 'Concepcion'),
('112508006', 'Del Pilar'),
('112508007', 'Guza'),
('112508008', 'Holy Cross'),
('112508009', 'Mabini'),
('112508010', 'Manreza'),
('112508011', 'Old Macopa'),
('112508012', 'Rizal'),
('112508013', 'San Fermin'),
('112508014', 'San Ignacio'),
('112508015', 'San Isidro'),
('112508016', 'New Taokanga'),
('112508017', 'Zaragosa'),
('112508018', 'Lambog'),
('112509001', 'Badas'),
('112509002', 'Bobon'),
('112509003', 'Buso'),
('112509004', 'Cabuaya'),
('112509005', 'Central (Pob.)'),
('112509006', 'Culian'),
('112509007', 'Dahican'),
('112509008', 'Danao'),
('112509009', 'Dawan'),
('112509010', 'Don Enrique Lopez'),
('112509011', 'Don Martin Marundan'),
('112509012', 'Don Salvador Lopez, Sr.'),
('112509013', 'Langka'),
('112509015', 'Lawigan'),
('112509016', 'Libudon'),
('112509017', 'Luban'),
('112509018', 'Macambol'),
('112509019', 'Mamali'),
('112509020', 'Matiao'),
('112509021', 'Mayo'),
('112509022', 'Sainz'),
('112509023', 'Sanghay'),
('112509024', 'Tagabakid'),
('112509025', 'Tagbinonga'),
('112509026', 'Taguibo'),
('112509027', 'Tamisan'),
('112510001', 'Baon'),
('112510003', 'Bitaogan'),
('112510004', 'Cambaleon'),
('112510005', 'Dugmanon'),
('112510006', 'Iba'),
('112510007', 'La Union'),
('112510008', 'Lapu-lapu'),
('112510009', 'Maag'),
('112510010', 'Manikling'),
('112510011', 'Maputi'),
('112510012', 'Batobato (Pob.)'),
('112510013', 'San Miguel'),
('112510014', 'San Roque'),
('112510015', 'Santo Rosario'),
('112510016', 'Sudlon'),
('112510017', 'Talisay'),
('112511001', 'Cabagayan'),
('112511002', 'Central (Pob.)'),
('112511003', 'Dadong'),
('112511004', 'Jovellar'),
('112511005', 'Limot'),
('112511006', 'Lucatan'),
('112511007', 'Maganda'),
('112511008', 'Ompao'),
('112511010', 'Tomoaong'),
('112511011', 'Tubaon'),
('118201001', 'Bagongon'),
('118201002', 'Gabi'),
('118201003', 'Lagab'),
('118201004', 'Mangayon'),
('118201005', 'Mapaca'),
('118201006', 'Maparat'),
('118201007', 'New Alegria'),
('118201008', 'Ngan'),
('118201009', 'Osmeña'),
('118201010', 'Panansalan'),
('118201011', 'Poblacion'),
('118201012', 'San Jose'),
('118201013', 'San Miguel'),
('118201014', 'Siocon'),
('118201015', 'Tamia'),
('118201016', 'Aurora'),
('118202001', 'Aguinaldo'),
('118202002', 'Banbanon'),
('118202003', 'Binasbas'),
('118202004', 'Cebulida'),
('118202005', 'Il Papa'),
('118202006', 'Kaligutan'),
('118202007', 'Kapatagan'),
('118202008', 'Kidawa'),
('118202009', 'Kilagding'),
('118202010', 'Kiokmay'),
('118202011', 'Langtud'),
('118202012', 'Longanapan'),
('118202013', 'Naga'),
('118202014', 'Laac (Pob.)'),
('118202015', 'San Antonio'),
('118202016', 'Amor Cruz'),
('118202017', 'Ampawid'),
('118202018', 'Andap'),
('118202019', 'Anitap'),
('118202020', 'Bagong Silang'),
('118202021', 'Belmonte'),
('118202022', 'Bullucan'),
('118202023', 'Concepcion'),
('118202024', 'Datu Ampunan'),
('118202025', 'Datu Davao'),
('118202026', 'Doña Josefa'),
('118202027', 'El Katipunan'),
('118202028', 'Imelda'),
('118202029', 'Inacayan'),
('118202030', 'Mabuhay'),
('118202031', 'Macopa'),
('118202032', 'Malinao'),
('118202033', 'Mangloy'),
('118202034', 'Melale'),
('118202035', 'New Bethlehem'),
('118202036', 'Panamoren'),
('118202037', 'Sabud'),
('118202038', 'Santa Emilia'),
('118202039', 'Santo Niño'),
('118202040', 'Sisimon'),
('118203002', 'Cadunan'),
('118203006', 'Pindasan'),
('118203007', 'Cuambog (Pob.)'),
('118203011', 'Tagnanan (Mampising)'),
('118203012', 'Anitapan'),
('118203013', 'Cabuyuan'),
('118203014', 'Del Pilar'),
('118203015', 'Libodon'),
('118203016', 'Golden Valley (Maraut)'),
('118203017', 'Pangibiran'),
('118203018', 'San Antonio'),
('118204001', 'Anibongan'),
('118204002', 'Anislagan'),
('118204003', 'Binuangan'),
('118204004', 'Bucana'),
('118204005', 'Calabcab'),
('118204006', 'Concepcion'),
('118204007', 'Dumlan'),
('118204008', 'Elizalde (Somil)'),
('118204009', 'Pangi (Gaudencio Antonio)'),
('118204010', 'Gubatan'),
('118204011', 'Hijo'),
('118204012', 'Kinuban'),
('118204013', 'Langgam'),
('118204014', 'Lapu-lapu'),
('118204015', 'Libay-libay'),
('118204016', 'Limbo'),
('118204017', 'Lumatab'),
('118204018', 'Magangit'),
('118204019', 'Malamodao'),
('118204020', 'Manipongol'),
('118204021', 'Mapaang'),
('118204022', 'Masara'),
('118204023', 'New Asturias'),
('118204024', 'Panibasan'),
('118204025', 'Panoraon'),
('118204026', 'Poblacion'),
('118204027', 'San Juan'),
('118204028', 'San Roque'),
('118204029', 'Sangab'),
('118204030', 'Taglawig'),
('118204031', 'Mainit'),
('118204032', 'New Barili'),
('118204033', 'New Leyte'),
('118204034', 'New Visayas'),
('118204035', 'Panangan'),
('118204036', 'Tagbaros'),
('118204037', 'Teresa'),
('118205001', 'Bagong Silang'),
('118205002', 'Mapawa'),
('118205003', 'Maragusan (Pob.)'),
('118205004', 'New Albay'),
('118205005', 'Tupaz'),
('118205006', 'Bahi'),
('118205007', 'Cambagang'),
('118205008', 'Coronobe'),
('118205009', 'Katipunan'),
('118205010', 'Lahi'),
('118205011', 'Langgawisan'),
('118205012', 'Mabugnao'),
('118205013', 'Magcagong'),
('118205014', 'Mahayahay'),
('118205015', 'Mauswagon'),
('118205016', 'New Katipunan'),
('118205017', 'New Man-ay'),
('118205018', 'New Panay'),
('118205019', 'Paloc'),
('118205020', 'Pamintaran'),
('118205021', 'Parasanon'),
('118205022', 'Talian'),
('118205023', 'Tandik'),
('118205024', 'Tigbao'),
('118206001', 'Andili'),
('118206002', 'Bawani'),
('118206003', 'Concepcion'),
('118206004', 'Malinawon'),
('118206005', 'Nueva Visayas'),
('118206006', 'Nuevo Iloco'),
('118206007', 'Poblacion'),
('118206008', 'Salvacion'),
('118206009', 'Saosao'),
('118206010', 'Sawangan'),
('118206011', 'Tuboran'),
('118207001', 'Awao'),
('118207002', 'Babag'),
('118207003', 'Banlag'),
('118207004', 'Baylo'),
('118207005', 'Casoon'),
('118207006', 'Inambatan'),
('118207007', 'Haguimitan'),
('118207008', 'Macopa'),
('118207009', 'Mamunga'),
('118207010', 'Naboc'),
('118207011', 'Olaycon'),
('118207012', 'Pasian (Santa Filomena)'),
('118207013', 'Poblacion'),
('118207014', 'Rizal'),
('118207015', 'Salvacion'),
('118207016', 'San Isidro'),
('118207017', 'San Jose'),
('118207019', 'Tubo-tubo (New Del Monte)'),
('118207020', 'Upper Ulip'),
('118207021', 'Union'),
('118207022', 'Mount Diwata'),
('118208001', 'Banagbanag'),
('118208002', 'Banglasan'),
('118208003', 'Bankerohan Norte'),
('118208004', 'Bankerohan Sur'),
('118208005', 'Camansi'),
('118208006', 'Camantangan'),
('118208007', 'Concepcion'),
('118208008', 'Dauman'),
('118208009', 'Canidkid'),
('118208010', 'Lebanon'),
('118208011', 'Linoan'),
('118208012', 'Mayaon'),
('118208014', 'New Calape'),
('118208015', 'New Dalaguete'),
('118208016', 'New Cebulan (Sambayon)'),
('118208017', 'New Visayas'),
('118208019', 'Prosperidad'),
('118208020', 'San Jose (Pob.)'),
('118208021', 'San Vicente'),
('118208022', 'Tapia'),
('118209001', 'Anislagan'),
('118209002', 'Antiquera'),
('118209003', 'Basak'),
('118209004', 'Cabacungan'),
('118209005', 'Cabidianan'),
('118209006', 'Katipunan'),
('118209007', 'Libasan'),
('118209008', 'Linda'),
('118209009', 'Magading'),
('118209010', 'Magsaysay'),
('118209011', 'Mainit'),
('118209012', 'Manat'),
('118209013', 'Matilo'),
('118209014', 'Mipangi'),
('118209015', 'New Dauis'),
('118209016', 'New Sibonga'),
('118209017', 'Ogao'),
('118209018', 'Pangutosan'),
('118209019', 'Poblacion'),
('118209020', 'San Isidro'),
('118209021', 'San Roque'),
('118209022', 'San Vicente'),
('118209023', 'Santa Maria'),
('118209024', 'Santo Niño (Kao)'),
('118209025', 'Sasa'),
('118209026', 'Tagnocon'),
('118209027', 'Bayabas'),
('118209028', 'Bukal'),
('118210001', 'Bantacan'),
('118210002', 'Batinao'),
('118210003', 'Camanlangan'),
('118210004', 'Cogonon'),
('118210005', 'Fatima'),
('118210006', 'Katipunan'),
('118210007', 'Magsaysay'),
('118210008', 'Magangit'),
('118210009', 'Pagsabangan'),
('118210010', 'Panag'),
('118210011', 'Cabinuangan (Pob.)'),
('118210012', 'San Roque'),
('118210013', 'Andap'),
('118210014', 'Kahayag'),
('118210015', 'Manurigao'),
('118210016', 'Tandawan'),
('118211001', 'Bongabong'),
('118211002', 'Bongbong'),
('118211003', 'P. Fuentes'),
('118211004', 'Kingking (Pob.)'),
('118211005', 'Magnaga'),
('118211006', 'Matiao'),
('118211007', 'Napnapan'),
('118211009', 'Tagdangua'),
('118211010', 'Tambongon'),
('118211011', 'Tibagon'),
('118211012', 'Las Arenas'),
('118211013', 'Araibo'),
('118211014', 'Tag-Ugpo'),
('118601001', 'Calian'),
('118601002', 'Kiobog'),
('118601003', 'North Lamidan'),
('118601004', 'Lawa (Pob.)'),
('118601005', 'Nueva Villa'),
('118601006', 'Talagutong (Pob.)'),
('118601007', 'Baluntaya'),
('118601008', 'Dalupan'),
('118601009', 'Kinanga'),
('118601010', 'Lanao'),
('118601011', 'Lapuan'),
('118601012', 'Linadasan'),
('118601013', 'Mabuhay'),
('118601014', 'South Lamidan'),
('118601015', 'West Lamidan'),
('118602001', 'Buguis'),
('118602002', 'Balangonan'),
('118602006', 'Bukid'),
('118602007', 'Butuan'),
('118602008', 'Butulan'),
('118602009', 'Caburan Big'),
('118602010', 'Caburan Small (Pob.)'),
('118602011', 'Camalian'),
('118602012', 'Carahayan'),
('118602013', 'Cayaponga'),
('118602014', 'Culaman'),
('118602015', 'Kalbay'),
('118602016', 'Kitayo'),
('118602019', 'Magulibas'),
('118602020', 'Malalan'),
('118602021', 'Mangile'),
('118602022', 'Marabutuan'),
('118602023', 'Meybio'),
('118602024', 'Molmol'),
('118602025', 'Nuing'),
('118602026', 'Patulang'),
('118602027', 'Quiapo'),
('118602028', 'San Isidro'),
('118602033', 'Sugal'),
('118602034', 'Tabayon'),
('118602035', 'Tanuman'),
('118603001', 'Bito'),
('118603002', 'Bolila'),
('118603003', 'Buhangin'),
('118603004', 'Culaman'),
('118603005', 'Datu Danwata'),
('118603006', 'Demoloc'),
('118603007', 'Felis'),
('118603008', 'Fishing Village (Fishermans Village)'),
('118603010', 'Kibalatong'),
('118603011', 'Kidalapong'),
('118603012', 'Kilalag'),
('118603013', 'Kinangan'),
('118603016', 'Lacaron'),
('118603017', 'Lagumit'),
('118603018', 'Lais'),
('118603022', 'Little Baguio'),
('118603023', 'Macol'),
('118603024', 'Mana'),
('118603025', 'Manuel Peralta'),
('118603027', 'New Argao'),
('118603030', 'Pangian'),
('118603031', 'Pinalpalan'),
('118603032', 'Poblacion'),
('118603033', 'Sangay'),
('118603036', 'Talogoy'),
('118603037', 'Tical'),
('118603038', 'Ticulon'),
('118603039', 'Tingolo'),
('118603040', 'Tubalan'),
('118603041', 'Pangaleon'),
('118604001', 'Basiawan'),
('118604002', 'Buca'),
('118604003', 'Cadaatan'),
('118604004', 'Kidadan'),
('118604005', 'Kisulad'),
('118604006', 'Malalag Tubig'),
('118604007', 'Mamacao'),
('118604008', 'Ogpao'),
('118604009', 'Poblacion'),
('118604010', 'Pongpong'),
('118604011', 'San Agustin'),
('118604012', 'San Antonio'),
('118604013', 'San Isidro'),
('118604014', 'San Juan'),
('118604015', 'San Pedro'),
('118604016', 'San Roque'),
('118604018', 'Tanglad'),
('118604019', 'Santo Niño'),
('118604020', 'Santo Rosario'),
('118604021', 'Datu Daligasao'),
('118604022', 'Datu Intan'),
('118604023', 'Kinilidan'),
('118605001', 'Batuganding'),
('118605002', 'Konel'),
('118605003', 'Lipol'),
('118605004', 'Mabila (Pob.)'),
('118605005', 'Patuco (Sarangani Norte)'),
('118605006', 'Laker (Sarangani Sur)'),
('118605007', 'Tinina'),
('118605008', 'Camahual'),
('118605009', 'Camalig'),
('118605010', 'Gomtago'),
('118605011', 'Tagen'),
('118605012', 'Tucal');
UNLOCK TABLES;