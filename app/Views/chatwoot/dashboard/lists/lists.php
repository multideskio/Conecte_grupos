<div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0 flex-grow-1">Todos os grupos</h4>
                                </div><!-- end card header -->
                                <div class="card-body">
                                    <div class="table-card p-2">
                                        <table id="scroll-home-vertical" class="table table-bordered dt-responsive nowrap align-middle mdl-data-table" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th scope="col" style="width: 10px;">
                                                        <div class="form-check">
                                                            <input class="form-check-input fs-15" type="checkbox" id="checkAll" value="option">
                                                        </div>
                                                    </th>
                                                    <th>Nome do grupo</th>
                                                    <th>Criado em</th>
                                                    <th>Admin</th>
                                                    <th>Participantes</th>
                                                    <th>Ações</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($grupos as $grupo) : ?>
                                                    <tr>
                                                        <td scope="col" style="width: 10px;">
                                                            <div class="form-check">
                                                                <input class="form-check-input fs-15" name="grupo[]" type="checkbox" id="checkAll" value="<?= $grupo['id'] ?>">
                                                            </div>
                                                        </td>
                                                        <td><b><?= $grupo['subject'] ?> <br><?= $grupo['id'] ?></b></td>
                                                        <td><?= date('d/m/Y H:i:s', $grupo['creation']) ?></td>
                                                        <td><?= (isset($grupo['owner'])) ? $grupo['owner'] : '' ?></td>
                                                        <td><span class="badge badge-soft-success p-2"><?= count($grupo['participants']) ?></span></td>
                                                        <td>
                                                            <div class="text-nowrap"></div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody><!-- end tbody -->
                                        </table><!-- end table -->
                                        <!-- Button trigger modal -->
                                        <div class="p-2">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sendMessageModal">
                                                ENVIAR MENSAGEM
                                            </button>

                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createGroups">
                                                CRIAR GRUPOS
                                            </button>

                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editGroups">
                                                EDITAR EM MASSA
                                            </button>
                                        </div>

                                    </div><!-- end table responsive -->
                                </div><!-- end card body -->
                            </div><!-- end card -->
                        </div>

                    </div>