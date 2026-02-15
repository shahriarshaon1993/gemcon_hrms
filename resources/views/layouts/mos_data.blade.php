<form action="{{ url('/mos_datas_user') }}" method="post">
    <table id="dtBasicExample" class="table table-striped table-bordered" cellspacing="0" style="font-size:12px; border: none;width: 99.9%;">
        <thead>
            <tr>
                <th class="th-sm text-center">MOS

                </th>
                <th>Jan</th>
                <th>Feb</th>
                <th>Mar</th>
                <th>Apr</th>
                <th>May</th>
                <th>Jun</th>
                <th>Jul</th>
                <th>Aug</th>
                <th>Sep</th>
                <th>Oct</th>
                <th>Nov</th>
                <th>Dec</th>
            </tr>
        </thead>
        <tbody id="attendance_pagination">

            @csrf

            <?php

            foreach ($data_return as $key => $att_value) : ?>
                <input type="hidden" name="ids[]" value="{{$att_value['id']}}">
                <tr>
                    <td class="text-center" style="width: 25% !important">
                        {{ $att_value['mos_name']}}
                    </td>
                    <td>
                        <?php if ($att_value['mostargetjoin']) { ?>

                        <?php echo $att_value['mostargetjoin']->january . "<hr>" . ($departmentsetting->jan == 1 ? '<input type="text" name="january[' . $att_value['id'] . ']"  style="width:100px" value="' . ($att_value['mosuserachievementjoin'] ? $att_value['mosuserachievementjoin']->january : 0) . '">' : ($att_value['mosuserachievementjoin'] ? $att_value['mosuserachievementjoin']->january : 0));
                        } ?>
                    </td>
                    <td>
                        <?php if ($att_value['mostargetjoin']) { ?>

                        <?php echo $att_value['mostargetjoin']->february . "<hr>" . ($departmentsetting->feb == 1 ? '<input type="text" name="february[' . $att_value['id'] . ']"  style="width:100px" value="' . ($att_value['mosuserachievementjoin'] ? $att_value['mosuserachievementjoin']->february : 0) . '">' : ($att_value['mosuserachievementjoin'] ? $att_value['mosuserachievementjoin']->february : 0));
                        } ?>
                    </td>
                    <td>
                        <?php if ($att_value['mostargetjoin']) { ?>

                        <?php echo $att_value['mostargetjoin']->march . "<hr>" . ($departmentsetting->mar == 1 ? '<input type="text" name="march[' . $att_value['id'] . ']"  style="width:100px" value="' . ($att_value['mosuserachievementjoin'] ? $att_value['mosuserachievementjoin']->march : 0) . '">' : ($att_value['mosuserachievementjoin'] ? $att_value['mosuserachievementjoin']->march : 0));
                        } ?>
                    </td>
                    <td>
                        <?php if ($att_value['mostargetjoin']) { ?>

                        <?php echo $att_value['mostargetjoin']->april . "<hr>" . ($departmentsetting->apr == 1 ? '<input type="text" name="april[' . $att_value['id'] . ']"  style="width:100px" value="' . ($att_value['mosuserachievementjoin'] ? $att_value['mosuserachievementjoin']->april : 0) . '">' : ($att_value['mosuserachievementjoin'] ? $att_value['mosuserachievementjoin']->april : 0));
                        } ?>
                    </td>
                    <td>
                        <?php if ($att_value['mostargetjoin']) { ?>

                        <?php echo $att_value['mostargetjoin']->may . "<hr>" . ($departmentsetting->may == 1 ? '<input type="text" name="may[' . $att_value['id'] . ']"  style="width:100px" value="' . ($att_value['mosuserachievementjoin'] ? $att_value['mosuserachievementjoin']->may : 0) . '">' : ($att_value['mosuserachievementjoin'] ? $att_value['mosuserachievementjoin']->may : 0));
                        } ?>
                    </td>
                    <td>
                        <?php if ($att_value['mostargetjoin']) { ?>

                        <?php echo $att_value['mostargetjoin']->june . "<hr>" . ($departmentsetting->jun == 1 ? '<input type="text" name="june[' . $att_value['id'] . ']"  style="width:100px" value="' . ($att_value['mosuserachievementjoin'] ? $att_value['mosuserachievementjoin']->june : 0) . '">' : ($att_value['mosuserachievementjoin'] ? $att_value['mosuserachievementjoin']->june : 0));
                        } ?>
                    </td>
                    <td>
                        <?php if ($att_value['mostargetjoin']) { ?>

                        <?php echo $att_value['mostargetjoin']->july . "<hr>" . ($departmentsetting->jul == 1 ? '<input type="text" name="july[' . $att_value['id'] . ']"  style="width:100px" value="' . ($att_value['mosuserachievementjoin'] ? $att_value['mosuserachievementjoin']->july : 0) . '">' : ($att_value['mosuserachievementjoin'] ? $att_value['mosuserachievementjoin']->july : 0));
                        } ?>
                    </td>
                    <td>
                        <?php if ($att_value['mostargetjoin']) { ?>

                        <?php echo $att_value['mostargetjoin']->august . "<hr>" . ($departmentsetting->aug == 1 ? '<input type="text" name="august[' . $att_value['id'] . ']"  style="width:100px" value="' . ($att_value['mosuserachievementjoin'] ? $att_value['mosuserachievementjoin']->august : 0) . '">' : ($att_value['mosuserachievementjoin'] ? $att_value['mosuserachievementjoin']->august : 0));
                        } ?>
                    </td>
                    <td>
                        <?php if ($att_value['mostargetjoin']) { ?>

                        <?php echo $att_value['mostargetjoin']->september . "<hr>" . ($departmentsetting->sep == 1 ? '<input type="text" name="september[' . $att_value['id'] . ']"  style="width:100px" value="' . ($att_value['mosuserachievementjoin'] ? $att_value['mosuserachievementjoin']->september : 0) . '">' : ($att_value['mosuserachievementjoin'] ? $att_value['mosuserachievementjoin']->september : 0));
                        } ?>
                    </td>
                    <td>
                        <?php if ($att_value['mostargetjoin']) { ?>

                        <?php echo $att_value['mostargetjoin']->october . "<hr>" . ($departmentsetting->oct == 1 ? '<input type="text" name="october[' . $att_value['id'] . ']"  style="width:100px" value="' . ($att_value['mosuserachievementjoin'] ? $att_value['mosuserachievementjoin']->october : 0) . '">' : ($att_value['mosuserachievementjoin'] ? $att_value['mosuserachievementjoin']->october : 0));
                        } ?>
                    </td>
                    <td>
                        <?php if ($att_value['mostargetjoin']) { ?>

                        <?php echo $att_value['mostargetjoin']->november . "<hr>" . ($departmentsetting->nov == 1 ? '<input type="text" name="november[' . $att_value['id'] . ']"  style="width:100px" value="' . ($att_value['mosuserachievementjoin'] ? $att_value['mosuserachievementjoin']->november : 0) . '">' : ($att_value['mosuserachievementjoin'] ? $att_value['mosuserachievementjoin']->november : 0));
                        } ?>
                    </td>
                    <td>
                        <?php if ($att_value['mostargetjoin']) { ?>

                        <?php echo $att_value['mostargetjoin']->december . "<hr>" . ($departmentsetting->dec == 1 ? '<input type="text" name="december[' . $att_value['id'] . ']"  style="width:100px" value="' . ($att_value['mosuserachievementjoin'] ? $att_value['mosuserachievementjoin']->december : 0) . '">' : ($att_value['mosuserachievementjoin'] ? $att_value['mosuserachievementjoin']->december : 0));
                        } ?>
                    </td>
                </tr>
            <?php endforeach ?>
            </tr>
        </tbody>
    </table>
    <input type="submit" name="submit" value="Save">
</form>