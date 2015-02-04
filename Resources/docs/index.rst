Connector installation
======================

First of all add OXID connector bundle to your project:

.. code-block:: bash

composer require ongr/oxid-connector-bundle

..

Then add ConnectionsBundle and OXIDConnectorBundle to ``AppKernel.php``

.. code-block:: php

    new ONGR\ConnectionsBundle\ONGRConnectionsBundle(),
    new ONGR\OXIDConnectorBundle\ONGROXIDConnectorBundle(),

..

Then in your bundle you will need to extend ``Documents`` and ``Entities`` provided in OXIDConnectorBundle
in following locations:

- ``OXIDConnectorBundle/Document`` for documents
- ``OXIDConnectorBundle/Entity`` for entities

Then you will need to add mappings for these documents and entities. Examples:

.. code-block:: yaml

    orm:
        auto_generate_proxy_classes: "%kernel.debug%"
        auto_mapping: true
        mappings:
            ONGROXIDConnectorBundle:
                type: annotation
                alias: OXIDConnectorBundle
                dir: Entity
                prefix: ONGR\OXIDConnectorBundle\Entity
                is_bundle: true
            ONGRDemoOXIDBundle:
                type: annotation
                alias: DemoOXIDBundle
                dir: Entity
                prefix: ONGR\DemoOXIDBundle\Entity
                is_bundle: true

..

.. code-block:: yaml

    ongr_elasticsearch:
        managers:
            default:
                mappings:
                    - ONGROXIDConnectorBundle
                    - ONGRDemoOXIDBundle
..

Then add configuration for bundles.
Detailed information for ``ongr_connections`` configuration with information why and how everything works here :doc:`imports`.
``ongr_oxid`` configuration is still under development and may change or be removed in future.

.. code-block:: yaml

    ongr_connections:
        active_shop: oxid
        shops:
            oxid:
                shop_id: 0
        sync:
            sync_storage:
                mysql:
                    connection: default
                    table_name: ongr_sync_storage

    ongr_oxid:
        database_mapping:
            oxid:
                tags:
                    @shop_tag: '_1'
                    @lang_tag: '_1_en'
                shop_id: 0
                lang_id: 0
        entity_namespace: ONGRDemoOXIDBundle

..

Then you will need to configure import and sync pipelines.
Detailed information how pipeline works :doc:`components/ConnectionsBundle/Resources/doc/pipeline/pipeline`

Example import
--------------

.. code-block:: yaml

    parameters:
        ongr_demo.oxid.import.finish.class: ONGR\ConnectionsBundle\EventListener\ImportFinishEventListener

        ongr_demo.oxid.import.product.modifier.class: ONGR\OXIDConnectorBundle\Modifier\ProductModifier
        ongr_demo.oxid.import.category.modifier.class: ONGR\OXIDConnectorBundle\Modifier\CategoryModifier
        ongr_demo.oxid.import.content.modifier.class: ONGR\OXIDConnectorBundle\Modifier\ContentModifier

        ongr_demo.oxid.import.product.doctrine_entity_type: DemoOXIDBundle:Article
        ongr_demo.oxid.import.product.elastic_document_type: ONGRDemoOXIDBundle:ProductDocument

        ongr_demo.oxid.import.category.doctrine_entity_type: DemoOXIDBundle:Category
        ongr_demo.oxid.import.category.elastic_document_type: ONGRDemoOXIDBundle:CategoryDocument

        ongr_demo.oxid.import.content.doctrine_entity_type: DemoOXIDBundle:Content
        ongr_demo.oxid.import.content.elastic_document_type: ONGRDemoOXIDBundle:ContentDocument

    services:
        # Product.
        ongr_demo.oxid.import.product.source:
            class: %ongr_connections.import.source.class%
            parent: ongr_connections.import.source
            arguments:
                - @doctrine.orm.default_entity_manager
                - %ongr_demo.oxid.import.product.doctrine_entity_type%
                - @es.manager.oxid
                - %ongr_demo.oxid.import.product.elastic_document_type%
            tags:
                - { name: kernel.event_listener, event: ongr.pipeline.import.oxid.product.source, method: onSource }

        ongr_demo.oxid.import.product.modifier:
            class: %ongr_demo.oxid.import.product.modifier.class%
            arguments:
                - @ongr_oxid.attr_to_doc_service
            tags:
                - { name: kernel.event_listener, event: ongr.pipeline.import.oxid.product.modify, method: onModify }

        ongr_demo.oxid.import.product.consumer:
            class: %ongr_connections.import.consumer.class%
            parent: ongr_connections.import.consumer
            arguments:
                - @es.manager.oxid
            tags:
                - { name: kernel.event_listener, event: ongr.pipeline.import.oxid.product.consume, method: onConsume }

        # Category.
        ongr_demo.oxid.import.category.source:
            class: %ongr_connections.import.source.class%
            parent: ongr_connections.import.source
            arguments:
                - @doctrine.orm.default_entity_manager
                - %ongr_demo.oxid.import.category.doctrine_entity_type%
                - @es.manager.oxid
                - %ongr_demo.oxid.import.category.elastic_document_type%
            tags:
                - { name: kernel.event_listener, event: ongr.pipeline.import.oxid.category.source, method: onSource }

        ongr_demo.oxid.import.category.modifier:
            class: %ongr_demo.oxid.import.category.modifier.class%
            arguments:
                - @ongr_oxid.attr_to_doc_service
            tags:
                - { name: kernel.event_listener, event: ongr.pipeline.import.oxid.category.modify, method: onModify }

        ongr_demo.oxid.import.category.consumer:
            class: %ongr_connections.import.consumer.class%
            parent: ongr_connections.import.consumer
            arguments:
                - @es.manager.oxid
            tags:
                - { name: kernel.event_listener, event: ongr.pipeline.import.oxid.category.consume, method: onConsume }

        # Content.
        ongr_demo.oxid.import.content.source:
            class: %ongr_connections.import.source.class%
            parent: ongr_connections.import.source
            arguments:
                - @doctrine.orm.default_entity_manager
                - %ongr_demo.oxid.import.content.doctrine_entity_type%
                - @es.manager.oxid
                - %ongr_demo.oxid.import.content.elastic_document_type%
            tags:
                - { name: kernel.event_listener, event: ongr.pipeline.import.oxid.content.source, method: onSource }

        ongr_demo.oxid.import.content.modifier:
            class: %ongr_demo.oxid.import.content.modifier.class%
            arguments:
                - @ongr_oxid.attr_to_doc_service
            tags:
                - { name: kernel.event_listener, event: ongr.pipeline.import.oxid.content.modify, method: onModify }

        ongr_demo.oxid.import.content.consumer:
            class: %ongr_connections.import.consumer.class%
            parent: ongr_connections.import.consumer
            arguments:
                - @es.manager.oxid
            tags:
                - { name: kernel.event_listener, event: ongr.pipeline.import.oxid.content.consume, method: onConsume }

        # All.
        ongr_demo.oxid.import.finish:
            class: %ongr_demo.oxid.import.finish.class%
            parent: ongr_connections.import.finish
            arguments:
                - @es.manager.oxid
            tags:
                - { name: kernel.event_listener, event: ongr.pipeline.import.oxid.product.finish, method: onFinish }
                - { name: kernel.event_listener, event: ongr.pipeline.import.oxid.category.finish, method: onFinish }
                - { name: kernel.event_listener, event: ongr.pipeline.import.oxid.content.finish, method: onFinish }

..

This configuration will allow importing with following commands:

.. code-block:: bash

    app/console ongr:import:full oxid.content
    app/console ongr:import:full oxid.category
    app/console ongr:import:full oxid.product

..

Example sync
------------

.. code-block:: yaml

    parameters:
        ongr_demo.oxid.sync.execute.shop_id: 0
        ongr_demo.oxid.sync.execute.chunk_size: 1

        ongr_demo.oxid.sync.execute.finish.class: ONGR\ConnectionsBundle\EventListener\ImportFinishEventListener\ImportFinishEventListener

        ongr_demo.oxid.sync.execute.product.sync_storage_document_type: product
        ongr_demo.oxid.sync.execute.product.doctrine_entity_type: DemoOXIDBundle:Article
        ongr_demo.oxid.sync.execute.product.elastic_document_type: ONGRDemoOXIDBundle:ProductDocument

        ongr_demo.oxid.sync.execute.category.sync_storage_document_type: category
        ongr_demo.oxid.sync.execute.category.doctrine_entity_type: DemoOXIDBundle:Category
        ongr_demo.oxid.sync.execute.category.elastic_document_type: ONGRDemoOXIDBundle:CategoryDocument

        ongr_demo.oxid.sync.execute.content.sync_storage_document_type: content
        ongr_demo.oxid.sync.execute.content.doctrine_entity_type: DemoOXIDBundle:Content
        ongr_demo.oxid.sync.execute.content.elastic_document_type: ONGRDemoOXIDBundle:ContentDocument

        ongr_demo.oxid.sync.execute.product.modifier.class: ONGR\OXIDConnectorBundle\Modifier\ProductModifier
        ongr_demo.oxid.sync.execute.category.modifier.class: ONGR\OXIDConnectorBundle\Modifier\CategoryModifier
        ongr_demo.oxid.sync.execute.content.modifier.class: ONGR\OXIDConnectorBundle\Modifier\ContentModifier

        ongr_demo.oxid.sync.provide.source.class: ONGR\ConnectionsBundle\EventListener\DataSyncSourceEventListener
        ongr_demo.oxid.sync.provide.consume.class: ONGR\ConnectionsBundle\EventListener\DataSyncConsumeEventListener

    services:
        # Product.
        ongr_demo.oxid.sync.execute.product.source:
            class: %ongr_connections.sync.execute.source.class%
            parent: ongr_connections.import.source
            arguments:
                - @doctrine.orm.default_entity_manager
                - %ongr_demo.oxid.sync.execute.product.doctrine_entity_type%
                - @es.manager.oxid
                - %ongr_demo.oxid.sync.execute.product.elastic_document_type%
                - @ongr_connections.sync.sync_storage
            calls:
                - [ setChunkSize, [ %ongr_demo.oxid.sync.execute.chunk_size% ] ]
                - [ setShopId, [ %ongr_demo.oxid.sync.execute.shop_id% ] ]
                - [ setDocumentType, [ %ongr_demo.oxid.sync.execute.product.sync_storage_document_type% ] ]
            tags:
                - { name: kernel.event_listener, event: ongr.pipeline.sync.execute.oxid.product.source, method: onSource }

        ongr_demo.oxid.sync.execute.product.modifier:
            class: %ongr_demo.oxid.sync.execute.product.modifier.class%
            arguments:
                - @ongr_oxid.attr_to_doc_service
            tags:
                - { name: kernel.event_listener, event: ongr.pipeline.sync.execute.oxid.product.modify, method: onModify }

        ongr_demo.oxid.sync.execute.product.consumer:
                class: %ongr_connections.sync.execute.consumer.class%
                parent: ongr_connections.sync.execute.consumer
                arguments:
                    - @es.manager.oxid
                    - %ongr_demo.oxid.sync.execute.product.elastic_document_type%
                    - @ongr_connections.sync.sync_storage
                tags:
                    - { name: kernel.event_listener, event: ongr.pipeline.sync.execute.oxid.product.consume, method: onConsume }

        # Category.
        ongr_demo.oxid.sync.execute.category.source:
            class: %ongr_connections.sync.execute.source.class%
            parent: ongr_connections.import.source
            arguments:
                - @doctrine.orm.default_entity_manager
                - %ongr_demo.oxid.sync.execute.category.doctrine_entity_type%
                - @es.manager.oxid
                - %ongr_demo.oxid.sync.execute.category.elastic_document_type%
                - @ongr_connections.sync.sync_storage
            calls:
                - [ setChunkSize, [ %ongr_demo.oxid.sync.execute.chunk_size% ] ]
                - [ setShopId, [ %ongr_demo.oxid.sync.execute.shop_id% ] ]
                - [ setDocumentType, [ %ongr_demo.oxid.sync.execute.category.sync_storage_document_type% ] ]
            tags:
                - { name: kernel.event_listener, event: ongr.pipeline.sync.execute.oxid.category.source, method: onSource }

        ongr_demo.oxid.sync.execute.category.modifier:
            class: %ongr_demo.oxid.sync.execute.category.modifier.class%
            arguments:
                - @ongr_oxid.attr_to_doc_service
            tags:
                - { name: kernel.event_listener, event: ongr.pipeline.sync.execute.oxid.category.modify, method: onModify }

        ongr_demo.oxid.sync.execute.category.consumer:
            class: %ongr_connections.sync.execute.consumer.class%
            parent: ongr_connections.sync.execute.consumer
            arguments:
                - @es.manager.oxid
                - %ongr_demo.oxid.sync.execute.category.elastic_document_type%
                - @ongr_connections.sync.sync_storage
            tags:
                - { name: kernel.event_listener, event: ongr.pipeline.sync.execute.oxid.category.consume, method: onConsume }

        # Content.
        ongr_demo.oxid.sync.execute.content.source:
            class: %ongr_connections.sync.execute.source.class%
            parent: ongr_connections.import.source
            arguments:
                - @doctrine.orm.default_entity_manager
                - %ongr_demo.oxid.sync.execute.content.doctrine_entity_type%
                - @es.manager.oxid
                - %ongr_demo.oxid.sync.execute.content.elastic_document_type%
                - @ongr_connections.sync.sync_storage
            calls:
                - [ setChunkSize, [ %ongr_demo.oxid.sync.execute.chunk_size% ] ]
                - [ setShopId, [ %ongr_demo.oxid.sync.execute.shop_id% ] ]
                - [ setDocumentType, [ %ongr_demo.oxid.sync.execute.content.sync_storage_document_type% ] ]
            tags:
                - { name: kernel.event_listener, event: ongr.pipeline.sync.execute.oxid.content.source, method: onSource }

        ongr_demo.oxid.sync.execute.content.modifier:
            class: %ongr_demo.oxid.sync.execute.content.modifier.class%
            arguments:
                - @ongr_oxid.attr_to_doc_service
            tags:
                - { name: kernel.event_listener, event: ongr.pipeline.sync.execute.oxid.content.modify, method: onModify }

        ongr_demo.oxid.sync.execute.content.consumer:
            class: %ongr_connections.sync.execute.consumer.class%
            parent: ongr_connections.sync.execute.consumer
            arguments:
                - @es.manager.oxid
                - %ongr_demo.oxid.sync.execute.content.elastic_document_type%
                - @ongr_connections.sync.sync_storage
            tags:
                - { name: kernel.event_listener, event: ongr.pipeline.sync.execute.oxid.content.consume, method: onConsume }

        # All.
        ongr_demo.oxid.sync.execute.finish:
            class: %ongr_demo.oxid.sync.execute.finish.class%
            parent: ongr_connections.import.finish
            arguments:
                - @es.manager.oxid
            tags:
                - { name: kernel.event_listener, event: ongr.pipeline.sync.execute.oxid.product.finish, method: onFinish }
                - { name: kernel.event_listener, event: ongr.pipeline.sync.execute.oxid.category.finish, method: onFinish }
                - { name: kernel.event_listener, event: ongr.pipeline.sync.execute.oxid.content.finish, method: onFinish }

        # Provide.
        ongr_demo.oxid.sync.provide.source:
            class: %ongr_demo.oxid.sync.provide.source.class%
            arguments:
                - @ongr_connections.sync.diff_provider.binlog_diff_provider
            tags:
                - { name: kernel.event_listener, event: ongr.pipeline.data_sync.oxid.source, method: onSource }

        ongr_demo.oxid.sync.provide.consume:
            class: %ongr_demo.oxid.sync.provide.consume.class%
            arguments:
                - @ongr_connections.sync.extractor.doctrine_extractor
            tags:
                - { name: kernel.event_listener, event: ongr.pipeline.data_sync.oxid.consume, method: onConsume }

..

This configuration will allow synchronizing with following commands:

.. code-block:: bash

    app/console ongr:sync:provide oxid

    app/console ongr:sync:execute oxid.content
    app/console ongr:sync:execute oxid.category
    app/console ongr:sync:execute oxid.product

..
