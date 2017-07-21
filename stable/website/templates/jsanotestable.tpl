<!-- $Id: jsanotestable.tpl,v 1.1.1.1 2003/06/02 21:35:38 vagnerr Exp $ -->

<!-- Copyright (C) 2003-  Peter J. Wise <peter_at_bloodaxe.com>
     This code is protected under the Gnu Public License (See LICENSE). -->

<table border = "0">
{section name=note loop=$JobNotesList}

<tr>
  <td nowrap="nowrap" align="right" valign="top">
    {$JobNotesList[note].AddDate}
  </td>
  <td valign="top">
    {$JobNotesList[note].Data}
  </td>
  <td nowrap="nowrap" valign="top">
    <a href="agentdetail.php?ID={$JobNotesList[note].Agent_ID}">
      {$JobNotesList[note].AgentName}
    </a>
  </td>
</tr>

{/section}
</table>
