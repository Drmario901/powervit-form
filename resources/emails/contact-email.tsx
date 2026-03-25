import * as React from 'react';
import {
    Body,
    Column,
    Container,
    Head,
    Heading,
    Hr,
    Html,
    Img,
    Link,
    Preview,
    Row,
    Section,
    Text,
} from '@react-email/components';
import {
    Calendar,
    Globe,
    Mail,
    MessageSquare,
    Monitor,
    Phone,
    Sparkles,
    Tag,
    User,
} from 'lucide-react';

export interface ContactEmailProps {
    name: string;
    email: string;
    phone: string;
    subject?: string;
    message?: string;
    submittedAt: string;
    ipAddress: string;
    userAgent: string;
    logoUrl: string;
}

const accent = '#0d9488';
const accentMuted = '#ccfbf1';
const slate900 = '#0f172a';
const slate600 = '#475569';
const slate500 = '#64748b';
const slate200 = '#e2e8f0';
const slate50 = '#f8fafc';

const main = {
    backgroundColor: '#f1f5f9',
    fontFamily:
        '-apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Ubuntu,sans-serif',
};

const outer = {
    margin: '0 auto',
    padding: '40px 16px',
    maxWidth: '580px',
};

const card = {
    backgroundColor: '#ffffff',
    borderRadius: '16px',
    border: `1px solid ${slate200}`,
    overflow: 'hidden' as const,
};

const cardHeader = {
    background: `linear-gradient(135deg, ${accent} 0%, #0f766e 100%)`,
    padding: '28px 28px 24px',
    textAlign: 'center' as const,
};

const badge = {
    display: 'inline-block' as const,
    backgroundColor: 'rgba(255,255,255,0.2)',
    color: '#ffffff',
    fontSize: '11px',
    fontWeight: 700,
    letterSpacing: '0.08em',
    textTransform: 'uppercase' as const,
    padding: '6px 14px',
    borderRadius: '999px',
    marginBottom: '16px',
};

const logo = {
    margin: '0 auto 16px',
    display: 'block' as const,
};

const title = {
    color: '#ffffff',
    fontSize: '22px',
    fontWeight: 700,
    margin: '0 0 6px',
    lineHeight: '1.25',
};

const subtitle = {
    color: 'rgba(255,255,255,0.9)',
    fontSize: '14px',
    margin: '0',
    lineHeight: '1.5',
};

const cardBody = {
    padding: '28px 28px 8px',
};

const sectionTitle = {
    fontSize: '13px',
    fontWeight: 700,
    color: slate900,
    margin: '0 0 16px',
    letterSpacing: '-0.01em',
};

const label = {
    fontSize: '11px',
    fontWeight: 700,
    color: slate500,
    textTransform: 'uppercase' as const,
    letterSpacing: '0.06em',
    margin: '0 0 4px',
};

const value = {
    fontSize: '15px',
    color: slate900,
    margin: '0',
    lineHeight: '1.55',
};

const metaSection = {
    backgroundColor: slate50,
    margin: '0 0 24px',
    padding: '20px',
    borderRadius: '12px',
    border: `1px solid ${slate200}`,
};

const footer = {
    padding: '0 28px 28px',
    textAlign: 'center' as const,
};

const footerText = {
    fontSize: '12px',
    color: slate500,
    margin: '0',
    lineHeight: '1.5',
};

const iconCell: React.CSSProperties = {
    width: '40px',
    verticalAlign: 'top' as const,
    paddingTop: '2px',
};

function FieldRow({
    icon,
    label: fieldLabel,
    children,
}: {
    icon: React.ReactNode;
    label: string;
    children: React.ReactNode;
}) {
    return (
        <Section style={{ marginBottom: '20px' }}>
            <Row>
                <Column style={iconCell}>{icon}</Column>
                <Column style={{ verticalAlign: 'top' as const }}>
                    <Text style={label}>{fieldLabel}</Text>
                    {children}
                </Column>
            </Row>
        </Section>
    );
}

export function ContactEmail({
    name,
    email,
    phone,
    subject,
    message,
    submittedAt,
    ipAddress,
    userAgent,
    logoUrl,
}: ContactEmailProps) {
    const previewText = `Nuevo contacto: ${name} · Powervit`;

    return (
        <Html>
            <Head />
            <Preview>{previewText}</Preview>
            <Body style={main}>
                <Container style={outer}>
                    <Section style={card}>
                        <Section style={cardHeader}>
                            <Text style={badge}>Formulario web</Text>
                            <Img src={logoUrl} width={150} alt="Powervit" style={logo} />
                            <Heading as="h1" style={title}>
                                Nuevo mensaje de contacto
                            </Heading>
                            <Text style={subtitle}>
                                Alguien ha escrito desde la web. Responde cuando puedas.
                            </Text>
                        </Section>

                        <Section style={cardBody}>
                            <Text style={sectionTitle}>Datos del contacto</Text>

                            <FieldRow
                                icon={<User size={20} color={accent} strokeWidth={2.25} aria-hidden />}
                                label="Nombre"
                            >
                                <Text style={value}>{name}</Text>
                            </FieldRow>

                            <FieldRow
                                icon={<Mail size={20} color={accent} strokeWidth={2.25} aria-hidden />}
                                label="Correo"
                            >
                                <Link
                                    href={`mailto:${email}`}
                                    style={{ ...value, color: accent, fontWeight: 600 }}
                                >
                                    {email}
                                </Link>
                            </FieldRow>

                            <FieldRow
                                icon={<Phone size={20} color={accent} strokeWidth={2.25} aria-hidden />}
                                label="Teléfono"
                            >
                                <Text style={value}>{phone}</Text>
                            </FieldRow>

                            {subject ? (
                                <FieldRow
                                    icon={<Tag size={20} color={accent} strokeWidth={2.25} aria-hidden />}
                                    label="Asunto"
                                >
                                    <Text style={value}>{subject}</Text>
                                </FieldRow>
                            ) : null}

                            {message ? (
                                <Section style={{ marginBottom: '24px' }}>
                                    <Row>
                                        <Column style={iconCell}>
                                            <MessageSquare
                                                size={20}
                                                color={accent}
                                                strokeWidth={2.25}
                                                aria-hidden
                                            />
                                        </Column>
                                        <Column>
                                            <Text style={label}>Mensaje</Text>
                                            <Section
                                                style={{
                                                    backgroundColor: accentMuted,
                                                    borderRadius: '10px',
                                                    padding: '14px 16px',
                                                    marginTop: '6px',
                                                    border: `1px solid rgba(13,148,136,0.15)`,
                                                }}
                                            >
                                                <Text
                                                    style={{
                                                        ...value,
                                                        whiteSpace: 'pre-wrap' as const,
                                                        margin: 0,
                                                    }}
                                                >
                                                    {message}
                                                </Text>
                                            </Section>
                                        </Column>
                                    </Row>
                                </Section>
                            ) : null}

                            <Hr
                                style={{
                                    borderColor: slate200,
                                    borderWidth: '1px 0 0',
                                    margin: '8px 0 20px',
                                }}
                            />

                            <Text style={{ ...sectionTitle, marginBottom: '14px' }}>
                                Detalles del envío
                            </Text>

                            <Section style={metaSection}>
                                <FieldRow
                                    icon={
                                        <Calendar size={18} color={slate600} strokeWidth={2} aria-hidden />
                                    }
                                    label="Fecha y hora"
                                >
                                    <Text style={{ ...value, color: slate600 }}>{submittedAt}</Text>
                                </FieldRow>

                                <FieldRow
                                    icon={<Globe size={18} color={slate600} strokeWidth={2} aria-hidden />}
                                    label="Dirección IP"
                                >
                                    <Text
                                        style={{
                                            ...value,
                                            color: slate600,
                                            fontFamily: 'ui-monospace, SFMono-Regular, Menlo, monospace',
                                            fontSize: '13px',
                                        }}
                                    >
                                        {ipAddress}
                                    </Text>
                                </FieldRow>

                                <FieldRow
                                    icon={<Monitor size={18} color={slate600} strokeWidth={2} aria-hidden />}
                                    label="User-Agent"
                                >
                                    <Text
                                        style={{
                                            ...value,
                                            color: slate600,
                                            fontFamily: 'ui-monospace, SFMono-Regular, Menlo, monospace',
                                            fontSize: '12px',
                                            lineHeight: '1.45',
                                        }}
                                    >
                                        {userAgent}
                                    </Text>
                                </FieldRow>
                            </Section>
                        </Section>

                        <Section style={footer}>
                            <Row style={{ marginBottom: '12px' }}>
                                <Column style={{ width: '100%', textAlign: 'center' as const }}>
                                    <Sparkles
                                        size={16}
                                        color={accent}
                                        strokeWidth={2}
                                        style={{ display: 'inline-block' }}
                                        aria-hidden
                                    />
                                </Column>
                            </Row>
                            <Text style={footerText}>
                                Este correo se generó automáticamente desde el formulario de contacto de{' '}
                                <span style={{ color: accent, fontWeight: 600 }}>Powervit</span>.
                            </Text>
                        </Section>
                    </Section>
                </Container>
            </Body>
        </Html>
    );
}
