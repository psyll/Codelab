<?php
namespace Codelab;

class Error
{
    public function runtime(string $message, string $description = null)
    {
        ?>
            <div style="background:red;color:white;">
                <div><?php echo $message; ?></div>
                <div><?php echo $description; ?></div>
            </div>
        <?php
    }
}
