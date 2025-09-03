<?php
/*
Template Name: Member Login
*/

get_header();
?>
<main class="max-w-screen-md mx-auto p-4">
    <h2 class="text-xl font-bold mb-4">ورود اعضا</h2>

    <form method="post" class="bg-white p-4 rounded shadow-md flex flex-col gap-4">
        <label>نام:
            <input type="text" name="first_name" class="border p-2 w-full" required>
        </label>
        <label>نام خانوادگی:
            <input type="text" name="last_name" class="border p-2 w-full" required>
        </label>
        <label>رمز گروه:
            <input type="text" name="group_password" class="border p-2 w-full" required>
        </label>

        <button type="submit" name="member_login" class="bg-blue-500 text-white px-4 py-2 rounded">
            ورود
        </button>
    </form>
</main>

<?php
get_footer();
?>