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

$noticias_delete = NULL; // Initialize page object first

class cnoticias_delete extends cnoticias {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{6DDC98FA-D568-4216-A349-71F4D51B4AA0}";

	// Table name
	var $TableName = 'noticias';

	// Page object name
	var $PageObjName = 'noticias_delete';

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
			define("EW_PAGE_ID", 'delete', TRUE);

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
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("noticiaslist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in noticias class, noticiasinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "D"; // Delete record directly
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // Delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn;

		// Call Recordset Selecting event
		$this->Recordset_Selecting($this->CurrentFilter);

		// Load List page SQL
		$sSql = $this->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
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

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// id

		$this->id->CellCssStyle = "white-space: nowrap;";

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

			// imagen
			$this->imagen->LinkCustomAttributes = "";
			$this->imagen->HrefValue = "";
			$this->imagen->HrefValue2 = $this->imagen->UploadPath . $this->imagen->Upload->DbValue;
			$this->imagen->TooltipValue = "";

			// idCategoria
			$this->idCategoria->LinkCustomAttributes = "";
			$this->idCategoria->HrefValue = "";
			$this->idCategoria->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$conn->BeginTrans();

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['id'];
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$PageCaption = $this->TableCaption();
		$Breadcrumb->Add("list", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", "noticiaslist.php", $this->TableVar);
		$PageCaption = $Language->Phrase("delete");
		$Breadcrumb->Add("delete", "<span id=\"ewPageCaption\">" . $PageCaption . "</span>", ew_CurrentUrl(), $this->TableVar);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($noticias_delete)) $noticias_delete = new cnoticias_delete();

// Page init
$noticias_delete->Page_Init();

// Page main
$noticias_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$noticias_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var noticias_delete = new ew_Page("noticias_delete");
noticias_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = noticias_delete.PageID; // For backward compatibility

// Form object
var fnoticiasdelete = new ew_Form("fnoticiasdelete");

// Form_CustomValidate event
fnoticiasdelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fnoticiasdelete.ValidateRequired = true;
<?php } else { ?>
fnoticiasdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fnoticiasdelete.Lists["x_idCategoria"] = {"LinkField":"x_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_denominacion","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($noticias_delete->Recordset = $noticias_delete->LoadRecordset())
	$noticias_deleteTotalRecs = $noticias_delete->Recordset->RecordCount(); // Get record count
if ($noticias_deleteTotalRecs <= 0) { // No record found, exit
	if ($noticias_delete->Recordset)
		$noticias_delete->Recordset->Close();
	$noticias_delete->Page_Terminate("noticiaslist.php"); // Return to list
}
?>
<?php $Breadcrumb->Render(); ?>
<?php $noticias_delete->ShowPageHeader(); ?>
<?php
$noticias_delete->ShowMessage();
?>
<form name="fnoticiasdelete" id="fnoticiasdelete" class="ewForm form-horizontal" action="<?php echo ew_CurrentPage() ?>" method="post">
<input type="hidden" name="t" value="noticias">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($noticias_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table id="tbl_noticiasdelete" class="ewTable ewTableSeparate">
<?php echo $noticias->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
<?php if ($noticias->fecha->Visible) { // fecha ?>
		<td><span id="elh_noticias_fecha" class="noticias_fecha"><?php echo $noticias->fecha->FldCaption() ?></span></td>
<?php } ?>
<?php if ($noticias->titulo->Visible) { // titulo ?>
		<td><span id="elh_noticias_titulo" class="noticias_titulo"><?php echo $noticias->titulo->FldCaption() ?></span></td>
<?php } ?>
<?php if ($noticias->imagen->Visible) { // imagen ?>
		<td><span id="elh_noticias_imagen" class="noticias_imagen"><?php echo $noticias->imagen->FldCaption() ?></span></td>
<?php } ?>
<?php if ($noticias->idCategoria->Visible) { // idCategoria ?>
		<td><span id="elh_noticias_idCategoria" class="noticias_idCategoria"><?php echo $noticias->idCategoria->FldCaption() ?></span></td>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$noticias_delete->RecCnt = 0;
$i = 0;
while (!$noticias_delete->Recordset->EOF) {
	$noticias_delete->RecCnt++;
	$noticias_delete->RowCnt++;

	// Set row properties
	$noticias->ResetAttrs();
	$noticias->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$noticias_delete->LoadRowValues($noticias_delete->Recordset);

	// Render row
	$noticias_delete->RenderRow();
?>
	<tr<?php echo $noticias->RowAttributes() ?>>
<?php if ($noticias->fecha->Visible) { // fecha ?>
		<td<?php echo $noticias->fecha->CellAttributes() ?>>
<span id="el<?php echo $noticias_delete->RowCnt ?>_noticias_fecha" class="control-group noticias_fecha">
<span<?php echo $noticias->fecha->ViewAttributes() ?>>
<?php echo $noticias->fecha->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($noticias->titulo->Visible) { // titulo ?>
		<td<?php echo $noticias->titulo->CellAttributes() ?>>
<span id="el<?php echo $noticias_delete->RowCnt ?>_noticias_titulo" class="control-group noticias_titulo">
<span<?php echo $noticias->titulo->ViewAttributes() ?>>
<?php echo $noticias->titulo->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($noticias->imagen->Visible) { // imagen ?>
		<td<?php echo $noticias->imagen->CellAttributes() ?>>
<span id="el<?php echo $noticias_delete->RowCnt ?>_noticias_imagen" class="control-group noticias_imagen">
<span<?php echo $noticias->imagen->ViewAttributes() ?>>
<?php if ($noticias->imagen->LinkAttributes() <> "") { ?>
<?php if (!empty($noticias->imagen->Upload->DbValue)) { ?>
<?php echo $noticias->imagen->ListViewValue() ?>
<?php } elseif (!in_array($noticias->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($noticias->imagen->Upload->DbValue)) { ?>
<?php echo $noticias->imagen->ListViewValue() ?>
<?php } elseif (!in_array($noticias->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($noticias->idCategoria->Visible) { // idCategoria ?>
		<td<?php echo $noticias->idCategoria->CellAttributes() ?>>
<span id="el<?php echo $noticias_delete->RowCnt ?>_noticias_idCategoria" class="control-group noticias_idCategoria">
<span<?php echo $noticias->idCategoria->ViewAttributes() ?>>
<?php echo $noticias->idCategoria->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$noticias_delete->Recordset->MoveNext();
}
$noticias_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<div class="btn-group ewButtonGroup">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
</div>
</form>
<script type="text/javascript">
fnoticiasdelete.Init();
</script>
<?php
$noticias_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$noticias_delete->Page_Terminate();
?>
