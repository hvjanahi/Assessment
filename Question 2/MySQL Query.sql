SELECT
	tbPatients.PXID,
	tbPatients.TITLE,
	tbPatients.FirstNAME,
	tbPatients.SURNAME,
	tbPatients.STREET,
	tbPatients.SUBURB,
	tbPatients.STATE,
	tbPatients.PCODE,
	DATE_FORMAT(
		MAX(tbClDisp.RxDate),
		'%d/%m/%Y'
	) AS LastCLDate,
	DATE_FORMAT(
		MAX(RxPad.DispenseDate),
		'%d/%m/%Y'
	) AS LastRXDate,
	DATE_FORMAT(Inv.InvoiceDate, '%d/%m/%Y') AS LastInvDate,
	tbPatients.Points,
	Inv.InvAmt,
	DATE_FORMAT(tbPatients.REC1, '%d/%m/%Y') AS REC1,
	DATE_FORMAT(tbPatients.REC2, '%d/%m/%Y') AS REC2,
	tbPatients.iPatientStatus
FROM
	tbPatients
INNER JOIN (
	SELECT DISTINCT
		Invoice.PXID,
		Invoice.InvoiceDate,
		MIN(
			Invoice.InvBalance + Invoice.InvPaid
		) AS InvAmt
	FROM
		(
			SELECT
				Inv3.PXID,
				MAX(Inv3.InvoiceDate) AS InvoiceDate
			FROM
				Invoice AS Inv3
			GROUP BY
				Inv3.PXID
		) AS Inv2,
		Invoice
	WHERE
		Invoice.PXID = Inv2.PXID
	AND Invoice.InvoiceDate = Inv2.InvoiceDate
	GROUP BY
		Invoice.PXID,
		Invoice.InvoiceDate
	ORDER BY
		Invoice.PXID ASC
) AS Inv ON Inv.PXID = tbPatients.PXID
LEFT JOIN RxPad ON RxPad.PxID = tbPatients.PXID
LEFT JOIN tbClDisp ON tbClDisp.PxID = tbPatients.PXID
GROUP BY
	tbPatients.PXID,
	tbPatients.TITLE,
	tbPatients.FirstNAME,
	tbPatients.SURNAME,
	tbPatients.STREET,
	tbPatients.SUBURB,
	tbPatients.STATE,
	tbPatients.PCODE,
	Inv.InvoiceDate,
	tbPatients.Points,
	Inv.InvAmt,
	tbPatients.REC1,
	tbPatients.REC2,
	tbPatients.iPatientStatus;