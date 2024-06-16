<div class="mb-4 formula">
                                                    <!-- Accuracy -->
                                                    <p>
                                                        <?php
                                                        $accuracy = ($riwayat['true_positive'] + $riwayat['true_negative'] + $riwayat['true_netral']) / 
                                                                    ($riwayat['true_positive'] + $riwayat['true_negative'] + $riwayat['true_netral'] + 
                                                                    $riwayat['false_positive'] + $riwayat['false_negative'] + 
                                                                    $riwayat['positive_netral'] + $riwayat['netral_positive'] + $riwayat['netral_negative'] + $riwayat['negative_netral']);
                                                        ?>
                                                        Accuracy = \( \frac{TP + TN + TNt}{TP + TN + TNt + FP + FN + PNt + NtP + NtN} \)
                                                    </p>
                                                    <p>
                                                        Accuracy = \( \frac{<?= $riwayat['true_positive'] ?> + <?= $riwayat['true_negative'] ?> + <?= $riwayat['true_netral'] ?>}
                                                        {<?= $riwayat['true_positive'] ?> + <?= $riwayat['true_negative'] ?> + <?= $riwayat['true_netral'] ?> + 
                                                        <?= $riwayat['false_positive'] ?> + <?= $riwayat['false_negative'] ?> + 
                                                        <?= $riwayat['positive_netral'] ?> + <?= $riwayat['netral_positive'] ?> + <?= $riwayat['netral_negative'] ?> + <?= $riwayat['negative_netral'] ?>} \) = <?= number_format($accuracy, 4) ?>
                                                    </p>

                                                    <!-- Precision for Positive -->
                                                    <p>
                                                        <?php
                                                        $precision_positive = $riwayat['true_positive'] / 
                                                                            ($riwayat['true_positive'] + $riwayat['false_positive'] + $riwayat['netral_positive']);
                                                        ?>
                                                        Precision (Positive) = \( \frac{TP}{TP + FP + NtP} \) = \( \frac{<?= $riwayat['true_positive'] ?>}
                                                        {<?= $riwayat['true_positive'] ?> + <?= $riwayat['false_positive'] ?> + <?= $riwayat['netral_positive'] ?>} \) = <?= number_format($precision_positive, 4) ?>
                                                    </p>

                                                    <!-- Precision for Neutral -->
                                                    <p>
                                                        <?php
                                                        $precision_neutral = $riwayat['true_netral'] / 
                                                                            ($riwayat['true_netral'] + $riwayat['positive_netral'] + $riwayat['negative_netral']);
                                                        ?>
                                                        Precision (Neutral) = \( \frac{TNt}{TNt + PNt + NtN} \) = \( \frac{<?= $riwayat['true_netral'] ?>}
                                                        {<?= $riwayat['true_netral'] ?> + <?= $riwayat['positive_netral'] ?> + <?= $riwayat['negative_netral'] ?>} \) = <?= number_format($precision_neutral, 4) ?>
                                                    </p>

                                                    <!-- Precision for Negative -->
                                                    <p>
                                                        <?php
                                                        $precision_negative = $riwayat['true_negative'] / 
                                                                            ($riwayat['true_negative'] + $riwayat['false_negative'] + $riwayat['netral_negative']);
                                                        ?>
                                                        Precision (Negative) = \( \frac{TN}{TN + FN + NtN} \) = \( \frac{<?= $riwayat['true_negative'] ?>}
                                                        {<?= $riwayat['true_negative'] ?> + <?= $riwayat['false_negative'] ?> + <?= $riwayat['netral_negative'] ?>} \) = <?= number_format($precision_negative, 4) ?>
                                                    </p>

                                                    <!-- Recall for Positive -->
                                                    <p>
                                                        <?php
                                                        $recall_positive = $riwayat['true_positive'] / 
                                                                        ($riwayat['true_positive'] + $riwayat['false_negative'] + $riwayat['positive_netral']);
                                                        ?>
                                                        Recall (Positive) = \( \frac{TP}{TP + FN + PNt} \) = \( \frac{<?= $riwayat['true_positive'] ?>}
                                                        {<?= $riwayat['true_positive'] ?> + <?= $riwayat['false_negative'] ?> + <?= $riwayat['positive_netral'] ?>} \) = <?= number_format($recall_positive, 4) ?>
                                                    </p>

                                                    <!-- Recall for Neutral -->
                                                    <p>
                                                        <?php
                                                        $recall_neutral = $riwayat['true_netral'] / 
                                                                        ($riwayat['true_netral'] + $riwayat['netral_positive'] + $riwayat['netral_negative']);
                                                        ?>
                                                        Recall (Neutral) = \( \frac{TNt}{TNt + NtP + NtN} \) = \( \frac{<?= $riwayat['true_netral'] ?>}
                                                        {<?= $riwayat['true_netral'] ?> + <?= $riwayat['netral_positive'] ?> + <?= $riwayat['netral_negative'] ?>} \) = <?= number_format($recall_neutral, 4) ?>
                                                    </p>

                                                    <!-- Recall for Negative -->
                                                    <p>
                                                        <?php
                                                        $recall_negative = $riwayat['true_negative'] / 
                                                                        ($riwayat['true_negative'] + $riwayat['false_positive'] + $riwayat['negative_netral']);
                                                        ?>
                                                        Recall (Negative) = \( \frac{TN}{TN + FP + NtN} \) = \( \frac{<?= $riwayat['true_negative'] ?>}
                                                        {<?= $riwayat['true_negative'] ?> + <?= $riwayat['false_positive'] ?> + <?= $riwayat['negative_netral'] ?>} \) = <?= number_format($recall_negative, 4) ?>
                                                    </p>
                                                </div>