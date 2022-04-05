<h2>Modifier votre commentaire :</h2>

<a href="./index.php?controller=controlApp&amp;task=listPosts">Retour à la liste des billets</a>

    <div class="commantaires">
        <p><strong><?= htmlspecialchars($comment['author']) ?></strong> le <?= $comment['comment_Date'] ?></p>
        <p class="comm"><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
    </div> 
    <div class="form-login">
        <form action="./index.php?controller=controlComment&amp;task=modComment&amp;id=<?= $comment['id'] ?>&amp;post_id=<?= $comment['post_id'] ?> " method="POST">
            <table>
                <tr>
                    <td>
                        <?= $form->inputTexte('author', 'Votre Nom', "$comment[author]");?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?= $form->texteArea('comment', 'Votre Commentaire');?>
                    </td>
                </tr>
                <tr>
                    <td class="button">
                        <?= $form->submit('envoyer', 'Envoyer');?>
                    </td>
                </tr>
            </table>
        </form>
    </div> 
