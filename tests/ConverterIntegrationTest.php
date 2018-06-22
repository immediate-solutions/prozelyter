<?php
namespace ImmediateSolutions\Prozelyter\Tests;

use ImmediateSolutions\Prozelyter\Converter;
use ImmediateSolutions\Prozelyter\Reader\CsvReader;
use ImmediateSolutions\Prozelyter\Writer\HtmlWriter;
use ImmediateSolutions\Prozelyter\Writer\JsonWriter;
use ImmediateSolutions\Prozelyter\Writer\SqliteWriter;
use ImmediateSolutions\Prozelyter\Writer\XmlWriter;
use ImmediateSolutions\Prozelyter\Writer\YamlWriter;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ConverterIntegrationTest extends TestCase
{
    public function testJsonConvert()
    {
        $reader = new CsvReader(__DIR__.'/data/hotels.csv');
        $writer = new JsonWriter(__DIR__.'/data/hotels.json');

        $converter = new Converter($reader, $writer);

        $converter->convert();

        $json = file_get_contents((__DIR__.'/data/hotels.json'));

        Assert::assertEquals('[{"name":"Hotel A","address":"Street A","stars":"5","contact":"Person A","phone":"111-111-1111","uri":"https:\/\/hotel-a.com"},{"name":"Hotel B","address":"Street B","stars":"2","contact":"Person B","phone":"222-222-2222","uri":"https:\/\/hotel-b.com"},{"name":"Hotel C","address":"Street C","stars":"0","contact":"Person C","phone":"333-333-3333","uri":"https:\/\/hotel-c.com"}]', $json);

        unlink(__DIR__.'/data/hotels.json');
    }

    public function testXmlConverter()
    {
        $reader = new CsvReader(__DIR__.'/data/hotels.csv');
        $writer = new XmlWriter(__DIR__.'/data/hotels.xml');

        $converter = new Converter($reader, $writer);

        $converter->convert();

        $xml = file_get_contents((__DIR__.'/data/hotels.xml'));

        Assert::assertEquals('<?xml version="1.0" encoding="UTF-8"?>
<rows><row><name>Hotel A</name><address>Street A</address><stars>5</stars><contact>Person A</contact><phone>111-111-1111</phone><uri>https://hotel-a.com</uri></row><row><name>Hotel B</name><address>Street B</address><stars>2</stars><contact>Person B</contact><phone>222-222-2222</phone><uri>https://hotel-b.com</uri></row><row><name>Hotel C</name><address>Street C</address><stars>0</stars><contact>Person C</contact><phone>333-333-3333</phone><uri>https://hotel-c.com</uri></row></rows>
', $xml);

       unlink(__DIR__.'/data/hotels.xml');
    }

    public function testHtmlConverter()
    {
        $reader = new CsvReader(__DIR__.'/data/hotels.csv');
        $writer = new HtmlWriter(__DIR__.'/data/hotels.html');

        $converter = new Converter($reader, $writer);

        $converter->convert();

        $html = file_get_contents((__DIR__.'/data/hotels.html'));

        Assert::assertEquals('<html><body><table><th>name</th><th>address</th><th>stars</th><th>contact</th><th>phone</th><th>uri</th><tr><td>Hotel A</td><td>Street A</td><td>5</td><td>Person A</td><td>111-111-1111</td><td>https://hotel-a.com</td></tr><tr><td>Hotel B</td><td>Street B</td><td>2</td><td>Person B</td><td>222-222-2222</td><td>https://hotel-b.com</td></tr><tr><td>Hotel C</td><td>Street C</td><td>0</td><td>Person C</td><td>333-333-3333</td><td>https://hotel-c.com</td></tr></table></body></html>', $html);

        unlink(__DIR__.'/data/hotels.html');
    }

    public function testYamlConverter()
    {
        $reader = new CsvReader(__DIR__.'/data/hotels.csv');
        $writer = new YamlWriter(__DIR__.'/data/hotels.yml');

        $converter = new Converter($reader, $writer);

        $converter->convert();

        $yml = file_get_contents((__DIR__.'/data/hotels.yml'));

        Assert::assertEquals('-
    name: \'Hotel A\'
    address: \'Street A\'
    stars: \'5\'
    contact: \'Person A\'
    phone: 111-111-1111
    uri: \'https://hotel-a.com\'
-
    name: \'Hotel B\'
    address: \'Street B\'
    stars: \'2\'
    contact: \'Person B\'
    phone: 222-222-2222
    uri: \'https://hotel-b.com\'
-
    name: \'Hotel C\'
    address: \'Street C\'
    stars: \'0\'
    contact: \'Person C\'
    phone: 333-333-3333
    uri: \'https://hotel-c.com\'
', $yml);

        unlink(__DIR__.'/data/hotels.yml');
    }

    public function testSqliteConverter()
    {
        $reader = new CsvReader(__DIR__.'/data/hotels.csv');
        $writer = new SqliteWriter(__DIR__.'/data/hotels.db');

        $converter = new Converter($reader, $writer);

        $converter->convert();

        $pdo = new \PDO('sqlite:'.__DIR__.'/data/hotels.db');

        $data = $pdo->query('SELECT * FROM rows')->fetchAll(\PDO::FETCH_ASSOC);

        Assert::assertEquals([
            'name' => 'Hotel A',
            'address' => 'Street A',
            'stars' => '5',
            'contact' => 'Person A',
            'phone' => '111-111-1111',
            'uri' => 'https://hotel-a.com'
        ], $data[0]);

        Assert::assertEquals([
            'name' => 'Hotel B',
            'address' => 'Street B',
            'stars' => '2',
            'contact' => 'Person B',
            'phone' => '222-222-2222',
            'uri' => 'https://hotel-b.com'
        ], $data[1]);

        Assert::assertEquals([
            'name' => 'Hotel C',
            'address' => 'Street C',
            'stars' => '0',
            'contact' => 'Person C',
            'phone' => '333-333-3333',
            'uri' => 'https://hotel-c.com'
        ], $data[2]);


        $pdo = null;

        unlink(__DIR__.'/data/hotels.db');
    }
}