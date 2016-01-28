<h1>This is the homepage</h1>
<p>A value coming from the controller: <strong>{$something}</strong></p>
<form>
    <input type="hidden" name="action" value="example">
    <button type="submit" class="btn btn-primary">Tester une action</button>
</form>
{if $actionResult}
    <p>
        A value coming from the action: <strong>{$actionResult}</strong>
    </p>
{/if}