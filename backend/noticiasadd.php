<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg10.php" ?>
<?php include_once "ewmysql10.php" ?>
<?php include_once "phpfn10.php" ?>
<?php include_once "noticiasinfo.php" ?>
<?php include_once "userfn10.php" ?>
<?php

//
// Page class
//

$noticias_add = NULL; // Initialize page object first

class cnoticias_add extends cnoticias {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{6DDC98FA-D568-4216-A349-71F4D51B4AA0}";

	// Table name
	var $TableName = 'noticias';

	// Page object name
	var $PageObjName = 'noticias_add';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-error ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<table class=\"ewStdTable\"><tr><td><div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div></td></tr></table>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (noticias)
		if (!isset($GLOBALS["noticias"])) {
			$GLOBALS["noticias"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["noticias"];
		}

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'noticias', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up curent action

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		$this->Page_Redirecting($url);

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["id"] != "") {
				$this->id->setQueryStringValue($_GET["id"]);
				$this->setKey("id", $this->id->CurrentValue); // Set up key
			} else {
				$this->setKey("id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("noticiaslist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "noticiasview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm;

		// Get upload data
		$this->imagen->Upload->Index = $objForm->Index;
		if ($this->imagen->Upload->UploadFile()) {

			// No action required
		} else {
			echo $this->imagen->Upload->Message;
			$this->Page_Terminate();
			exit();
		}
		$this->imagen->CurrentValue = $this->imagen->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->fecha->CurrentValue = NULL;
		$this->fecha->OldValue = $this->fecha->CurrentValue;
		$this->titulo->CurrentValue = NULL;
		$this->titulo->OldValue = $this->titulo->CurrentValue;
		$this->contenido->CurrentValue = NULL;
		$this->contenido->OldValue = $this->contenido->CurrentValue;
		$this->imagen->Upload->DbValue = NULL;
		$this->imagen->OldValue = $this->imagen->Upload->DbValue;
		$this->imagen->CurrentValue = NULL; // Clear file related field
		$this->idCategoria->CurrentValue = NULL;
		$this->idCategoria->OldValue = $this->idCategoria->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->fecha->FldIsDetailKey) {
			$this->fecha->setFormValue($objForm->GetValue("x_fecha"));
			$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 7);
		}
		if (!$this->titulo->FldIsDetailKey) {
			$this->titulo->setFormValue($objForm->GetValue("x_titulo"));
		}
		if (!$this->contenido->FldIsDetailKey) {
			$this->contenido->setFormValue($objForm->GetValue("x_contenido"));
		}
		if (!$this->idCategoria->FldIsDetailKey) {
			$this->idCategoria->setFormValue($objForm->GetValue("x_idCategoria"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->fecha->CurrentValue = $this->fecha->FormValue;
		$this->fecha->CurrentValue = ew_UnFormatDateTime($this->fecha->CurrentValue, 7);
		$this->titulo->CurrentValue = $this->titulo->FormValue;
		$this->contenido->CurrentValue = $this->contenido->FormValue;
		$this->idCategoria->CurrentValue = $this->idCategoria->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn;
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->id->setDbValue($rs->fields('id'));
		$this->fecha->setDbValue($rs->fields('fecha'));
		$this->titulo->setDbValue($rs->fields('titulo'));
		$this->contenido->setDbValue($rs->fields('contenido'));
		$this->imagen->Upload->DbValue = $rs->fields('imagen');
		$this->idCategoria->setDbValue($rs->fields('idCategoria'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->id->DbValue = $row['id'];
		$this->fecha->DbValue = $row['fecha'];
		$this->titulo->DbValue = $row['titulo'];
		$this->contenido->DbValue = $row['contenido'];
		$this->imagen->Upload->DbValue = $row['imagen'];
		$this->idCategoria->DbValue = $row['idCategoria'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("id")) <> "")
			$this->id->CurrentValue = $this->getKey("id"); // id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id
		// fecha
		// titulo
		// contenido
		// imagen
		// idCategoria

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// fecha
			$this->fecha->ViewValue = $this->fecha->CurrentValue;
			$this->fecha->ViewValue = ew_FormatDateTime($this->fecha->ViewValue, 7);
			$this->fecha->ViewCustomAttributes = "";

			// titulo
			$this->titulo->ViewValue = $this->titulo->CurrentValue;
			$this->titulo->ViewCustomAttributes = "";

			// contenido
			$this->contenido->ViewValue = $this->contenido->CurrentValue;
			$this->contenido->ViewCustomAttributes = "";

			// imagen
			if (!ew_Empty($this->imagen->Upload->DbValue)) {
				$this->imagen->ViewValue = $this->imagen->Upload->DbValue;
			} else {
				$this->imagen->ViewValue = "";
			}
			$this->imagen->ViewCustomAttributes = "";

			// idCategoria
			if (strval($this->idCategoria->CurrentValue) <> "") {
				$sFilterWrk = "`id`" . ew_SearchString("=", $this->idCategoria->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `id`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `categorias`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idCategoria, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->idCategoria->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->idCategoria->ViewValue = $this->idCategoria->CurrentValue;
				}
			} else {
				$this->idCategoria->ViewValue = NULL;
			}
			$this->idCategoria->ViewCustomAttributes = "";

			// fecha
			$this->fecha->LinkCustomAttributes = "";
			$this->fecha->HrefValue = "";
			$this->fecha->TooltipValue = "";

			// titulo
			$this->titulo->LinkCustomAttributes = "";
			$this->titulo->HrefValue = "";
			$this->titulo->TooltipValue = "";

			// contenido
			$this->contenido->LinkCustomAttributes = "";
			$this->contenido->HrefValue = "";
			$this->contenido->TooltipValue = "";

			// imagen
			$this->imagen->LinkCustomAttributes = "";
			$this->imagen->HrefValue = "";
			$this->imagen->HrefValue2 = $this->imagen->UploadPath . $this->imagen->Upload->DbValue;
			$this->imagen->TooltipValue = "";

			// idCategoria
			$this->idCategoria->LinkCustomAttributes = "";
			$this->idCategoria->HrefValue = "";
			$this->idCategoria->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// fecha
			$this->fecha->EditCustomAttributes = "";
			$this->fecha->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->fecha->CurrentValue, 7));
			$this->fecha->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->fecha->FldCaption()));

			// titulo
			$this->titulo->EditCustomAttributes = "";
			$this->titulo->EditValue = ew_HtmlEncode($this->titulo->CurrentValue);
			$this->titulo->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->titulo->FldCaption()));

			// contenido
			$this->contenido->EditCustomAttributes = "";
			$this->contenido->EditValue = $this->contenido->CurrentValue;
			$this->contenido->PlaceHolder = ew_HtmlEncode(ew_RemoveHtml($this->contenido->FldCaption()));

			// imagen
			$this->imagen->EditCustomAttributes = "";
			if (!ew_Empty($this->imagen->Upload->DbValue)) {
				$this->imagen->EditValue = $this->imagen->Upload->DbValue;
			} else {
				$this->imagen->EditValue = "";
			}
			if (!ew_Empty($this->imagen->CurrentValue))
				$this->imagen->Upload->FileName = $this->imagen->CurrentValue;
			if (($this->CurrentAction == "I" || $this->CurrentAction == "C") && !$this->EventCancelled) ew_RenderUploadField($this->imagen);

			// idCategoria
			$this->idCategoria->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `id`, `denominacion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `categorias`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}

			// Call Lookup selecting
			$this->Lookup_Selecting($this->idCategoria, $sWhereWrk);
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->idCategoria->EditValue = $arwrk;

			// Edit refer script
			// fecha

			$this->fecha->HrefValue = "";

			// titulo
			$this->titulo->HrefValue = "";

			// contenido
			$this->contenido->HrefValue = "";

			// imagen
			$this->imagen->HrefValue = "";
			$this->imagen->HrefValue2 = $this->imagen->UploadPath . $this->imagen->Upload->DbValue;

			// idCategoria
			$this->idCategoria->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!ew_CheckEuroDate($this->fecha->FormValue)) {
			ew_AddMessage($gsFormError, $this->fecha->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security;

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// fecha
		$this->fecha->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->fecha->CurrentValue, 7), NULL, FALSE);

		// titulo
		$this->titulo->SetDbValueDef($rsnew, $this->titulo->CurrentValue, NULL, FALSE);

		// contenido
		$this->contenido->SetDbValueDef($rsnew, $this->contenido->CurrentValue, NULL, FALSE);

		// imagen
		if (!$this->imagen->Upload->KeepFile) {
			if ($this->imagen->Upload->FileName == "") {
				$rsnew['imagen'] = NULL;
			} else {
				$rsnew['imagen'] = $this->imagen->Upload->FileName;
			}
		}

		// idCategoria
		$this->idCategoria->SetDbValueDef($rsnew, $this->idCategoria->CurrentValue, NULL, FALSE);
		if (!$this->imagen->Upload->KeepFile) {
			if (!ew_Empty($this->imagen->Upload->Value)) {
				$rsnew['imagen'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->imagen->UploadPath), $rsnew['imagen']); // Get new file name
			}
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
				if (!$this->imagen->Upload->KeepFile) {
					if (!ew_Empty($this->imagen->Upload->Value)) {
						$this->imagen->Upload->SaveToFile($this->imagen->UploadPath, $rsnew['imagen'], TRUE);
					}
				}
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$this->id->setDbValue($conn->Insert_ID());
			$rsnew['id'] = $this->id->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}

		// imagen
		ew_CleanUploadTempPath($this->imagen, $this->imagen->Upload->Index);
		return $AddRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "noticiaslist.php", $this->TableVar);
		$PageCaption = ($this->CurrentAction == "C") ? $Language->Phrase("Copy") : $Language->Phrase("Add");
		$Breadcrumb->Add("add", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($noticias_add)) $noticias_add = new cnoticias_add();

// Page init
$noticias_add->Page_Init();

// Page main
$noticias_add->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$noticias_add->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var noticias_add = new ew_Page("noticias_add");
noticias_add.PageID = "add"; // Page ID
var EW_PAGE_ID = noticias_add.PageID; // For backward compatibility

// Form object
var fnoticiasadd = new ew_Form("fnoticiasadd");

// Validate form
fnoticiasadd.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	this.PostAutoSuggest();
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_fecha");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($noticias->fecha->FldErrMsg()) ?>");

			// Set up row object
			ew_ElementsToRow(fobj);

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
	return true;
}

// Form_CustomValidate event
fnoticiasadd.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fnoticiasadd.ValidateRequired = true;
<?php } else { ?>
fnoticiasadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fnoticiasadd.Lists["x_idCategoria"] = {"LinkField":"x_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_denominacion","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $Breadcrumb->Render(); ?>
<?php $noticias_add->ShowPageHeader(); ?>
<?php
$noticias_add->ShowMessage();
?>
<form name="fnoticiasadd" id="fnoticiasadd" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="noticias">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td>
<table id="tbl_noticiasadd" class="table table-bordered table-striped">
<?php if ($noticias->fecha->Visible) { // fecha ?>
	<tr id="r_fecha">
		<td><span id="elh_noticias_fecha"><?php echo $noticias->fecha->FldCaption() ?></span></td>
		<td<?php echo $noticias->fecha->CellAttributes() ?>>
<span id="el_noticias_fecha" class="control-group">
<input type="text" data-field="x_fecha" name="x_fecha" id="x_fecha" placeholder="<?php echo $noticias->fecha->PlaceHolder ?>" value="<?php echo $noticias->fecha->EditValue ?>"<?php echo $noticias->fecha->EditAttributes() ?>>
<?php if (!$noticias->fecha->ReadOnly && !$noticias->fecha->Disabled && @$noticias->fecha->EditAttrs["readonly"] == "" && @$noticias->fecha->EditAttrs["disabled"] == "") { ?>
<button id="cal_x_fecha" name="cal_x_fecha" class="btn" type="button"><img src="phpimages/calendar.png" id="cal_x_fecha" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" style="border: 0;"></button><script type="text/javascript">
ew_CreateCalendar("fnoticiasadd", "x_fecha", "%d/%m/%Y");
</script>
<?php } ?>
</span>
<?php echo $noticias->fecha->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($noticias->titulo->Visible) { // titulo ?>
	<tr id="r_titulo">
		<td><span id="elh_noticias_titulo"><?php echo $noticias->titulo->FldCaption() ?></span></td>
		<td<?php echo $noticias->titulo->CellAttributes() ?>>
<span id="el_noticias_titulo" class="control-group">
<input type="text" data-field="x_titulo" name="x_titulo" id="x_titulo" size="30" maxlength="200" placeholder="<?php echo $noticias->titulo->PlaceHolder ?>" value="<?php echo $noticias->titulo->EditValue ?>"<?php echo $noticias->titulo->EditAttributes() ?>>
</span>
<?php echo $noticias->titulo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($noticias->contenido->Visible) { // contenido ?>
	<tr id="r_contenido">
		<td><span id="elh_noticias_contenido"><?php echo $noticias->contenido->FldCaption() ?></span></td>
		<td<?php echo $noticias->contenido->CellAttributes() ?>>
<span id="el_noticias_contenido" class="control-group">
<textarea data-field="x_contenido" class="editor" name="x_contenido" id="x_contenido" cols="35" rows="4" placeholder="<?php echo $noticias->contenido->PlaceHolder ?>"<?php echo $noticias->contenido->EditAttributes() ?>><?php echo $noticias->contenido->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fnoticiasadd", "x_contenido", 35, 4, <?php echo ($noticias->contenido->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $noticias->contenido->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($noticias->imagen->Visible) { // imagen ?>
	<tr id="r_imagen">
		<td><span id="elh_noticias_imagen"><?php echo $noticias->imagen->FldCaption() ?></span></td>
		<td<?php echo $noticias->imagen->CellAttributes() ?>>
<span id="el_noticias_imagen" class="control-group">
<span id="fd_x_imagen">
<span class="btn btn-small fileinput-button"<?php if ($noticias->imagen->ReadOnly || $noticias->imagen->Disabled) echo " style=\"display: none;\""; ?>>
	<span><?php echo $Language->Phrase("ChooseFile") ?></span>
	<input type="file" data-field="x_imagen" name="x_imagen" id="x_imagen">
</span>
<input type="hidden" name="fn_x_imagen" id= "fn_x_imagen" value="<?php echo $noticias->imagen->Upload->FileName ?>">
<input type="hidden" name="fa_x_imagen" id= "fa_x_imagen" value="0">
<input type="hidden" name="fs_x_imagen" id= "fs_x_imagen" value="255">
</span>
<table id="ft_x_imagen" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $noticias->imagen->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($noticias->idCategoria->Visible) { // idCategoria ?>
	<tr id="r_idCategoria">
		<td><span id="elh_noticias_idCategoria"><?php echo $noticias->idCategoria->FldCaption() ?></span></td>
		<td<?php echo $noticias->idCategoria->CellAttributes() ?>>
<span id="el_noticias_idCategoria" class="control-group">
<select data-field="x_idCategoria" id="x_idCategoria" name="x_idCategoria"<?php echo $noticias->idCategoria->EditAttributes() ?>>
<?php
if (is_array($noticias->idCategoria->EditValue)) {
	$arwrk = $noticias->idCategoria->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($noticias->idCategoria->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
<script type="text/javascript">
fnoticiasadd.Lists["x_idCategoria"].Options = <?php echo (is_array($noticias->idCategoria->EditValue)) ? ew_ArrayToJson($noticias->idCategoria->EditValue, 1) : "[]" ?>;
</script>
</span>
<?php echo $noticias->idCategoria->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</td></tr></table>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("AddBtn") ?></button>
</form>
<script type="text/javascript">
fnoticiasadd.Init();
<?php if (EW_MOBILE_REFLOW && ew_IsMobile()) { ?>
ew_Reflow();
<?php } ?>
</script>
<?php
$noticias_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$noticias_add->Page_Terminate();
?>
